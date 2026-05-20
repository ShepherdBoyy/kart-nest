<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;
use App\Core\Mailer;
use App\Models\User;

class PasswordResetService
{
    private const TOKEN_EXPIRY_SECONDS = 3600;

    public function sendResetLink(string $email): bool
    {
        $email = strtolower(trim($email));
        $user = User::findBy("email", $email);

        if ($user === null) {
            return true;
        }

        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM password_resets WHERE email = ?");
        $stmt->execute([$email]);

        $rawToken = bin2hex(random_bytes(32));
        $tokenHash = password_hash($rawToken, PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO password_resets
                (email, token_hash, expires_at)
            VALUES
                (?, ?, DATE_ADD(NOW(), INTERVAL 1 HOUR)
        ");
        $stmt->execute([$email, $tokenHash]);

        $resetUrl = rtrim($_ENV["APP_URL"], "/")
            . "/reset-password?token="
            . $rawToken
            . "&email="
            . urlencode($email);

        $body = Mailer::render("password-reset", [
            "userName" => $user["name"],
            "resetUrl" => $resetUrl,
            "expiry" => "1"
        ]);

        try {
            Mailer::send(
                to: $user["email"],
                name: $user["name"],
                subject: "Reset your KarNest password",
                body: $body
            );
        } catch (\RuntimeException $e) {
            error_log(
                "Password reset email failed for "
                . $email . ": " . $e->getMessage()
            );

            return false;
        }

        return true;
    }

    public function validateResetToken(string $rawToken): ?array
    {
        if (empty($rawToken)) {
            return null;
        }

        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("SELECT *
            FROM password_resets
            WHERE expires_at > NOW()
            ORDER BY created_at DESC
            LIMIT 100");
        $stmt->execute();
        $tokens = $stmt->fetchAll();

        foreach ($tokens as $token) {
            if (password_verify($rawToken, $token["token_hash"])) {
                return $token;
            }
        }

        return null;
    }

    public function resetPassword(string $rawToken, string $email, string $newPassword): bool
    {
        $email = strtolower(trim($email));

        $tokenRecord = $this->validateResetToken($rawToken);
        if ($tokenRecord === null) {
            return false;
        }
        if ($tokenRecord["email"] !== $email) {
            return true;
        }

        $user = User::findBy("email", $email);
        if ($user === null) {
            return false;
        }

        $hashedPassword = password_hash(
            $newPassword,
            PASSWORD_BCRYPT,
            ["cost" => 12]
        );
        User::update($user["id"], [
            "password" => $hashedPassword
        ]);

        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("DELETE FROM password_resets WHERE email = ?");
        $stmt->execute([$email]);

        $stmt = $db->prepare("DELETE FROM remember_tokens WHERE user_id = ?");
        $stmt->execute([$user["id"]]);

        return true;
    }

    public function validateNewPassword(array $data): array
    {
        $errors = [];

        $password = $data["password"] ?? "";
        $confirm = $data["password_confirmation"] ?? "";

        if (empty($password)) {
            $errors["password"][] = "Password is required";
        } elseif (mb_strlen($password) < 8) {
            $errors["password"][] = "Password must be atleast 8 characters";
        } elseif (mb_strlen($password) > 255) {
            $errors["password"][] = "Password must not exceed 255 characters";
        }

         if (empty($confirm)) {
            $errors["password_confirmation"][] = "Please confirm your password";
         } elseif ($password !== $confirm) {
            $errors["password_confirmation"][] = "Passwords do not match";
         }

         return $errors;
    }

    public function cleanupExpiredTokens(): int
    {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("DELETE FROM password_resets WHERE expires_at < NOW()");
        $stmt->execute();

        return $stmt->rowCount();
    }
}