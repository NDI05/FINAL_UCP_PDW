<?php
session_start();

require_once __DIR__ . '/../app/helpers/functions.php';

$dbConfig = __DIR__ . '/../config/database.php';
if (file_exists($dbConfig)) {
    require_once $dbConfig;
    $tracker = __DIR__ . '/../app/helpers/Visitor.php';
    if (file_exists($tracker)) {
        require_once $tracker;
    }
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = rtrim($uri, '/');

if ($uri === '/contact' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = @getDB();
    if ($db) {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $subject = trim($_POST['subject'] ?? '');
        $message = trim($_POST['message'] ?? '');

        if ($name && $email && $subject && $message) {
            $stmt = $db->prepare('INSERT INTO contacts (name, email, subject, message, created_at) VALUES (?, ?, ?, ?, NOW())');
            $stmt->bind_param('ssss', $name, $email, $subject, $message);
            $stmt->execute();
            header('Location: /contact?status=success');
            exit;
        }
    }
    header('Location: /contact?status=error');
    exit;
}

$routes = [
    '/'         => 'landing',
    '/about'    => 'about',
    '/services' => 'services',
    '/contact'  => 'contact',
];

$page = $routes[$uri] ?? 'landing';

if (function_exists('trackVisitor')) {
    trackVisitor();
}

require_once __DIR__ . '/../app/controllers/PageController.php';
$controller = new PageController();
$controller->render($page);
