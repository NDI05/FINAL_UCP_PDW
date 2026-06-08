<?php
require_once __DIR__ . '/../models/Visitor.php';

function trackVisitor(): void
{
    $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $page = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    Visitor::record($ip, $ua, $page);

    $slug = $page === '/' ? 'home' : trim($page, '/');
    $title = match ($slug) {
        'home' => 'Home',
        'about' => 'About',
        'services' => 'Services',
        'contact' => 'Contact',
        default => $slug,
    };

    $db = getDB();
    $stmt = $db->prepare(
        'INSERT INTO pages (slug, title, visits) VALUES (?, ?, 1)
         ON DUPLICATE KEY UPDATE visits = visits + 1'
    );
    $stmt->bind_param('ss', $slug, $title);
    $stmt->execute();
}
