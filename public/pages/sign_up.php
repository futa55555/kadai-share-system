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
    <title>サインアップページ</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/sign_up.css">
    <script src="../js/user_list.js" defer></script>
</head>

<body>
    <h1>
        <a href="index.php">
            課題共有システム
        </a>
    </h1>


    <div class="have-account">
        <p>アカウントをお持ちの場合は<a href="log_in.php">こちら</a></p>
    </div>


    <hr />


    <div class="signup-form">
        <form action="../../handlers/auth/sign_up.php" method="post">
            <div class="signup-group">
                <label for="username" class="signup-label">
                    ユーザー名：
                </label>

                <input type="text" id="username" name="username" class="signup-input" autocomplete="username" value="<?= htmlspecialchars($old_input_username) ?>">
            </div>

            <div class="signup-group">
                <label for="password" class="signup-label">
                    パスワード：
                </label>

                <input type="password" id="password" name="password" class="signup-input" autocomplete="new-password"><br />
            </div>

            <input type="submit" name="submit" class="btn btn-submit" value="サインアップ">
        </form>
    </div>


    <div class="error-message">
        <?php if ($credential_message !== ""): ?>
            <?= htmlspecialchars($credential_message) ?>
        <?php endif ?>
    </div>


    <hr />


    <div class="account-list">
        <h3>アカウント一覧</h3>
        <ul id="user-list"></ul>
    </div>
</body>

</html>
