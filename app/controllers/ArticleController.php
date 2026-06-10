<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Article.php';
require_once __DIR__ . '/../helpers/Uploader.php';

class ArticleController
{
    public function handle(string $uri): void
    {
        switch (true) {
            case $uri === '/admin/articles' || $uri === '/admin/articles/':
                $this->index(); break;
            case $uri === '/admin/articles/create':
                $this->create(); break;
            case $uri === '/admin/articles/edit':
                $this->edit(); break;
            case $uri === '/admin/articles/delete':
                $this->delete(); break;
            case $uri === '/admin/articles/show':
                $this->show(); break;
            default:
                http_response_code(404);
                echo '<div class="p-10 text-center font-mono text-[#666] text-sm">[ 404 ] Page not found.</div>';
        }
    }

    private function generateSlug(string $title): string
    {
        $slug = strtolower(trim($title));
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        return trim($slug, '-') ?: 'untitled';
    }

    public function index(): void
    {
        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 10;
        $articles = Article::getAll($page, $perPage);
        $total = Article::count();
        $totalPages = max(1, (int)ceil($total / $perPage));

        $pageTitle = 'Articles';
        require_once __DIR__ . '/../views/admin/partials/admin_header.php';
        require __DIR__ . '/../views/admin/articles/index.php';
        require_once __DIR__ . '/../views/admin/partials/admin_footer.php';
    }

    public function create(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $slug = !empty(trim($_POST['slug'] ?? '')) ? trim($_POST['slug']) : $this->generateSlug($title);
            $content = $_POST['content'] ?? '';
            $status = $_POST['status'] ?? 'draft';
            $authorId = (int)($_SESSION['user_id'] ?? 0);
            $image = null;
            $error = null;

            if (!empty($_FILES['image']['name'])) {
                $image = Uploader::upload($_FILES['image']);
                if (!$image) $error = 'Image upload failed. Check file type (jpg/png/gif/webp) and size (max 2MB).';
            }

            if (empty($error)) {
                Article::create([
                    'title' => $title, 'slug' => $slug, 'content' => $content,
                    'image' => $image, 'author_id' => $authorId, 'status' => $status,
                ]);
                header('Location: /admin/articles');
                exit;
            }
        }

        $pageTitle = 'Create Article';
        require_once __DIR__ . '/../views/admin/partials/admin_header.php';
        require __DIR__ . '/../views/admin/articles/create.php';
        require_once __DIR__ . '/../views/admin/partials/admin_footer.php';
    }

    public function edit(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $article = Article::findById($id);

        if (!$article) {
            http_response_code(404);
            echo '<div class="p-10 text-center font-mono text-[#666] text-sm">[ 404 ] Article not found.</div>';
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => trim($_POST['title'] ?? ''),
                'slug' => !empty(trim($_POST['slug'] ?? '')) ? trim($_POST['slug']) : $this->generateSlug($_POST['title'] ?? ''),
                'content' => $_POST['content'] ?? '',
                'status' => $_POST['status'] ?? 'draft',
            ];
            $error = null;

            if (!empty($_FILES['image']['name'])) {
                $image = Uploader::upload($_FILES['image']);
                if ($image) {
                    Uploader::delete($article['image']);
                    $data['image'] = $image;
                } else {
                    $error = 'Image upload failed. Check file type and size.';
                }
            }

            if (empty($error)) {
                Article::update($id, $data);
                header('Location: /admin/articles');
                exit;
            }
        }

        $pageTitle = 'Edit Article';
        require_once __DIR__ . '/../views/admin/partials/admin_header.php';
        require __DIR__ . '/../views/admin/articles/edit.php';
        require_once __DIR__ . '/../views/admin/partials/admin_footer.php';
    }

    public function delete(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $article = Article::findById($id);
        if ($article) {
            Uploader::delete($article['image'] ?? null);
            Article::delete($id);
        }
        header('Location: /admin/articles');
        exit;
    }

    public function show(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $article = Article::findById($id);

        if (!$article) {
            http_response_code(404);
            echo '<div class="p-10 text-center font-mono text-[#666] text-sm">[ 404 ] Article not found.</div>';
            return;
        }

        $pageTitle = $article['title'];
        require_once __DIR__ . '/../views/admin/partials/admin_header.php';
        require __DIR__ . '/../views/admin/articles/show.php';
        require_once __DIR__ . '/../views/admin/partials/admin_footer.php';
    }
}
