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
$content = $_SESSION["content"] ?? "";
$comment_code = $_SESSION["comment_code"] ?? "";

$kadai_post_message = $_SESSION["kadai_post_message"] ?? "";
$comment_post_message = $_SESSION["comment_post_message"] ?? "";

unset(
    $_SESSION["mission_genre"],
    $_SESSION["mission_detail"],
    $_SESSION["goal"],
    $_SESSION["problem"],
    $_SESSION["error_code"],
    $_SESSION["resolve_state"],
    $_SESSION["content"],
    $_SESSION["comment_code"],

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
    <link rel="stylesheet" href="../css/kadai_post.css">
    <script src="../js/kadai_post.js" defer></script>
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

    <?php if ($username): ?>
        <?php if ($kadai_post_message !== ""): ?>
            <?= htmlspecialchars($kadai_post_message); ?><br />
        <?php endif ?>
        <?php if ($comment_post_message !== ""): ?>
            <?= htmlspecialchars($comment_post_message); ?><br />
        <?php endif ?>


        <div class="kadai-post">
            <form action="../../handlers/posts/kadai_post.php" method="post">
                ミッション<br />
                大分類：
                <select name="mission_genre" id="mission-genre" data-prev-genre="<?= htmlspecialchars($mission_genre); ?>" required></select>
                小分類：
                <select name="mission_detail" id="mission-detail" data-prev-detail="<?= htmlspecialchars($mission_detail); ?>" required></select>
                <br />
                やりたいこと：
                <input type="text" name="goal" value="<?= htmlspecialchars($goal); ?>">
                <br />
                問題点：
                <textarea name="problem"><?= htmlspecialchars($problem); ?></textarea>
                <br />
                問題ファイル：
                <textarea name="error_code"><?= htmlspecialchars($error_code); ?></textarea>
                <br />
                解決状況：
                <select name="resolve_state" id="resolve-state">
                    <option value="unresolved" <?= ($resolve_state === 'unresolved') ? 'selected' : ''; ?>>未解決</option>
                    <option value="resolved" <?= ($resolve_state === 'resolved') ? 'selected' : ''; ?>>解決済み</option>
                </select>
                <br />

                <div id="comment-box" style="display:none;">
                    解決策：<textarea name="content"><?= htmlspecialchars($content); ?></textarea><br />
                    解決ファイル：<textarea name="comment_code" placeholder="空欄可"><?= htmlspecialchars($comment_code); ?></textarea>
                </div>

                <input type="submit" name="submit">
            </form>
        </div>
    <?php else: ?>
        <!-- ダミー -->
        <select id="mission-genre" style="display:none;"></select>
        <select id="mission-detail" style="display:none;"></select>
        <select id="resolve-state" style="display:none;">
            <option value="unresolved" selected></option>
        </select>

        <p>投稿をするには、<a href="log_in.php">こちら</a>からログインしてください。</p>
    <?php endif ?>
</body>

</html>
