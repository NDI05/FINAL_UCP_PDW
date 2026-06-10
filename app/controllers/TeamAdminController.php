<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/TeamMember.php';
require_once __DIR__ . '/../helpers/Uploader.php';

class TeamAdminController
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
        $path = str_replace('/admin/team', '', $uri);
        $path = rtrim($path, '/') ?: '/';

        match(true) {
            $path === '/create' => $this->create(),
            $path === '/edit' => $this->edit(),
            $path === '/delete' => $this->delete(),
            default => $this->index(),
        };
    }

    public function index(): void
    {
        $this->requireAuth();
        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 10;
        $members = TeamMember::getAll($page, $perPage);
        $total = TeamMember::count();
        $totalPages = max(1, (int)ceil($total / $perPage));

        $pageTitle = 'Team';
        require_once __DIR__ . '/../views/admin/partials/admin_header.php';
        require __DIR__ . '/../views/admin/team/index.php';
        require_once __DIR__ . '/../views/admin/partials/admin_footer.php';
    }

    public function create(): void
    {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $role = trim($_POST['role'] ?? '');
            $orderNum = (int)($_POST['order_num'] ?? 0);
            $image = null;

            if (!empty($_FILES['image']['name'])) {
                $image = Uploader::upload($_FILES['image']);
                if (!$image) {
                    $error = 'Image upload failed. Check file type (jpg/png/gif/webp) and size (max 2MB).';
                }
            }

            if (empty($error)) {
                TeamMember::create([
                    'name' => $name,
                    'role' => $role,
                    'image' => $image,
                    'order_num' => $orderNum,
                ]);
                header('Location: ' . baseUrl('/admin/team'));
                exit;
            }
        }

        $pageTitle = 'Add Team Member';
        require_once __DIR__ . '/../views/admin/partials/admin_header.php';
        require __DIR__ . '/../views/admin/team/create.php';
        require_once __DIR__ . '/../views/admin/partials/admin_footer.php';
    }

    public function edit(): void
    {
        $this->requireAuth();
        $id = (int)($_GET['id'] ?? 0);
        $member = TeamMember::findById($id);

        if (!$member) {
            http_response_code(404);
            echo '<div class="p-10 text-center font-mono text-[#666] text-sm">[ 404 ] Team member not found.</div>';
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => trim($_POST['name'] ?? ''),
                'role' => trim($_POST['role'] ?? ''),
                'order_num' => (int)($_POST['order_num'] ?? 0),
            ];

            if (!empty($_FILES['image']['name'])) {
                $image = Uploader::upload($_FILES['image']);
                if ($image) {
                    Uploader::delete($member['image']);
                    $data['image'] = $image;
                } else {
                    $error = 'Image upload failed. Check file type and size.';
                }
            }

            if (empty($error)) {
                TeamMember::update($id, $data);
                header('Location: ' . baseUrl('/admin/team'));
                exit;
            }
        }

        $pageTitle = 'Edit Team Member';
        require_once __DIR__ . '/../views/admin/partials/admin_header.php';
        require __DIR__ . '/../views/admin/team/edit.php';
        require_once __DIR__ . '/../views/admin/partials/admin_footer.php';
    }

    public function delete(): void
    {
        $this->requireAuth();
        $id = (int)($_GET['id'] ?? 0);
        $member = TeamMember::findById($id);

        if ($member) {
            Uploader::delete($member['image'] ?? null);
            TeamMember::delete($id);
        }

        header('Location: ' . baseUrl('/admin/team'));
        exit;
    }
}
