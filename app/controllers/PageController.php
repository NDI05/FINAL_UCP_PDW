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
        if (!isset($this->pages[$page])) {
            $page = 'landing';
        }

        $data = $this->pages[$page];
        $pageTitle = $data['title'];
        $viewFile = __DIR__ . '/../views/' . $data['view'] . '.php';

        require_once __DIR__ . '/../views/partials/header.php';

        if (file_exists($viewFile)) {
            require $viewFile;
        } else {
            echo '<main class="min-h-screen flex items-center justify-center"><p class="text-gray-500 text-lg">Page not found.</p></main>';
        }

        require_once __DIR__ . '/../views/partials/footer.php';
    }
}
