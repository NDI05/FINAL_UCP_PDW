<?php
require_once __DIR__ . '/../../config/database.php';

class Visitor
{
    public static function record(string $ip, string $ua, string $page): bool
    {
        $db = getDB();
        if (!$db) return false;

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
}
