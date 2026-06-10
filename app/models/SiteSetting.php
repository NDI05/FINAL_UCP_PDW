<?php
require_once __DIR__ . '/../../config/database.php';

class SiteSetting
{
    public static function get(string $key, string $default = ''): string
    {
        $db = getDB();
        if (!$db) return $default;
        $stmt = $db->prepare('SELECT value FROM site_settings WHERE `key` = ? LIMIT 1');
        $stmt->bind_param('s', $key);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['value'] ?? $default;
    }

    public static function getAll(): array
    {
        $db = getDB();
        if (!$db) return [];
        $result = $db->query('SELECT * FROM site_settings ORDER BY `group`, `key`');
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function set(string $key, string $value): bool
    {
        $db = getDB();
        $stmt = $db->prepare(
            'INSERT INTO site_settings (`key`, `value`) VALUES (?, ?)
             ON DUPLICATE KEY UPDATE `value` = VALUES(`value`), updated_at = NOW()'
        );
        $stmt->bind_param('ss', $key, $value);
        $stmt->execute();
        return $stmt->affected_rows >= 0;
    }

    public static function setMany(array $data): void
    {
        foreach ($data as $key => $value) {
            self::set($key, $value);
        }
    }
}
