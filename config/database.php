<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'ndi_cms');
define('DB_USER', 'root');
define('DB_PASS', '');

function getDB(): ?mysqli
{
    static $conn = null;
    if ($conn === null) {
        try {
            $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if ($conn->connect_error) return null;
            $conn->set_charset('utf8mb4');
        } catch (\Throwable $e) {
            return null;
        }
    }
    return $conn;
}
