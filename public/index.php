<?php
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/helpers/Mailer.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = rtrim($uri, '/') ?: '/';

// --- Contact form POST ---
if ($uri === '/contact' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name && $email && $subject && $message) {
        require_once __DIR__ . '/../app/helpers/Mailer.php';
        $db = @getDB();
        if ($db) {
            $stmt = $db->prepare('INSERT INTO contacts (name, email, subject, message, created_at) VALUES (?, ?, ?, ?, NOW())');
            $stmt->bind_param('ssss', $name, $email, $subject, $message);
            $stmt->execute();
        }
        // Mailer::send($email, $subject, $message);  // uncomment when SMTP configured
        header('Location: /contact?status=success');
        exit;
    }
    header('Location: /contact?status=error');
    exit;
}

// --- Public article detail ---
if (preg_match('#^/articles/([a-z0-9-]+)$#', $uri, $m)) {
    require_once __DIR__ . '/../app/controllers/ArticlePublicController.php';
    (new ArticlePublicController())->show($m[1]);
    exit;
}

// --- Public article listing ---
if ($uri === '/articles' || $uri === '/articles/') {
    require_once __DIR__ . '/../app/controllers/ArticlePublicController.php';
    (new ArticlePublicController())->index();
    exit;
}

http_response_code(404);
echo '<div class="min-h-screen flex items-center justify-center bg-[#0a0a0a]"><p class="text-[#666] font-mono text-sm">[ 404 ] Raja pages handles /articles/* and /contact POST.</p></div>';
