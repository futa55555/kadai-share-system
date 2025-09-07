<!-- sample_db.php -->

<?php
    $dsn = 'mysql:host=localhost;dbname=your_db;charset=utf8mb4';
    $user = 'your_username';
    $password = 'your_password';

    try {
        $pdo = new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    } catch (PDOException $e) {
        exit('DB Connection Error: ' . $e->getMessage());
    }
?>