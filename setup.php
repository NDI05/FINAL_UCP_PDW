<?php
/**
 * NDI CMS — Database Setup Script
 *
 * Usage: php setup.php
 * Or access via browser: http://localhost:8001/setup.php
 */

$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'ndi_cms';

$success = [];
$errors = [];

// Connect without database first
$conn = new mysqli($dbHost, $dbUser, $dbPass);
if ($conn->connect_error) {
    die("[FATAL] MySQL connection failed: " . $conn->connect_error . "\n");
}
$success[] = "MySQL connected";

// Create database
$conn->query("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
$conn->select_db($dbName);
$success[] = "Database `$dbName` ready";

$schema = __DIR__ . '/database/schema.sql';
if (!file_exists($schema)) {
    die("[FATAL] schema.sql not found at: $schema\n");
}

$sql = file_get_contents($schema);
$queries = explode(';', $sql);

$count = 0;
foreach ($queries as $query) {
    $query = trim($query);
    if (empty($query)) continue;

    if ($conn->query($query) === false) {
        $errors[] = "Query failed: " . $conn->error . "\n[SQL] " . substr($query, 0, 80) . "...";
    } else {
        $count++;
    }
}

$success[] = "$count queries executed successfully";

echo "==============================\n";
echo "  NDI CMS — Setup Complete\n";
echo "==============================\n\n";

foreach ($success as $msg) {
    echo "  ✅  $msg\n";
}

if (!empty($errors)) {
    echo "\n  ⚠️  Warnings:\n";
    foreach ($errors as $err) {
        echo "  —  $err\n";
    }
}

echo "\n  ───────────────────────────\n";
echo "  Login Credentials:\n";
echo "  URL:    http://localhost:8001/admin/login\n";
echo "  Username: admin\n";
echo "  Email:    admin@nusadataindonesia.com\n";
echo "  Password: password\n";
echo "  ───────────────────────────\n\n";

$conn->close();
