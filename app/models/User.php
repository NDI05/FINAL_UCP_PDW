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
        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);
        $stmt = $db->prepare(
            'INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)'
        );
        $stmt->bind_param('ssss', $data['username'], $data['email'], $hashedPassword, $data['role']);
        $stmt->execute();
        return $stmt->insert_id;
    }

    public static function getAll(): array
    {
        $db = getDB();
        $result = $db->query('SELECT id, username, email, role, created_at FROM users ORDER BY id ASC');
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function updateRole(int $id, string $role): bool
    {
        $db = getDB();
        $allowed = ['admin', 'editor'];
        if (!in_array($role, $allowed, true)) return false;
        $stmt = $db->prepare('UPDATE users SET role = ? WHERE id = ?');
        $stmt->bind_param('si', $role, $id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public static function updatePassword(int $id, string $plainPassword): bool
    {
        $db = getDB();
        $hash = password_hash($plainPassword, PASSWORD_BCRYPT);
        $stmt = $db->prepare('UPDATE users SET password = ? WHERE id = ?');
        $stmt->bind_param('si', $hash, $id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public static function delete(int $id): bool
    {
        $db = getDB();
        $stmt = $db->prepare('DELETE FROM users WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public static function count(): int
    {
        $db = getDB();
        $result = $db->query('SELECT COUNT(*) AS cnt FROM users');
        return (int)($result->fetch_assoc()['cnt'] ?? 0);
    }
}
