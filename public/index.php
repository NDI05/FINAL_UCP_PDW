<?php
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/helpers/functions.php';
require_once __DIR__ . '/../app/helpers/Visitor.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/PageController.php';
require_once __DIR__ . '/../app/controllers/ArticleController.php';
require_once __DIR__ . '/../app/controllers/ContactAdminController.php';
require_once __DIR__ . '/../app/controllers/UserController.php';
require_once __DIR__ . '/../app/controllers/SiteSettingController.php';
require_once __DIR__ . '/../app/controllers/ServiceAdminController.php';
require_once __DIR__ . '/../app/controllers/TeamAdminController.php';
require_once __DIR__ . '/../app/models/Contact.php';
require_once __DIR__ . '/../app/models/SiteSetting.php';
require_once __DIR__ . '/../app/models/Article.php';
require_once __DIR__ . '/../app/models/Service.php';
require_once __DIR__ . '/../app/models/TeamMember.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = rtrim($uri, '/') ?: '/';

$auth = new AuthController();

if ($uri === '/contact' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    if ($name && $email && $subject && $message) {
        Contact::create(['name' => $name, 'email' => $email, 'subject' => $subject, 'message' => $message]);
        header('Location: /contact?status=success');
        exit;
    }
    header('Location: /contact?status=error');
    exit;
}

if (str_starts_with($uri, '/admin')) {
    if ($uri === '/admin/login' || $uri === '/admin/login/') {
        trackVisitor();
        $auth->login();
        exit;
    }
    if ($uri === '/admin/logout' || $uri === '/admin/logout/') {
        $auth->logout();
        exit;
    }

    $auth->requireAuth();

    if ($uri === '/admin' || $uri === '/admin/') {
        trackVisitor();
        require_once __DIR__ . '/../app/views/admin/partials/admin_header.php';
        require __DIR__ . '/../app/views/admin/dashboard.php';
        require_once __DIR__ . '/../app/views/admin/partials/admin_footer.php';
        exit;
    }

    if (str_starts_with($uri, '/admin/articles')) {
        trackVisitor();
        $articleController = new ArticleController();
        $articleController->handle($uri);
        exit;
    }

    if (str_starts_with($uri, '/admin/contacts')) {
        trackVisitor();
        $contactController = new ContactAdminController();
        $contactController->handle($uri);
        exit;
    }

    if (str_starts_with($uri, '/admin/users')) {
        trackVisitor();
        $userController = new UserController();
        $userController->handle($uri);
        exit;
    }

    if (str_starts_with($uri, '/admin/settings')) {
        trackVisitor();
        $settingController = new SiteSettingController();
        $settingController->handle($uri);
        exit;
    }

    if (str_starts_with($uri, '/admin/services')) {
        trackVisitor();
        $serviceAdminController = new ServiceAdminController();
        $serviceAdminController->handle($uri);
        exit;
    }

    if (str_starts_with($uri, '/admin/team')) {
        trackVisitor();
        $teamAdminController = new TeamAdminController();
        $teamAdminController->handle($uri);
        exit;
    }

    http_response_code(404);
    echo '<div class="min-h-screen flex items-center justify-center bg-[#0a0a0a]"><p class="text-[#666] font-mono text-sm">[ 404 ] Admin page not found.</p></div>';
    exit;
}

if (preg_match('#^/articles/([a-z0-9-]+)$#', $uri, $m)) {
    trackVisitor();
    $article = Article::findBySlug($m[1]);
    if (!$article || $article['status'] !== 'published') {
        http_response_code(404);
        $pageTitle = 'Article Not Found — ' . SiteSetting::get('site_name', 'Nusa Data Indonesia');
        require_once __DIR__ . '/../app/views/partials/header.php';
        echo '<section class="min-h-screen flex items-center justify-center px-6"><div class="text-center"><p class="text-xs font-mono text-[#666] tracking-[.3em] uppercase">[ 404 ]</p><p class="text-sm font-mono text-[#333] mt-4">Article not found.</p><a href="/articles" class="inline-block mt-6 text-xs font-mono text-[#CCFF00] tracking-[.2em] uppercase hover:text-white no-underline">[ BACK TO ARTICLES ]</a></div></section>';
        require_once __DIR__ . '/../app/views/partials/footer.php';
        exit;
    }
    $pageTitle = htmlspecialchars($article['title']) . ' — ' . SiteSetting::get('site_name', 'Nusa Data Indonesia');
    require_once __DIR__ . '/../app/views/partials/header.php';
    require __DIR__ . '/../app/views/public/articles/show.php';
    require_once __DIR__ . '/../app/views/partials/footer.php';
    exit;
}

if ($uri === '/articles' || $uri === '/articles/') {
    trackVisitor();
    $page = max(1, (int)($_GET['page'] ?? 1));
    $perPage = 20;
    $articles = Article::getAllPublished($page, $perPage);
    $total = Article::countByStatus('published');
    $totalPages = max(1, (int)ceil($total / $perPage));
    $pageTitle = 'Articles — ' . SiteSetting::get('site_name', 'Nusa Data Indonesia');
    require_once __DIR__ . '/../app/views/partials/header.php';
    require __DIR__ . '/../app/views/public/articles/index.php';
    require_once __DIR__ . '/../app/views/partials/footer.php';
    exit;
}

trackVisitor();
$pageController = new PageController();
$pageController->render(ltrim($uri, '/'));
