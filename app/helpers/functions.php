<?php
function baseUrl(string $path = ''): string
{
    $path = ltrim($path, '/');
    return defined('BASE_URL') ? BASE_URL . ($path === '' ? '' : '/' . $path) : '/' . $path;
}

function asset(string $path): string
{
    return baseUrl($path);
}

function currentNavClass(string $uri, string $path): string
{
    $current = parse_url($uri, PHP_URL_PATH);
    if (defined('BASE_URL') && BASE_URL !== '' && str_starts_with($current, BASE_URL)) {
        $current = substr($current, strlen(BASE_URL));
    }
    $current = rtrim($current, '/') ?: '/';
    $path = rtrim($path, '/') ?: '/';
    return ($current === $path)
        ? 'text-[#CCFF00]'
        : 'text-[#666] hover:text-white';
}
