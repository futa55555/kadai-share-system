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
</head>

<body>

</body>
<h1>
    <a href="index.php">
        課題共有システム
    </a>
</h1>

<?php if ($username): ?>
    正常にログアウトできませんでした。<br />
    <a href="../../handlers/auth/log_out.php">もう一度試す</a><br />
<?php else: ?>
    正常にログアウトできました。<br />
<?php endif ?>

</html>
