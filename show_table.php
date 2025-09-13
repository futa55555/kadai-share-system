<?php

/**
 * File: show_table.php
 * Description: データベースの中身を表示
 */

require 'includes/db.php';


$queries = [
    ["user", "SELECT * FROM user;"],
    ["kadai", "SELECT * FROM kadai;"],
    ["comment", "SELECT * FROM comment"]
]
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>テーブル一覧</title>
</head>

<body>
    <?php
    foreach ($queries as $query) {
        echo "<h3>{$query[0]}テーブル</h3>";

        $stmt = $pdo->query($query[1]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($rows) === 0) {
            echo "データなし<br>";
        } else {
            echo "<table border='1'>";
            echo "<tr>";
            // ヘッダ行を出す
            foreach (array_keys($rows[0]) as $col) {
                echo "<th>{$col}</th>";
            }
            echo "</tr>";
            // データ行を出す
            foreach ($rows as $row) {
                echo "<tr>";
                foreach ($row as $val) {
                    echo "<td>" . htmlspecialchars($val) . "</td>";
                }
                echo "</tr>";
            }
            echo "</table><br>";
        }
    }
    echo "<hr>";
    ?>
</body>

</html>
