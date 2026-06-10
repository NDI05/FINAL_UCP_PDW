<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/helpers/Mailer.php';

class ArticlePublicController
{
    public function index(): void
    {
        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 20;
        $articles = $this->getAllPublished($page, $perPage);
        $total = $this->countPublished();
        $totalPages = max(1, (int)ceil($total / $perPage));

        $pageTitle = 'Articles';
        $this->render('articles/index', compact('articles', 'page', 'totalPages'));
    }

    public function show(string $slug): void
    {
        $db = getDB();
        $stmt = $db->prepare(
            'SELECT a.*, u.username AS author_name
             FROM articles a
             LEFT JOIN users u ON a.author_id = u.id
             WHERE a.slug = ? AND a.status = ?
             LIMIT 1'
        );
        $status = 'published';
        $stmt->bind_param('ss', $slug, $status);
        $stmt->execute();
        $article = $stmt->get_result()->fetch_assoc();

        if (!$article) {
            http_response_code(404);
            $this->render('partials/header', ['pageTitle' => 'Article Not Found']);
            echo '<section class="min-h-screen flex items-center justify-center px-6"><div class="text-center"><p class="text-xs font-mono text-[#666] tracking-[.3em] uppercase">[ 404 ]</p><p class="text-sm font-mono text-[#333] mt-4">Article not found.</p><a href="<?= baseUrl('/articles') ?>" class="inline-block mt-6 text-xs font-mono text-[#CCFF00] tracking-[.2em] uppercase hover:text-white no-underline">[ BACK TO ARTICLES ]</a></div></section>';
            $this->render('partials/footer');
            exit;
        }

        $this->render('articles/show', [
            'article' => $article,
            'pageTitle' => htmlspecialchars($article['title']),
        ]);
    }

    private function getAllPublished(int $page, int $perPage): array
    {
        $db = getDB();
        $offset = ($page - 1) * $perPage;
        $status = 'published';
        $stmt = $db->prepare(
            'SELECT a.*, u.username AS author_name
             FROM articles a
             LEFT JOIN users u ON a.author_id = u.id
             WHERE a.status = ?
             ORDER BY a.created_at DESC
             LIMIT ? OFFSET ?'
        );
        $stmt->bind_param('sii', $status, $perPage, $offset);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    private function countPublished(): int
    {
        $db = getDB();
        $status = 'published';
        $stmt = $db->prepare('SELECT COUNT(*) AS cnt FROM articles WHERE status = ?');
        $stmt->bind_param('s', $status);
        $stmt->execute();
        return (int)($stmt->get_result()->fetch_assoc()['cnt'] ?? 0);
    }

    private function render(string $view, array $data = []): void
    {
        extract($data);
        $file = __DIR__ . '/../views/' . $view . '.php';
        if (str_contains($view, 'partials')) {
            require $file;
        } else {
            $pageTitle = $pageTitle ?? 'NDI';
            require __DIR__ . '/../views/partials/header.php';
            require $file;
            require __DIR__ . '/../views/partials/footer.php';
        }
    }
}
