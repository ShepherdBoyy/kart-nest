<?php

declare(strict_types=1);

namespace App\Core;

class FileUploader
{
    private const MAX_SIZE = 5 * 1024 * 1024;
    private const ALLOWED_TYPES = [
        "image/jpeg" => ["jpg", "jpeg"],
        "image/png" => ["png"],
        "image/webp" => ["webp"],
        "image/gif" => ["gif"]
    ];
    private string $uploadDir;

    public function __construct(string $uploadDir)
    {
        $this->uploadDir = rtrim($uploadDir, "/");
    }

    public function upload(string $fileInput): string
    {
        if (!isset($_FILES[$fileInput])) {
            throw new \RuntimeException("No file was uploaded");
        }

        $file = $_FILES[$fileInput];
        $this->checkUploadError($file["error"]);

        if ($file["size"] > self::MAX_SIZE) {
            $maxMb = self::MAX_SIZE / 1024 / 1024;
            throw new \RuntimeException("File is too large. Maximum size is {$maxMb}MB");
        }

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file["tmp_name"]);

        if (!array_key_exists($mimeType, self::ALLOWED_TYPES)) {
            throw new \RuntimeException(
                "Invalid file type. Only JPG, PNG, WebP, and GIF images are allowed"
            );
        }

        $originalExt = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
        if (!in_array($originalExt, self::ALLOWED_TYPES[$mimeType], true)) {
            throw new \RuntimeException(
                "File extension does not match its content"
            );
        }

        $newFilename = bin2hex(random_bytes(16)) . "." . $originalExt;
        $fullUploadDir = ROOT_PATH . "/" . $this->uploadDir;

        if (!is_dir($fullUploadDir)) {
            mkdir($fullUploadDir, 0755, true);
        }

        $destination = $fullUploadDir . '/' . $newFilename;

        if (!move_uploaded_file($file["tmp_name"], $destination)) {
            throw new \RuntimeException(
                "Failed to save uploaded file. Please try again"
            );
        }

        return $newFilename;
    }

    public function delete(string $filename): void
    {
        if (empty($filename)) {
            return;
        }

        $path = ROOT_PATH . "/" . $this->uploadDir . "/" . $filename;
        if (file_exists($path)) {
            unlink($path);
        }
    }

    public function hasFile(string $fileInput): bool
    {
        if (!isset($_FILES[$fileInput])) {
            return false;
        }

        $file = $_FILES[$fileInput];

        if ($file["error"] === UPLOAD_ERR_NO_FILE) {
            return false;
        }

        if ($file["size"] === 0) {
            return false;
        }

        if (empty($file["tmp_name"]) || !is_uploaded_file($file["tmp_name"])) {
            return false;
        }

        return true;
    }

    private function checkUploadError(int $errorCode): void
    {
        if ($errorCode === UPLOAD_ERR_OK) {
            return;
        }

        $errors = [
            UPLOAD_ERR_INI_SIZE => "File exceeds the server upload limit",
            UPLOAD_ERR_FORM_SIZE => "File exceeds the form upload limit",
            UPLOAD_ERR_PARTIAL => "File was only partialy uploaded",
            UPLOAD_ERR_NO_FILE => "No file was uploaded",
            UPLOAD_ERR_NO_TMP_DIR => "Server temporary folder is missing",
            UPLOAD_ERR_CANT_WRITE => "Failed to write file to disk",
            UPLOAD_ERR_EXTENSION => "Upload blocked by server extension"
        ];

        $message = $errors[$errorCode] ?? "Unknown upload error occurred";

        throw new \RuntimeException($message);
    }
}