<?php
require_once __DIR__ . '/../models/Visitor.php';

function trackVisitor(): void
{
    $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $page = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    Visitor::record($ip, $ua, $page);
}
