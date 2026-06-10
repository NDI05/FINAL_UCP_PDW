<?php
require_once __DIR__ . '/../../config/database.php';

class Visitor
{
    public static function record(string $ip, string $ua, string $page): bool
    {
        $db = getDB();
        $stmt = $db->prepare(
            'INSERT INTO visitors (ip_address, user_agent, page, visited_at) VALUES (?, ?, ?, NOW())'
        );
        $stmt->bind_param('sss', $ip, $ua, $page);
        $ok = $stmt->execute();

        $slug = $page === '/' ? 'home' : trim($page, '/');
        $title = match ($slug) {
            'home' => 'Home',
            'about' => 'About',
            'services' => 'Services',
            'contact' => 'Contact',
            default => $slug,
        };
        $stmt2 = $db->prepare(
            'INSERT INTO pages (slug, title, visits) VALUES (?, ?, 1)
             ON DUPLICATE KEY UPDATE visits = visits + 1'
        );
        $stmt2->bind_param('ss', $slug, $title);
        $stmt2->execute();

        return $ok;
    }

    public static function getTodayCount(): int
    {
        $db = getDB();
        $result = $db->query('SELECT COUNT(*) AS cnt FROM visitors WHERE DATE(visited_at) = CURDATE()');
        return (int)($result->fetch_assoc()['cnt'] ?? 0);
    }

    public static function getTotalCount(): int
    {
        $db = getDB();
        $result = $db->query('SELECT COUNT(*) AS cnt FROM visitors');
        return (int)($result->fetch_assoc()['cnt'] ?? 0);
    }

    public static function getTopPages(int $limit = 10): array
    {
        $db = getDB();
        $stmt = $db->prepare(
            'SELECT page, COUNT(*) AS visits FROM visitors GROUP BY page ORDER BY visits DESC LIMIT ?'
        );
        $stmt->bind_param('i', $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public static function getRecent(int $limit = 50): array
    {
        $db = getDB();
        $stmt = $db->prepare(
            'SELECT ip_address, page, visited_at FROM visitors ORDER BY visited_at DESC LIMIT ?'
        );
        $stmt->bind_param('i', $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
