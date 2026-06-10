<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/User.php';

class UserController
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
        $path = str_replace('/admin/users', '', $uri);
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
        $users = $this->getAllUsers();

        $pageTitle = 'Users';
        require_once __DIR__ . '/../views/admin/partials/admin_header.php';
        require __DIR__ . '/../views/admin/users/index.php';
        require_once __DIR__ . '/../views/admin/partials/admin_footer.php';
    }

    public function create(): void
    {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'editor';

            if (empty($username) || empty($email) || empty($password)) {
                $error = 'All fields are required.';
            } elseif (User::findByUsername($username)) {
                $error = 'Username already exists.';
            } elseif (User::findByEmail($email)) {
                $error = 'Email already exists.';
            } else {
                User::create([
                    'username' => $username,
                    'email' => $email,
                    'password' => password_hash($password, PASSWORD_BCRYPT),
                    'role' => $role,
                ]);
                header('Location: ' . baseUrl('/admin/users'));
                exit;
            }
        }

        $pageTitle = 'Create User';
        require_once __DIR__ . '/../views/admin/partials/admin_header.php';
        require __DIR__ . '/../views/admin/users/create.php';
        require_once __DIR__ . '/../views/admin/partials/admin_footer.php';
    }

    public function edit(): void
    {
        $this->requireAuth();
        $id = (int)($_GET['id'] ?? 0);
        $user = User::findById($id);

        if (!$user) {
            http_response_code(404);
            echo '<div class="p-10 text-center font-mono text-[#666] text-sm">[ 404 ] User not found.</div>';
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'editor';

            $existing = User::findByUsername($username);
            if ($existing && (int)$existing['id'] !== $id) {
                $error = 'Username already taken by another user.';
            }

            if (empty($error)) {
                $existing = User::findByEmail($email);
                if ($existing && (int)$existing['id'] !== $id) {
                    $error = 'Email already taken by another user.';
                }
            }

            if (empty($error)) {
                $data = [
                    'username' => $username,
                    'email' => $email,
                    'role' => $role,
                ];

                if (!empty($password)) {
                    $data['password'] = password_hash($password, PASSWORD_BCRYPT);
                }

                $this->updateUser($id, $data);
                header('Location: ' . baseUrl('/admin/users'));
                exit;
            }

            // Refresh user data for the form with submitted values
            $user['username'] = $username;
            $user['email'] = $email;
            $user['role'] = $role;
        }

        $pageTitle = 'Edit User';
        require_once __DIR__ . '/../views/admin/partials/admin_header.php';
        require __DIR__ . '/../views/admin/users/edit.php';
        require_once __DIR__ . '/../views/admin/partials/admin_footer.php';
    }

    public function delete(): void
    {
        $this->requireAuth();
        $id = (int)($_GET['id'] ?? 0);

        // Prevent deleting own account
        if ($id > 0 && $id !== (int)($_SESSION['user_id'] ?? 0)) {
            $this->deleteUser($id);
        }

        header('Location: ' . baseUrl('/admin/users'));
        exit;
    }

    private function getAllUsers(): array
    {
        $db = getDB();
        $result = $db->query('SELECT id, username, email, role, created_at FROM users ORDER BY id ASC');
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    private function updateUser(int $id, array $data): void
    {
        $db = getDB();

        if (isset($data['password'])) {
            $stmt = $db->prepare('UPDATE users SET username = ?, email = ?, password = ?, role = ? WHERE id = ?');
            $stmt->bind_param('ssssi', $data['username'], $data['email'], $data['password'], $data['role'], $id);
        } else {
            $stmt = $db->prepare('UPDATE users SET username = ?, email = ?, role = ? WHERE id = ?');
            $stmt->bind_param('sssi', $data['username'], $data['email'], $data['role'], $id);
        }

        $stmt->execute();
    }

    private function deleteUser(int $id): void
    {
        $db = getDB();
        $stmt = $db->prepare('DELETE FROM users WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
    }
}
