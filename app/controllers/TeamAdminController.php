<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/TeamMember.php';
require_once __DIR__ . '/../helpers/Uploader.php';

class TeamAdminController
{
    public function handle(string $uri): void
    {
        if ($uri === '/admin/team/create') {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $name      = trim($_POST['name'] ?? '');
                $role      = trim($_POST['role'] ?? '');
                $order_num = (int)($_POST['order_num'] ?? 0);
                $error     = null;
                $image     = null;

                if (!$name || !$role) {
                    $error = 'Name and role are required.';
                } else {
                    if (!empty($_FILES['image']['name'])) {
                        $image = Uploader::uploadAndCropSquare($_FILES['image']);
                        if (!$image) $error = 'Image upload failed.';
                    }

                    if (!$error) {
                        TeamMember::create([
                            'name'      => $name,
                            'role'      => $role,
                            'image'     => $image,
                            'order_num' => $order_num
                        ]);
                        header('Location: /admin/team?status=created');
                        exit;
                    }
                }
            }
            $pageTitle = 'Create Team Member';
            require_once __DIR__ . '/../views/admin/partials/admin_header.php';
            require __DIR__ . '/../views/admin/team/create.php';
            require_once __DIR__ . '/../views/admin/partials/admin_footer.php';
            return;
        }

        if ($uri === '/admin/team/edit') {
            $id = (int)($_GET['id'] ?? 0);
            $member = $id > 0 ? TeamMember::findById($id) : null;
            if (!$member) {
                header('Location: /admin/team');
                exit;
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $name      = trim($_POST['name'] ?? '');
                $role      = trim($_POST['role'] ?? '');
                $order_num = (int)($_POST['order_num'] ?? 0);
                $error     = null;
                $data      = [
                    'name'      => $name,
                    'role'      => $role,
                    'order_num' => $order_num
                ];

                if (!$name || !$role) {
                    $error = 'Name and role are required.';
                } else {
                    if (!empty($_FILES['image']['name'])) {
                        $newImage = Uploader::uploadAndCropSquare($_FILES['image']);
                        if ($newImage) {
                            // Delete old image if it was local
                            if (!empty($member['image']) && !str_starts_with($member['image'], 'http')) {
                                Uploader::delete($member['image']);
                            }
                            $data['image'] = $newImage;
                        } else {
                            $error = 'Image upload failed.';
                        }
                    }

                    if (!$error) {
                        TeamMember::update($id, $data);
                        header('Location: /admin/team?status=updated');
                        exit;
                    }
                }
            }
            $pageTitle = 'Edit Team Member';
            require_once __DIR__ . '/../views/admin/partials/admin_header.php';
            require __DIR__ . '/../views/admin/team/edit.php';
            require_once __DIR__ . '/../views/admin/partials/admin_footer.php';
            return;
        }

        if ($uri === '/admin/team/delete') {
            $id = (int)($_GET['id'] ?? 0);
            $member = $id > 0 ? TeamMember::findById($id) : null;
            if ($member) {
                if (!empty($member['image']) && !str_starts_with($member['image'], 'http')) {
                    Uploader::delete($member['image']);
                }
                TeamMember::delete($id);
            }
            header('Location: /admin/team?status=deleted');
            exit;
        }

        // LIST
        $members   = TeamMember::getAll();
        $pageTitle = 'Manage Team Members';
        require_once __DIR__ . '/../views/admin/partials/admin_header.php';
        require __DIR__ . '/../views/admin/team/index.php';
        require_once __DIR__ . '/../views/admin/partials/admin_footer.php';
    }
}
