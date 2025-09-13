<?php

/**
 * File: public/pages/index.php
 * Description: トップページ
 */


// セッション情報
session_start();

$username = $_SESSION["username"] ?? "";
?>



<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>課題一覧ページ</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/kadai_list.js" defer></script>
</head>

<body>
    <h1>
        <a href="index.php">
            課題共有システム
        </a>
    </h1>

    <?php if ($username): ?>
        You're logged in as <?= $username ?>.<br />
        If you wanna log out, click <a href="../../handlers/auth/log_out.php">here</a>.<br />
    <?php else: ?>
        You're not logged in.<br />
        If you wanna log in, click <a href="log_in.php">here</a>.<br />
    <?php endif ?>

    <hr />

    <a href="kadai_post.php">post</a>

    <hr />

    <div class="kadai-list">
        Kadai list<br />
        <ul id="kadai-list"></ul>
    </div>
</body>

</html>
