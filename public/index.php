<?php
session_start();

require_once __DIR__ . '/../config/database.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = rtrim($uri, '/') ?: '/';

if ($uri === '/admin/logout') {
    $_SESSION = [];
    session_destroy();
    header('Location: /admin/login');
    exit;
}

if ($uri === '/admin/login') {
    $error = null;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $db = getDB();
        $stmt = $db->prepare('SELECT * FROM users WHERE username = ? OR email = ? LIMIT 1');
        $stmt->bind_param('ss', $username, $username);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            session_regenerate_id(true);
            header('Location: /admin/articles');
            exit;
        }
        $error = 'Invalid credentials.';
    }
    require __DIR__ . '/../app/views/admin/login.php';
    exit;
}

if (str_starts_with($uri, '/admin')) {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /admin/login');
        exit;
    }

    require_once __DIR__ . '/../app/controllers/ArticleController.php';
    $ctrl = new ArticleController();

    switch (true) {
        case $uri === '/admin/articles' || $uri === '/admin/articles/':
            $ctrl->index(); break;
        case $uri === '/admin/articles/create':
            $ctrl->create(); break;
        case $uri === '/admin/articles/edit':
            $ctrl->edit(); break;
        case $uri === '/admin/articles/delete':
            $ctrl->delete(); break;
        case $uri === '/admin/articles/show':
            $ctrl->show(); break;
        case $uri === '/admin' || $uri === '/admin/':
            header('Location: /admin/articles'); exit;
        default:
            http_response_code(404);
            require_once __DIR__ . '/../app/views/admin/partials/admin_header.php';
            echo '<div class="p-10 text-center font-mono text-[#666] text-sm">[ 404 ] Page not found.</div>';
            require_once __DIR__ . '/../app/views/admin/partials/admin_footer.php';
            break;
    }
    exit;
}

http_response_code(404);
echo '<div class="min-h-screen flex items-center justify-center bg-[#0a0a0a]"><p class="text-[#666] font-mono text-sm">[ 404 ] Tama CMS only handles /admin/articles/* routes.</p></div>';
