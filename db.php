<?php
// db.php
session_start();
 
$DB_HOST = 'localhost';
$DB_NAME = 'dbgukggbtciljf';
$DB_USER = 'ur9iyguafpilu';
$DB_PASS = '51gssrtsv3ei';
 
try {
    $pdo = new PDO("mysql:host={$DB_HOST};dbname={$DB_NAME};charset=utf8mb4", $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    echo "Database connection failed: " . htmlspecialchars($e->getMessage());
    exit;
}
 
/*
 * SMTP settings for PHPMailer (used by send_email.php)
 * Replace these with real SMTP credentials before using:
 */
define('SMTP_HOST','smtp.example.com');    // e.g. smtp.gmail.com
define('SMTP_USER','your_smtp_user');      // e.g. your Gmail/SMTP email
define('SMTP_PASS','your_smtp_password');  // SMTP password or app password
define('SMTP_PORT',587);                   // 587 for TLS, 465 for SSL
define('SMTP_FROM','no-reply@yourdomain.com');
define('SMTP_FROM_NAME','Sheraton Demo');
define('ADMIN_EMAIL','admin@example.com'); // who gets booking notification
 
