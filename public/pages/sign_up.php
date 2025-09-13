<?php

/**
 * File: public/pages/sign_up.php
 * Description: サインアップの表示ページ
 */

// セッション情報
session_start();

$username = $_SESSION["username"] ?? "";
$old_input_username = $_SESSION["old_input_username"] ?? "";
$credential_message = $_SESSION["credential_message"] ?? "";

unset(
    $_SESSION["old_input_username"],
    $_SESSION["credential_message"]
);
?>



<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>サインアップページ</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/user_list.js" defer></script>
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

    <form action="../../handlers/auth/sign_up.php" method="post">
        ユーザー名：<input type="text" name="username" autocomplete="username" value="<?= htmlspecialchars($old_input_username); ?>"><br />
        パスワード：<input type="password" name="password" autocomplete="new-password"><br />
        <input type="submit" name="submit" value="サインアップ">
    </form>

    <?= $credential_message . "<br />" ?>

    <hr />

    <div class="account-list">
        <p><strong>Account list</strong></p>
        <ul id="user-list"></ul>
    </div>
</body>

</html>
