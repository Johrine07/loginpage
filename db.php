<?php
// Database connection settings. Update these to match your local MySQL setup.
$host = 'localhost';
$dbname = 'login_system';
$username = 'root';
$password = '';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    // Avoid showing database credentials or internal error details to visitors.
    http_response_code(500);
    exit('Database connection failed. Check db.php settings and make sure MySQL is running.');
}
