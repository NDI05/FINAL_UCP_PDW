<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Service.php';
require_once __DIR__ . '/../helpers/Uploader.php';

class ServiceAdminController
{
    private function requireAuth(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /admin/login');
            exit;
        }
    }

    public function handle(string $uri): void
    {
        $path = str_replace('/admin/services', '', $uri);
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
        $services = Service::getAllOrdered();

        $pageTitle = 'Services';
        require_once __DIR__ . '/../views/admin/partials/admin_header.php';
        require __DIR__ . '/../views/admin/services/index.php';
        require_once __DIR__ . '/../views/admin/partials/admin_footer.php';
    }

    public function create(): void
    {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $description = $_POST['description'] ?? '';
            $orderNum = (int)($_POST['order_num'] ?? 0);
            $image = null;

            if (!empty($_FILES['image']['name'])) {
                $image = Uploader::upload($_FILES['image']);
                if (!$image) {
                    $error = 'Image upload failed. Check file type (jpg/png/gif/webp) and size (max 2MB).';
                }
            }

            if (empty($error)) {
                Service::create([
                    'title' => $title,
                    'description' => $description,
                    'image' => $image,
                    'order_num' => $orderNum,
                ]);
                header('Location: /admin/services');
                exit;
            }
        }

        $pageTitle = 'Create Service';
        require_once __DIR__ . '/../views/admin/partials/admin_header.php';
        require __DIR__ . '/../views/admin/services/create.php';
        require_once __DIR__ . '/../views/admin/partials/admin_footer.php';
    }

    public function edit(): void
    {
        $this->requireAuth();
        $id = (int)($_GET['id'] ?? 0);
        $service = Service::findById($id);

        if (!$service) {
            http_response_code(404);
            echo '<div class="p-10 text-center font-mono text-[#666] text-sm">[ 404 ] Service not found.</div>';
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => trim($_POST['title'] ?? ''),
                'description' => $_POST['description'] ?? '',
                'order_num' => (int)($_POST['order_num'] ?? 0),
            ];

            if (!empty($_FILES['image']['name'])) {
                $image = Uploader::upload($_FILES['image']);
                if ($image) {
                    Uploader::delete($service['image']);
                    $data['image'] = $image;
                } else {
                    $error = 'Image upload failed. Check file type and size.';
                }
            }

            if (empty($error)) {
                Service::update($id, $data);
                header('Location: /admin/services');
                exit;
            }
        }

        $pageTitle = 'Edit Service';
        require_once __DIR__ . '/../views/admin/partials/admin_header.php';
        require __DIR__ . '/../views/admin/services/edit.php';
        require_once __DIR__ . '/../views/admin/partials/admin_footer.php';
    }

    public function delete(): void
    {
        $this->requireAuth();
        $id = (int)($_GET['id'] ?? 0);
        $service = Service::findById($id);

        if ($service) {
            Uploader::delete($service['image'] ?? null);
            Service::delete($id);
        }

        header('Location: /admin/services');
        exit;
    }
}
