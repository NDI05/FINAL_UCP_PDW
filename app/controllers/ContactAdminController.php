<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Contact.php';

class ContactAdminController
{
    private function requireAuth(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . baseUrl('/admin/login'));
            exit;
        }
    }

    public function handle(string $uri): void
    {
        $path = str_replace('/admin/contacts', '', $uri);
        $path = rtrim($path, '/') ?: '/';

        match(true) {
            $path === '/show' => $this->show(),
            $path === '/delete' => $this->delete(),
            default => $this->index(),
        };
    }

    public function index(): void
    {
        $this->requireAuth();
        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 10;
        $contacts = Contact::getAll($page, $perPage);
        $total = Contact::count();
        $totalPages = max(1, (int)ceil($total / $perPage));

        $pageTitle = 'Contacts';
        require_once __DIR__ . '/../views/admin/partials/admin_header.php';
        require __DIR__ . '/../views/admin/contacts/index.php';
        require_once __DIR__ . '/../views/admin/partials/admin_footer.php';
    }

    public function show(): void
    {
        $this->requireAuth();
        $id = (int)($_GET['id'] ?? 0);
        $contact = $this->findById($id);

        if (!$contact) {
            http_response_code(404);
            echo '<div class="p-10 text-center font-mono text-[#666] text-sm">[ 404 ] Contact not found.</div>';
            return;
        }

        $pageTitle = 'Contact: ' . htmlspecialchars($contact['name']);
        require_once __DIR__ . '/../views/admin/partials/admin_header.php';
        require __DIR__ . '/../views/admin/contacts/show.php';
        require_once __DIR__ . '/../views/admin/partials/admin_footer.php';
    }

    public function delete(): void
    {
        $this->requireAuth();
        $id = (int)($_GET['id'] ?? 0);

        if ($id > 0) {
            $this->deleteById($id);
        }

        header('Location: ' . baseUrl('/admin/contacts'));
        exit;
    }

    private function findById(int $id): ?array
    {
        $db = getDB();
        $stmt = $db->prepare('SELECT * FROM contacts WHERE id = ? LIMIT 1');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }

    private function deleteById(int $id): void
    {
        $db = getDB();
        $stmt = $db->prepare('DELETE FROM contacts WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
    }
}
