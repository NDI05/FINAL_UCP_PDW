<?php
class PageController
{
    private array $pages = [
        'landing'  => ['title' => 'Nusa Data Indonesia', 'view' => 'landing'],
        'about'    => ['title' => 'About Us', 'view' => 'about'],
        'services' => ['title' => 'Our Services', 'view' => 'services'],
        'contact'  => ['title' => 'Contact Us', 'view' => 'contact'],
    ];

    public function render(string $page): void
    {
        if (!isset($this->pages[$page])) $page = 'landing';

        require_once __DIR__ . '/../models/SiteSetting.php';

        $data = $this->pages[$page];
        if ($page === 'landing') {
            $pageTitle = SiteSetting::get('site_name', 'Nusa Data Indonesia') . ' — ' . SiteSetting::get('site_tagline', 'Data Intelligence for the Archipelago');
        } else {
            $pageTitle = $data['title'] . ' — ' . SiteSetting::get('site_name', 'Nusa Data Indonesia');
        }
        $viewFile = __DIR__ . '/../views/' . $data['view'] . '.php';

        require_once __DIR__ . '/../views/partials/header.php';

        if (file_exists($viewFile)) {
            require $viewFile;
        } else {
            echo '<main class="min-h-screen flex items-center justify-center"><p class="text-[#666] font-mono text-sm">[ 404 ] Page not found.</p></main>';
        }

        require_once __DIR__ . '/../views/partials/footer.php';
    }
}
