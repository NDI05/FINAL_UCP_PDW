<?php
class Uploader
{
    private static array $allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    private static array $allowedMime = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    private static int $maxSize = 2 * 1024 * 1024;

    public static function upload(array $file): ?string
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, self::$allowedExt, true)) {
            return null;
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mime, self::$allowedMime, true)) {
            return null;
        }

        if ($file['size'] > self::$maxSize) {
            return null;
        }

        $timestamp = date('Ymd_His');
        $random = bin2hex(random_bytes(3));
        $filename = $timestamp . '_' . $random . '.' . $ext;

        $year = date('Y');
        $month = date('m');
        $dir = __DIR__ . '/../../public/uploads/articles/' . $year . '/' . $month;

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $dest = $dir . '/' . $filename;
        if (!move_uploaded_file($file['tmp_name'], $dest)) {
            return null;
        }

        return 'uploads/articles/' . $year . '/' . $month . '/' . $filename;
    }

    public static function delete(?string $path): bool
    {
        if (empty($path)) {
            return false;
        }
        $fullPath = __DIR__ . '/../../public/' . $path;
        if (file_exists($fullPath)) {
            return unlink($fullPath);
        }
        return false;
    }
}
