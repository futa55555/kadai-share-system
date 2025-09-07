<!-- init.php -->

<?php
    require '../db.php'
?>

<?php
    $queries = [
        <<<SQL
            DROP TABLE IF EXISTS user;
        SQL,
        <<<SQL
            CREATE TABLE user (
                user_id INT AUTO_INCREMENT PRIMARY KEY,
                user_name VARCHAR(50),
                pass VARCHAR(50)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        SQL,
        <<<SQL
            DROP TABLE IF EXISTS kadai;
        SQL,
        <<<SQL
            CREATE TABLE kadai (
                kadai_id INT AUTO_INCREMENT PRIMARY KEY,
                user_name VARCHAR(50),
                mission_genre INT NOT NULL,
                mission_detail INT NOT NULL,
                goal VARCHAR(200),
                problem TEXT,
                error_file TEXT,
                solve_state VARCHAR(200),
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        SQL,
        <<<SQL
            DROP TABLE IF EXISTS comment;
        SQL,
        <<<SQL
            CREATE TABLE comment (
                comment_id INT AUTO_INCREMENT PRIMARY KEY,
                user_name VARCHAR(50),
                kadai_id INT NOT NULL,
                content TEXT,
                resolve_file TEXT,
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        SQL
    ]
?>


<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>データベース初期化</title>
    </head>
    <body>
        <?php
            foreach ($queries as $query) {
                $pdo->exec($query);
                echo "実行したSQL: {$query}<br>";
            }
            echo "<hr>";
        ?>
    </body>
</html>