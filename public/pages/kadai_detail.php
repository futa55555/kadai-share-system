<?php

/**
 * File: public/pages/kadai_detail.php
 * Description: 課題詳細の表示ページ
 */

$kadai_id = $_GET["kadai_id"];

// セッション情報
session_start();

$username = $_SESSION["username"] ?? "";
$comment_type = $_SESSION["comment_type"] ?? "";
$content = $_SESSION["content"] ?? "";
$comment_code = $_SESSION["comment_code"] ?? "";

$comment_post_message = $_SESSION["comment_post_message"] ?? "";

unset(
    $_SESSION["comment_type"],
    $_SESSION["content"],
    $_SESSION["comment_code"],

    $_SESSION["comment_post_message"]
);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>課題詳細ページ</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/kadai_detail.css">
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
        <p><?= htmlspecialchars($username); ?>としてログインしています。</p>
        <p>ログアウトは<a href="../../handlers/auth/log_out.php">こちら</a></p>
    <?php else: ?>
        <p>ログインしていません。</p>
        <p>ログインは<a href="log_in.php">こちら</a></p>
    <?php endif ?>

    <hr />

    <div class="kadai-detail">
        <ul id="kadai-detail"></ul>
    </div>

    <hr />

    <div class="comment-list" id="comment-list"></div>

    <?php if ($username): ?>
        <?php if ($comment_post_message !== ""): ?>
            <?= htmlspecialchars($comment_post_message); ?><br />
        <?php endif ?>

        <div class="comment-post">
            <form action="../../handlers/posts/kadai_detail.php?kadai_id=<?= htmlspecialchars($kadai_id); ?>" method="post">
                種類：
                <select name="comment_type" id="comment-type">
                    <option value="solution" <?= ($comment_type === 'solution') ? 'selected' : ''; ?>>解決策</option>
                    <option value="empathy" <?= ($comment_type === 'empathy') ? 'selected' : ''; ?>>共感</option>
                </select>
                <br />

                コメント：
                <textarea name="content"><?= htmlspecialchars($content); ?></textarea><br />
                添付ファイル：
                <textarea name="comment_code"><?= htmlspecialchars($comment_code); ?></textarea>
                <input type="submit" name="submit">
            </form>
        </div>
    <?php else: ?>
        <p>コメントをするには、<a href="log_in.php">こちら</a>からログインしてください。</p>
    <?php endif ?>

    <div id="kadai-id" data-kadai-id="<?= htmlspecialchars($kadai_id); ?>"></div>
</body>

</html>
