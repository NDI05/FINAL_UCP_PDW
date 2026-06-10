<?php
class Uploader
{
    private static array $allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    private static array $allowedMime = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    private static int $maxSize = 2 * 1024 * 1024;

    public static function upload(array $file): ?string
    {
        if ($file['error'] !== UPLOAD_ERR_OK) return null;

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, self::$allowedExt, true)) return null;

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        if (!in_array($mime, self::$allowedMime, true)) return null;

        if ($file['size'] > self::$maxSize) return null;

        $timestamp = date('Ymd_His');
        $random = bin2hex(random_bytes(3));
        $filename = $timestamp . '_' . $random . '.' . $ext;

        $year = date('Y');
        $month = date('m');
        $dir = __DIR__ . '/../../public/uploads/articles/' . $year . '/' . $month;

        if (!is_dir($dir)) mkdir($dir, 0755, true);

        $dest = $dir . '/' . $filename;
        if (!move_uploaded_file($file['tmp_name'], $dest)) return null;

        return 'uploads/articles/' . $year . '/' . $month . '/' . $filename;
    }

    public static function uploadAndCropSquare(array $file, int $targetSize = 600): ?string
    {
        if ($file['error'] !== UPLOAD_ERR_OK) return null;

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, self::$allowedExt, true)) return null;

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        if (!in_array($mime, self::$allowedMime, true)) return null;

        if ($file['size'] > self::$maxSize) return null;

        switch ($mime) {
            case 'image/jpeg':
                $srcImg = @imagecreatefromjpeg($file['tmp_name']);
                break;
            case 'image/png':
                $srcImg = @imagecreatefrompng($file['tmp_name']);
                break;
            case 'image/gif':
                $srcImg = @imagecreatefromgif($file['tmp_name']);
                break;
            case 'image/webp':
                $srcImg = @imagecreatefromwebp($file['tmp_name']);
                break;
            default:
                return null;
        }

        if (!$srcImg) return null;

        $width = imagesx($srcImg);
        $height = imagesy($srcImg);

        $cropSize = min($width, $height);
        $x = ($width - $cropSize) / 2;
        $y = ($height - $cropSize) / 2;

        $dstImg = imagecreatetruecolor($targetSize, $targetSize);

        if ($mime === 'image/png' || $mime === 'image/webp' || $mime === 'image/gif') {
            imagealphablending($dstImg, false);
            imagesavealpha($dstImg, true);
            $transparent = imagecolorallocatealpha($dstImg, 255, 255, 255, 127);
            imagefilledrectangle($dstImg, 0, 0, $targetSize, $targetSize, $transparent);
        }

        imagecopyresampled($dstImg, $srcImg, 0, 0, $x, $y, $targetSize, $targetSize, $cropSize, $cropSize);

        $timestamp = date('Ymd_His');
        $random = bin2hex(random_bytes(3));
        $filename = $timestamp . '_' . $random . '.' . $ext;

        $year = date('Y');
        $month = date('m');
        $dir = __DIR__ . '/../../public/uploads/articles/' . $year . '/' . $month;
        if (!is_dir($dir)) mkdir($dir, 0755, true);

        $dest = $dir . '/' . $filename;

        $saved = false;
        switch ($mime) {
            case 'image/jpeg':
                $saved = imagejpeg($dstImg, $dest, 90);
                break;
            case 'image/png':
                $saved = imagepng($dstImg, $dest);
                break;
            case 'image/gif':
                $saved = imagegif($dstImg, $dest);
                break;
            case 'image/webp':
                $saved = imagewebp($dstImg, $dest, 90);
                break;
        }

        imagedestroy($srcImg);
        imagedestroy($dstImg);

        if (!$saved) return null;

        return 'uploads/articles/' . $year . '/' . $month . '/' . $filename;
    }

    public static function delete(?string $path): bool
    {
        if (empty($path)) return false;
        $fullPath = __DIR__ . '/../../public/' . $path;
        return file_exists($fullPath) && unlink($fullPath);
    }
}
