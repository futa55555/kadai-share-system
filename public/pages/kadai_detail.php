<?php

/**
 * File: public/pages/kadai_detail.php
 * Description: 課題詳細の表示ページ
 */

$kadai_id = $_GET["kadai_id"];


// セッション情報
session_start();

$username = $_SESSION["username"] ?? "";
$solution = $_SESSION["solution"] ?? "";
$solution_code = $_SESSION["solution_code"] ?? "";

$comment_post_message = $_SESSION["comment_post_message"] ?? "";

unset(
    $_SESSION["solution"],
    $_SESSION["solution_code"],

    $_SESSION["comment_post_message"]
);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>課題詳細ページ</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/kadai_detail.js" defer></script>
    <script src="../js/comment_list.js" defer></script>
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

    <div class="kadai_detail">
        <ul id="kadai-detail"></ul>
    </div>

    <hr />

    <div class="comment_list">
        <ul id="comment-list"></ul>
    </div>

    <?php if ($username): ?>
        <?php if ($comment_post_message !== ""): ?>
            <?= $comment_post_message; ?><br />
        <?php endif ?>

        <div class="comment-post">
            <form action="../../handlers/posts/kadai_detail.php?kadai_id=<?= $kadai_id ?>" method="post">
                解決策：<textarea name="content"><?= $solution; ?></textarea><br />
                改善ファイル：<textarea name="resolve_file"><?= $solution_code; ?></textarea>
                <input type="submit" name="submit">
            </form>
        </div>
    <?php endif ?>

    <div id="kadai-id" data-kadai-id="<?= htmlspecialchars($kadai_id); ?>"></div>
</body>

</html>
