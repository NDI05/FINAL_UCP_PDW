<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/SiteSetting.php';

class SiteSettingController
{
    public function handle(string $uri): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $settings = $_POST['settings'] ?? [];
            if (is_array($settings)) {
                $clean = [];
                foreach ($settings as $key => $value) {
                    $clean[preg_replace('/[^a-z0-9_]/', '', $key)] = trim($value);
                }

                // Handle image uploads
                if (isset($_FILES['settings_image']) && is_array($_FILES['settings_image']['name'])) {
                    require_once __DIR__ . '/../helpers/Uploader.php';
                    foreach ($_FILES['settings_image']['name'] as $key => $filename) {
                        if (!empty($filename)) {
                            $file = [
                                'name'     => $_FILES['settings_image']['name'][$key],
                                'type'     => $_FILES['settings_image']['type'][$key],
                                'tmp_name' => $_FILES['settings_image']['tmp_name'][$key],
                                'error'    => $_FILES['settings_image']['error'][$key],
                                'size'     => $_FILES['settings_image']['size'][$key],
                            ];
                            $uploadedPath = Uploader::upload($file);
                            if ($uploadedPath) {
                                // Delete old local image if any
                                $oldVal = SiteSetting::get($key);
                                if (!empty($oldVal) && !str_starts_with($oldVal, 'http')) {
                                    Uploader::delete($oldVal);
                                }
                                $clean[$key] = $uploadedPath;
                            }
                        }
                    }
                }

                SiteSetting::setMany($clean);
            }
            header('Location: /admin/settings?status=saved');
            exit;
        }

        $settings = SiteSetting::getAll();
        // Group by 'group' field
        $grouped = [];
        foreach ($settings as $s) {
            $grouped[$s['group']][] = $s;
        }
        $pageTitle = 'Site Settings';
        require_once __DIR__ . '/../views/admin/partials/admin_header.php';
        require __DIR__ . '/../views/admin/settings/index.php';
        require_once __DIR__ . '/../views/admin/partials/admin_footer.php';
    }
}
