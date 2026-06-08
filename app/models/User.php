<?php
require_once __DIR__ . '/../../config/database.php';

class User
{
    public static function findByUsername(string $username): ?array
    {
        $db = getDB();
        $stmt = $db->prepare('SELECT * FROM users WHERE username = ? LIMIT 1');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }

    public static function findByEmail(string $email): ?array
    {
        $db = getDB();
        $stmt = $db->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }

    public static function findById(int $id): ?array
    {
        $db = getDB();
        $stmt = $db->prepare('SELECT * FROM users WHERE id = ? LIMIT 1');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }

    public static function create(array $data): int
    {
        $db = getDB();
        $stmt = $db->prepare(
            'INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)'
        );
        $stmt->bind_param('ssss', $data['username'], $data['email'], $data['password'], $data['role']);
        $stmt->execute();
        return $stmt->insert_id;
    }
}
