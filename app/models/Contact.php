<?php
require_once __DIR__ . '/../../config/database.php';

class Contact
{
    public static function create(array $data): int
    {
        $db = getDB();
        $stmt = $db->prepare(
            'INSERT INTO contacts (name, email, subject, message, created_at) VALUES (?, ?, ?, ?, NOW())'
        );
        $stmt->bind_param('ssss', $data['name'], $data['email'], $data['subject'], $data['message']);
        $stmt->execute();
        return $stmt->insert_id;
    }

    public static function getAll(int $page = 1, int $perPage = 20): array
    {
        $db = getDB();
        $offset = ($page - 1) * $perPage;
        $stmt = $db->prepare(
            'SELECT * FROM contacts ORDER BY created_at DESC LIMIT ? OFFSET ?'
        );
        $stmt->bind_param('ii', $perPage, $offset);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public static function count(): int
    {
        $db = getDB();
        $result = $db->query('SELECT COUNT(*) AS cnt FROM contacts');
        return (int)($result->fetch_assoc()['cnt'] ?? 0);
    }
}
