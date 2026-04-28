<?php

 declare(strict_types=1);

 namespace App\Services;

use App\Core\Validator;
use App\Models\User;

 class UserService
 {
    public function validateRegistration(array $data): Validator
    {
        $validator = new Validator($data);

        $validator->validate([
           "name" => ["required", "min:2", "max:100"],
           "email" => ["required", "email", "max:150", "unique:users,email"],
           "password" => ["required", "min:8", "max:255"],
           "password_confirmation" => ["required"]
        ]);

        if (!$validator->fails()) {
            $password = $data["password"] ?? "";
            $passwordConfirmation = $data["password_confirmation"] ?? "";

            if ($password !== $passwordConfirmation) {
                $validator->validate([
                    "password_confirmation" => ["confirmed:password"]
                ]);
            }
        }

        return $validator;
    }

    public function register(array $data): int
    {
        $hashedPassword = password_hash(
            $data["password"],
            PASSWORD_BCRYPT,
            ["cost" => 12]
        );

        $userId = User::create([
            "name" => $data["name"],
            "email" => strtolower(trim($data["email"])),
            "password" => $hashedPassword,
            "role" => "buyer"
        ]);

        return $userId;
    }

    public function findByEmail(string $email): ?array
    {
        return User::findBy("email", strtolower(trim($email)));
    }

    public function verifyPassword(string $plainPassword, string $hashedPassword): bool
    {
        return password_verify($plainPassword, $hashedPassword);
    }

    public function needsRehash(string $hashedPassword): bool
    {
        return password_needs_rehash($hashedPassword, PASSWORD_BCRYPT, ["cost" => 12]);
    }
 }