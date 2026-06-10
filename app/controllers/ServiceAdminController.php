<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Service.php';
require_once __DIR__ . '/../helpers/Uploader.php';

class ServiceAdminController
{
    public function handle(string $uri): void
    {
        if ($uri === '/admin/services/create') {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $title       = trim($_POST['title'] ?? '');
                $description = trim($_POST['description'] ?? '');
                $order_num   = (int)($_POST['order_num'] ?? 0);
                $error       = null;
                $image       = null;

                if (!$title || !$description) {
                    $error = 'Title and description are required.';
                } else {
                    if (!empty($_FILES['image']['name'])) {
                        $image = Uploader::upload($_FILES['image']);
                        if (!$image) $error = 'Image upload failed.';
                    }

                    if (!$error) {
                        Service::create([
                            'title'       => $title,
                            'description' => $description,
                            'image'       => $image,
                            'order_num'   => $order_num
                        ]);
                        header('Location: /admin/services?status=created');
                        exit;
                    }
                }
            }
            $pageTitle = 'Create Service';
            require_once __DIR__ . '/../views/admin/partials/admin_header.php';
            require __DIR__ . '/../views/admin/services/create.php';
            require_once __DIR__ . '/../views/admin/partials/admin_footer.php';
            return;
        }

        if ($uri === '/admin/services/edit') {
            $id = (int)($_GET['id'] ?? 0);
            $service = $id > 0 ? Service::findById($id) : null;
            if (!$service) {
                header('Location: /admin/services');
                exit;
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $title       = trim($_POST['title'] ?? '');
                $description = trim($_POST['description'] ?? '');
                $order_num   = (int)($_POST['order_num'] ?? 0);
                $error       = null;
                $data        = [
                    'title'       => $title,
                    'description' => $description,
                    'order_num'   => $order_num
                ];

                if (!$title || !$description) {
                    $error = 'Title and description are required.';
                } else {
                    if (!empty($_FILES['image']['name'])) {
                        $newImage = Uploader::upload($_FILES['image']);
                        if ($newImage) {
                            // Delete old image if it was local
                            if (!empty($service['image']) && !str_starts_with($service['image'], 'http')) {
                                Uploader::delete($service['image']);
                            }
                            $data['image'] = $newImage;
                        } else {
                            $error = 'Image upload failed.';
                        }
                    }

                    if (!$error) {
                        Service::update($id, $data);
                        header('Location: /admin/services?status=updated');
                        exit;
                    }
                }
            }
            $pageTitle = 'Edit Service';
            require_once __DIR__ . '/../views/admin/partials/admin_header.php';
            require __DIR__ . '/../views/admin/services/edit.php';
            require_once __DIR__ . '/../views/admin/partials/admin_footer.php';
            return;
        }

        if ($uri === '/admin/services/delete') {
            $id = (int)($_GET['id'] ?? 0);
            $service = $id > 0 ? Service::findById($id) : null;
            if ($service) {
                if (!empty($service['image']) && !str_starts_with($service['image'], 'http')) {
                    Uploader::delete($service['image']);
                }
                Service::delete($id);
            }
            header('Location: /admin/services?status=deleted');
            exit;
        }

        // LIST
        $services  = Service::getAll();
        $pageTitle = 'Manage Services';
        require_once __DIR__ . '/../views/admin/partials/admin_header.php';
        require __DIR__ . '/../views/admin/services/index.php';
        require_once __DIR__ . '/../views/admin/partials/admin_footer.php';
    }
}
