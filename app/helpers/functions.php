<?php
function asset(string $path): string
{
    return $path;
}

function currentNavClass(string $uri, string $path): string
{
    $current = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $current = rtrim($current, '/');
    return ($current === $path || ($path === '/' && $current === ''))
        ? 'text-[#CCFF00]'
        : 'text-[#666] hover:text-white';
}
