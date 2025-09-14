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
    <link rel="stylesheet" href="../css/index.css">
    <script src="../js/kadai_list.js" defer></script>
</head>

<body>
    <h1>
        <a href="index.php">
            課題共有システム
        </a>
    </h1>


    <div class="user-message">
        <?php if ($username !== ""): ?>
            <div class="login-message">
                <p><?= htmlspecialchars($username) ?>としてログインしています。</p>
                <p>ログアウトは<a href="../../handlers/auth/log_out.php">こちら</a></p>
            </div>
        <?php else: ?>
            <div class="non-login-message">
                <p>ログインしていません。</p>
                <p>ログインは<a href="log_in.php">こちら</a></p>
            </div>
        <?php endif ?>
    </div>


    <hr />


    <div class="kadai-post">
        <a href="kadai_post.php">課題投稿</a>
    </div>


    <hr />


    <div class="kadai-list" id="kadai-list"></div>
</body>

</html>
