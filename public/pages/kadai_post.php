<?php

/**
 * File: public/pages/kadai_post.php
 * Description: 課題投稿の表示ページ
 */


// セッション情報
session_start();

$username = $_SESSION["username"] ?? "";
$mission_genre = $_SESSION["mission_genre"] ?? "";
$mission_detail = $_SESSION["mission_detail"] ?? "";
$goal = $_SESSION["goal"] ?? "";
$problem = $_SESSION["problem"] ?? "";
$error_code = $_SESSION["error_code"] ?? "";
$resolve_state = $_SESSION["resolve_state"] ?? "";
$solution = $_SESSION["solution"] ?? "";
$solution_code = $_SESSION["solution_code"] ?? "";

$kadai_post_message = $_SESSION["kadai_post_message"] ?? "";
$comment_post_message = $_SESSION["comment_post_message"] ?? "";

unset(
    $_SESSION["mission_genre"],
    $_SESSION["mission_detail"],
    $_SESSION["goal"],
    $_SESSION["problem"],
    $_SESSION["error_code"],
    $_SESSION["resolve_state"],
    $_SESSION["solution"],
    $_SESSION["solution_code"],

    $_SESSION["kadai_post_message"],
    $_SESSION["comment_post_message"]
);
?>



<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>課題投稿ページ</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/kadai_post.js" defer></script>
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

    <?php if ($username): ?>
        <?php if ($kadai_post_message !== ""): ?>
            <?= $kadai_post_message ?><br />
        <?php endif ?>
        <?php if ($comment_post_message !== ""): ?>
            <?= $comment_post_message ?><br />
        <?php endif ?>


        <div class="kadai_post">
            <form action="../../handlers/posts/kadai_post.php" method="post">
                ミッション<br />
                大分類：
                <select name="mission_genre" data-prev-genre="<?= htmlspecialchars($mission_genre); ?>" id="mission-genre" required></select>
                小分類：
                <select name="mission_detail" id="mission-detail" data-prev-detail="<?= htmlspecialchars($mission_detail); ?>" required></select>
                <br />
                やりたいこと：
                <input type="text" name="goal" value="<?= $goal; ?>">
                <br />
                問題点：
                <textarea name="problem"><?= $problem; ?></textarea>
                <br />
                問題ファイル：
                <textarea name="error_code"><?= $error_code; ?></textarea>
                <br />
                解決状況：
                <select name="resolve_state" id="solve-state">
                    <option value="unresolved" <?= ($resolve_state == 'unresolved') ? 'selected' : ''; ?>>未解決</option>
                    <option value="resolved" <?= ($resolve_state == 'resolved') ? 'selected' : ''; ?>>解決済み</option>
                </select>
                <br />

                <div id="comment-box" style="display:none;">
                    解決策：<textarea name="solution"><?= $solution; ?></textarea><br />
                    改善ファイル：<textarea name="solution_code" placeholder="空欄可"><?= $solution_code; ?></textarea>
                </div>

                <input type="submit" name="submit">
            </form>
        </div>
    <?php else: ?>
        To post your kadai, please <a href="log_in.php">log in</a>.
    <?php endif ?>
</body>

</html>
