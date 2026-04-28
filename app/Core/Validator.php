<?php

declare(strict_types=1);

namespace App\Core;

class Validator
{
    private array $data;
    private array $errors = [];

    public function __construct(array $data)
    {
        $this->data = array_map(
            fn($value) => is_string($value) ? trim($value) : $value,
            $data
        );
    }

    public function validate(array $rules): static
    {
        foreach ($rules as $field => $fieldRules) {
            foreach ($fieldRules as $rule) {
                $parts = explode(":", $rule, 2);
                $ruleName = $parts[0];
                $ruleParam = $parts[1] ?? null;

                $value = $this->data[$field] ?? "";

                if ($value === "" && $ruleName !== "required") {
                    continue;
                }

                $methodName = "check" . ucfirst($ruleName);

                if (!method_exists($this, $methodName)) {
                    throw new \InvalidArgumentException(
                        "Validation rule [{$ruleName}] does not exist"
                    );
                }

                $error = $this->$methodName($field, $value, $ruleParam);

                if ($error !== null) {
                    $this->errors[$field][] = $error;
                }
            }
        }

        return $this;
    }

    public function fails(): bool
    {
        return !empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function firstError(string $field): ?string
    {
        return $this->errors[$field][0] ?? null;
    }

    public function getValue(string $field, mixed $default = ""): mixed
    {
        return $this->data[$field] ?? $default;
    }

    private function checkRequired(string $field, mixed $value, ?string $param): ?string
    {
        if ($value === "" || $value === null) {
            return $this->formatFieldName($field) . " is required";
        }

        return null;
    }

    private function checkEmail(string $field, mixed $value, ?string $param): ?string
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return $this->formatFieldName($field) . " must be a valid email address";
        }

        return null;
    }

    private function checkMin(string $field, mixed $value, ?string $param): ?string
    {
        $min = (int) $param;

        if (mb_strlen((string) $value) < $min) {
            return $this->formatFieldName($field) . " must be at least {$min} characters";
        }

         return null;
    }

    private function checkMax(string $field, mixed $value, ?string $param): ?string
    {
        $max = (int) $param;

        if (mb_strlen((string) $value) > $max) {
            return $this->formatFieldName($field) . " must not exceed {$max} characters";
        }

        return null;
    }

    private function checkUnique(string $field, mixed $value, ?string $param): ?string
    {
        if ($param === null) {
            throw new \InvalidArgumentException(
                "Rule [unique] requires a parameter. Example: 'unique:users,email'"
            );
        }

        $parts = explode(",", $param, 2);
        $table = $parts[0];
        $column = $parts[1] ?? $field;

        $table = preg_replace("/[^a-zA-Z0-9_]/", "", $table);
        $column = preg_replace("/[^a-zA-Z0-9_]/", "", $column);

        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare(
            "SELECT 1 FROM `{$table}` WHERE `{$column}` = ? LIMIT 1"
        );
        $stmt->execute([$value]);

        if ($stmt->fetchColumn() !== false) {
            return $this->formatFieldName($field) . " is already taken";
        }

        return null;
    }

    private function checkAlapha(string $field, mixed $value, ?string $param): ?string
    {
        if (!preg_match("/^[a-zA-Z\s]+$/", (string) $value)) {
            return $this->formatFieldName($field) . " must only contain letters";
        }

        return null;
    }

    private function checkNumeric(string $field, mixed $value, ?string $param): ?string
    {
        if (!is_numeric($value)) {
            return $this->formatFieldName($field) . " must be a number";
        }

        return null;
    }

    private function checkPositive(string $field, mixed $value, ?string $param): ?string
    {
        if (!is_numeric($value) || (float) $value <= 0) {
            return $this->formatFieldName($field) . " must be a positive number";
        }

        return null;
    }

    private function formatFieldName(string $field): string
    {
        return ucfirst(str_replace("_", " ", $field));
    }
}