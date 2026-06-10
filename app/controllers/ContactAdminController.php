<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Contact.php';

class ContactAdminController
{
    public function handle(string $uri): void
    {
        // DELETE contact
        if ($uri === '/admin/contacts/delete') {
            $id = (int)($_GET['id'] ?? 0);
            if ($id > 0) {
                $db = getDB();
                $stmt = $db->prepare('DELETE FROM contacts WHERE id = ?');
                $stmt->bind_param('i', $id);
                $stmt->execute();
            }
            header('Location: /admin/contacts');
            exit;
        }

        // LIST contacts
        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 15;
        $contacts = Contact::getAll($page, $perPage);
        $total = Contact::count();
        $totalPages = max(1, (int)ceil($total / $perPage));
        $pageTitle = 'Contact Inbox';

        require_once __DIR__ . '/../views/admin/partials/admin_header.php';
        require __DIR__ . '/../views/admin/contacts/index.php';
        require_once __DIR__ . '/../views/admin/partials/admin_footer.php';
    }
}
