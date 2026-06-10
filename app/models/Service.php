<?php
require_once __DIR__ . '/../../config/database.php';

class Service
{
    public static function getAll(): array
    {
        $db = getDB();
        $result = $db->query('SELECT * FROM services ORDER BY order_num ASC, id ASC');
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function findById(int $id): ?array
    {
        $db = getDB();
        $stmt = $db->prepare('SELECT * FROM services WHERE id = ? LIMIT 1');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc() ?: null;
    }

    public static function create(array $data): int
    {
        $db = getDB();
        $stmt = $db->prepare('INSERT INTO services (title, description, image, order_num) VALUES (?, ?, ?, ?)');
        $stmt->bind_param('sssi', $data['title'], $data['description'], $data['image'], $data['order_num']);
        $stmt->execute();
        return $stmt->insert_id;
    }

    public static function update(int $id, array $data): bool
    {
        $db = getDB();
        $fields = [];
        $types = '';
        $values = [];

        $allowed = ['title', 'description', 'image', 'order_num'];
        foreach ($allowed as $field) {
            if (array_key_exists($field, $data)) {
                $fields[] = "$field = ?";
                if ($field === 'order_num') {
                    $types .= 'i';
                } else {
                    $types .= 's';
                }
                $values[] = $data[$field];
            }
        }
        if (empty($fields)) return false;
        $types .= 'i';
        $values[] = $id;

        $sql = 'UPDATE services SET ' . implode(', ', $fields) . ' WHERE id = ?';
        $stmt = $db->prepare($sql);
        $stmt->bind_param($types, ...$values);
        return $stmt->execute();
    }

    public static function delete(int $id): bool
    {
        $db = getDB();
        $stmt = $db->prepare('DELETE FROM services WHERE id = ?');
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    public static function count(): int
    {
        $db = getDB();
        $result = $db->query('SELECT COUNT(*) AS cnt FROM services');
        return (int)($result->fetch_assoc()['cnt'] ?? 0);
    }
}
