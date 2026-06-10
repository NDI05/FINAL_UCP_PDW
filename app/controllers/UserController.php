<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/User.php';

class UserController
{
    public function handle(string $uri): void
    {
        // Cegah admin hapus diri sendiri
        $currentUserId = (int)($_SESSION['user_id'] ?? 0);

        if ($uri === '/admin/users/create') {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $username = trim($_POST['username'] ?? '');
                $email    = trim($_POST['email'] ?? '');
                $password = trim($_POST['password'] ?? '');
                $role     = $_POST['role'] ?? 'editor';
                $error    = null;

                if (!$username || !$email || !$password) {
                    $error = 'All fields are required.';
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $error = 'Invalid email address.';
                } elseif (User::findByUsername($username)) {
                    $error = 'Username already exists.';
                } elseif (User::findByEmail($email)) {
                    $error = 'Email already in use.';
                } else {
                    User::create([
                        'username' => $username,
                        'email'    => $email,
                        'password' => $password,
                        'role'     => $role,
                    ]);
                    header('Location: /admin/users?status=created');
                    exit;
                }
            }
            $pageTitle = 'Create User';
            require_once __DIR__ . '/../views/admin/partials/admin_header.php';
            require __DIR__ . '/../views/admin/users/create.php';
            require_once __DIR__ . '/../views/admin/partials/admin_footer.php';
            return;
        }

        if ($uri === '/admin/users/edit') {
            $id   = (int)($_GET['id'] ?? 0);
            $user = $id > 0 ? User::findById($id) : null;
            if (!$user) {
                header('Location: /admin/users');
                exit;
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $role        = $_POST['role'] ?? 'editor';
                $newPassword = trim($_POST['password'] ?? '');
                User::updateRole($id, $role);
                if ($newPassword !== '') {
                    User::updatePassword($id, $newPassword);
                }
                header('Location: /admin/users?status=updated');
                exit;
            }
            $pageTitle = 'Edit User';
            require_once __DIR__ . '/../views/admin/partials/admin_header.php';
            require __DIR__ . '/../views/admin/users/edit.php';
            require_once __DIR__ . '/../views/admin/partials/admin_footer.php';
            return;
        }

        if ($uri === '/admin/users/delete') {
            $id = (int)($_GET['id'] ?? 0);
            if ($id > 0 && $id !== $currentUserId) {
                User::delete($id);
            }
            header('Location: /admin/users?status=deleted');
            exit;
        }

        // LIST
        $users     = User::getAll();
        $pageTitle = 'User Management';
        require_once __DIR__ . '/../views/admin/partials/admin_header.php';
        require __DIR__ . '/../views/admin/users/index.php';
        require_once __DIR__ . '/../views/admin/partials/admin_footer.php';
    }
}
