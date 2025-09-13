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
        <p><?= htmlspecialchars($username); ?>としてログインしています。</p>
        <p>ログアウトは<a href="../../handlers/auth/log_out.php">こちら</a></p>
    <?php else: ?>
        <p>ログインしていません。</p>
        <p>ログインは<a href="log_in.php">こちら</a></p>
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
