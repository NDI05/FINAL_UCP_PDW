<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/User.php';

class AuthController
{
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            $user = User::findByUsername($username);
            if (!$user) $user = User::findByEmail($username);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                session_regenerate_id(true);
                $this->redirect('/admin');
            }
            $error = 'Invalid credentials.';
            require __DIR__ . '/../views/admin/login.php';
            return;
        }
        $error = null;
        require __DIR__ . '/../views/admin/login.php';
    }

    public function logout(): void
    {
        $_SESSION = [];
        session_destroy();
        $this->redirect('/admin/login');
    }

    public function isAuthenticated(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public function requireAuth(): void
    {
        if (!$this->isAuthenticated()) $this->redirect('/admin/login');
    }

    private function redirect(string $url): void
    {
        header('Location: ' . baseUrl($url));
        exit;
    }
}
