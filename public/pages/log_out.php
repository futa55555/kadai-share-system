<?php

/**
 * File: public/pages/log_out.php
 * Description: ログアウト後の表示ページ
 */

// セッション情報
session_start();

$username = $_SESSION["username"] ?? "";
?>



<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>ログアウトページ</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/log_out.css">
</head>

<body>

</body>
<h1>
    <a href="index.php">
        課題共有システム
    </a>
</h1>

<?php if ($username): ?>
    <p>正常にログアウトできませんでした。</p>
    <p><a href="../../handlers/auth/log_out.php">もう一度試す</a></p>
<?php else: ?>
    <p>正常にログアウトできました。</p>
    <p><a href="log_in.php">再びログインする</a></p>
<?php endif ?>

</html>
