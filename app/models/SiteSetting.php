<?php
require_once __DIR__ . '/../../config/database.php';

class SiteSetting
{
    public static function get(string $key, ?string $default = null): ?string
    {
        $db = getDB();
        $stmt = $db->prepare('SELECT `value` FROM site_settings WHERE `key` = ? LIMIT 1');
        $stmt->bind_param('s', $key);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row ? $row['value'] : $default;
    }

    public static function set(string $key, string $value): bool
    {
        $db = getDB();
        $stmt = $db->prepare('UPDATE site_settings SET `value` = ? WHERE `key` = ?');
        $stmt->bind_param('ss', $value, $key);
        return $stmt->execute();
    }

    public static function getAll(): array
    {
        $db = getDB();
        $result = $db->query('SELECT * FROM site_settings ORDER BY `group`, `key`');
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function getByGroup(string $group): array
    {
        $db = getDB();
        $stmt = $db->prepare('SELECT * FROM site_settings WHERE `group` = ? ORDER BY `key`');
        $stmt->bind_param('s', $group);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public static function update(string $key, array $data): bool
    {
        $db = getDB();
        $fields = [];
        $types = '';
        $values = [];

        $allowed = ['value', 'label', 'group'];
        foreach ($allowed as $field) {
            if (array_key_exists($field, $data)) {
                $fields[] = "`$field` = ?";
                $types .= 's';
                $values[] = $data[$field];
            }
        }

        if (empty($fields)) {
            return false;
        }

        $types .= 's';
        $values[] = $key;

        $sql = 'UPDATE site_settings SET ' . implode(', ', $fields) . ' WHERE `key` = ?';
        $stmt = $db->prepare($sql);
        $stmt->bind_param($types, ...$values);
        return $stmt->execute();
    }

    public static function create(array $data): bool
    {
        $db = getDB();
        $stmt = $db->prepare(
            'INSERT INTO site_settings (`key`, `value`, `label`, `group`) VALUES (?, ?, ?, ?)'
        );
        $key = $data['key'] ?? '';
        $value = $data['value'] ?? null;
        $label = $data['label'] ?? '';
        $group = $data['group'] ?? 'general';
        $stmt->bind_param('ssss', $key, $value, $label, $group);
        return $stmt->execute();
    }

    public static function delete(string $key): bool
    {
        $db = getDB();
        $stmt = $db->prepare('DELETE FROM site_settings WHERE `key` = ?');
        $stmt->bind_param('s', $key);
        return $stmt->execute();
    }
}
