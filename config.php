<?php
// ============================
// Community Health Connect
// CSIT 337 Final Project
// Database connection via PDO (required)
// ============================

error_reporting(E_ALL);
ini_set('display_errors', 1);

// IMPORTANT: Do NOT use MySQL root user in your program (project requirement).
// These credentials should match the CREATE USER / GRANT statements in community_health_db.sql.
$host = '127.0.0.1';
$db   = 'community_health';
$user = 'chc_user';
$pass = 'chc_pass';
$port = 3306;

$dsn = "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8'));
}

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
?>
