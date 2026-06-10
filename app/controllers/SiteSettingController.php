<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/SiteSetting.php';

class SiteSettingController
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
        $path = str_replace('/admin/settings', '', $uri);
        $path = rtrim($path, '/') ?: '/';
        $this->index();
    }

    public function index(): void
    {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $settings = $_POST['settings'] ?? [];
            foreach ($settings as $key => $value) {
                SiteSetting::set($key, $value);
            }
            $success = 'Settings saved successfully.';
        }

        $allSettings = SiteSetting::getAll();
        $grouped = [];
        foreach ($allSettings as $setting) {
            $group = $setting['group'] ?? 'general';
            $grouped[$group][] = $setting;
        }

        $pageTitle = 'Site Settings';
        require_once __DIR__ . '/../views/admin/partials/admin_header.php';
        require __DIR__ . '/../views/admin/settings/index.php';
        require_once __DIR__ . '/../views/admin/partials/admin_footer.php';
    }
}
