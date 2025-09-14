<?php

/**
 * File: public/pages/log_in.php
 * Description: ログインの表示ページ
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


// ログイン済みならトップページへ
if ($username !== "") {
    header("Location: index.php");
    exit;
}
?>



<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>ログインページ</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/log_in.css">
    <script src="../js/user_list.js" defer></script>
</head>

<body>
    <h1>
        <a href="index.php">
            課題共有システム
        </a>
    </h1>


    <div class="not-have-account">
        <p>アカウントをお持ちでない場合は<a href="sign_up.php">こちら</a></p>
    </div>


    <hr />


    <div class="login-form">
        <form action="../../handlers/auth/log_in.php" method="post">
            <div class="login-group">
                <label for="username" class="login-label">
                    ユーザー名：
                </label>

                <input type="text" id="username" name="username" class="login-input" autocomplete="username" value="<?= htmlspecialchars($old_input_username) ?>">
            </div>

            <div class="login-group">
                <label for="password" class="login-label">
                    パスワード：
                </label>

                <input type="password" id="password" name="password" class="login-input" autocomplete="current-password"><br />
            </div>

            <input type="submit" name="submit" value="ログイン">
        </form>
    </div>


    <div class="error-message">
        <?= htmlspecialchars($credential_message) ?>
    </div>


    <hr />


    <div class="account-list">
        <h3>アカウント一覧</h3>
        <ul id="user-list"></ul>
    </div>
</body>

</html>
