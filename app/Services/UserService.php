<?php

 declare(strict_types=1);

 namespace App\Services;

use App\Core\Database;
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

    public function validateLogin(array $data): Validator
    {
        $validator = new Validator($data);

        $validator->validate([
            "email" => ["required", "email"],
            "password" => ["required"]
        ]);

        return $validator;
    }

    public function attemptLogin(string $email, string $password): ?array
    {
        $user = $this->findByEmail($email);

        if ($user === null) {
            return null;
        }

        if (!$this->verifyPassword($password, $user["password"])) {
             return null;
        }

        if ($this->needsRehash($user["password"])) {
            $newHash = password_hash($password, PASSWORD_BCRYPT, ["cost" => 12]);
            User::update($user["id"], ["password" => $newHash]);
            $user["password"] = $newHash;
        }

        return $user;
    }

    public function createRememberToken(int $userId): string
    {
        $rawToken = bin2hex(random_bytes(32));
        $tokenHash = password_hash($rawToken, PASSWORD_DEFAULT);
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO remember_tokens
                (user_id, token_hash, expires_at)
            VALUES
                (?, ?, DATE_ADD(NOW(), INTERVAL 30 DAY))
        ");
        $stmt->execute([$userId, $tokenHash]);

        return $rawToken;
    }

    public function validateRememberToken(string $rawToken): ?array
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT rt.*, u.id AS user_id,
                u.name, u.email, u.role, u.password
            FROM remember_tokens rt
            JOIN users u ON u.id = rt.user_id
            WHERE rt.expires_at > NOW()
            ORDER BY created_at DESC
            LIMIT 200
        ");
        $stmt->execute();
        $tokens = $stmt->fetchAll();

        foreach ($tokens as $token) {
            if (password_verify($rawToken, $token["token_hash"])) {
                return $token;
            }
        }

        return null;
    }

    public function deleteRememberToken(string $rawToken): void
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT id, token_hash
            FROM remember_tokens
            WHERE expires_at > NOW()
            ORDER BY created_at DESC
            LIMIT 200
        ");
        $stmt->execute();
        $tokens = $stmt->fetchAll();

        foreach ($tokens as $token) {
            if (password_verify($rawToken, $token["token_hash"])) {
                $deleteStmt = $db->prepare("DELETE FROM remember_tokens WHERE id = ?");
                $deleteStmt->execute([$token["id"]]);
                return;
            }
        }
    }

    public function deleteAllRememberTokens(int $userId): void
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM remember_tokens WHERE user_id = ?");
        $stmt->execute([$userId]);
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