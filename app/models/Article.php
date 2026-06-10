<?php
require_once __DIR__ . '/../../config/database.php';

class Article
{
    public static function getAll(int $page = 1, int $perPage = 10): array
    {
        $db = getDB();
        $offset = ($page - 1) * $perPage;
        $stmt = $db->prepare(
            'SELECT a.*, u.username AS author_name
             FROM articles a
             LEFT JOIN users u ON a.author_id = u.id
             ORDER BY a.created_at DESC
             LIMIT ? OFFSET ?'
        );
        $stmt->bind_param('ii', $perPage, $offset);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public static function findById(int $id): ?array
    {
        $db = getDB();
        $stmt = $db->prepare(
            'SELECT a.*, u.username AS author_name
             FROM articles a
             LEFT JOIN users u ON a.author_id = u.id
             WHERE a.id = ? LIMIT 1'
        );
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }

    public static function findBySlug(string $slug): ?array
    {
        $db = getDB();
        $stmt = $db->prepare(
            'SELECT a.*, u.username AS author_name
             FROM articles a
             LEFT JOIN users u ON a.author_id = u.id
             WHERE a.slug = ? LIMIT 1'
        );
        $stmt->bind_param('s', $slug);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }

    public static function create(array $data): int
    {
        $db = getDB();
        $stmt = $db->prepare(
            'INSERT INTO articles (title, slug, content, image, author_id, status)
             VALUES (?, ?, ?, ?, ?, ?)'
        );
        $stmt->bind_param(
            'ssssis',
            $data['title'], $data['slug'], $data['content'],
            $data['image'], $data['author_id'], $data['status']
        );
        $stmt->execute();
        return $stmt->insert_id;
    }

    public static function update(int $id, array $data): bool
    {
        $db = getDB();
        $fields = [];
        $types = '';
        $values = [];

        $allowed = ['title', 'slug', 'content', 'image', 'status'];
        foreach ($allowed as $field) {
            if (array_key_exists($field, $data)) {
                $fields[] = "$field = ?";
                $types .= 's';
                $values[] = $data[$field];
            }
        }
        if (empty($fields)) return false;
        $types .= 'i';
        $values[] = $id;

        $sql = 'UPDATE articles SET ' . implode(', ', $fields) . ' WHERE id = ?';
        $stmt = $db->prepare($sql);
        $stmt->bind_param($types, ...$values);
        return $stmt->execute();
    }

    public static function delete(int $id): bool
    {
        $db = getDB();
        $stmt = $db->prepare('DELETE FROM articles WHERE id = ?');
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    public static function count(): int
    {
        $db = getDB();
        $result = $db->query('SELECT COUNT(*) AS cnt FROM articles');
        return (int)($result->fetch_assoc()['cnt'] ?? 0);
    }

    public static function countByStatus(string $status): int
    {
        $db = getDB();
        $stmt = $db->prepare('SELECT COUNT(*) AS cnt FROM articles WHERE status = ?');
        $stmt->bind_param('s', $status);
        $stmt->execute();
        $result = $stmt->get_result();
        return (int)($result->fetch_assoc()['cnt'] ?? 0);
    }

    public static function getAllPublished(int $page = 1, int $perPage = 20): array
    {
        $db = getDB();
        $offset = ($page - 1) * $perPage;
        $stmt = $db->prepare(
            'SELECT a.*, u.username AS author_name
             FROM articles a
             LEFT JOIN users u ON a.author_id = u.id
             WHERE a.status = ?
             ORDER BY a.created_at DESC
             LIMIT ? OFFSET ?'
        );
        $status = 'published';
        $stmt->bind_param('sii', $status, $perPage, $offset);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
