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

    <div class="comment-list">
        <ul id="comment-list"></ul>
    </div>

    <?php if ($username): ?>
        <?php if ($comment_post_message !== ""): ?>
            <?= htmlspecialchars($comment_post_message); ?><br />
        <?php endif ?>

        <div class="comment-post">
            <form action="../../handlers/posts/kadai_detail.php?kadai_id=<?= htmlspecialchars($kadai_id); ?>" method="post">
                コメント：<textarea name="content"><?= htmlspecialchars($solution); ?></textarea><br />
                添付ファイル：<textarea name="resolve_file"><?= htmlspecialchars($solution_code); ?></textarea>
                <input type="submit" name="submit">
            </form>
        </div>
    <?php else: ?>
        <p>コメントをするには、<a href="log_in.php">こちら</a>からログインしてください。</p>
    <?php endif ?>

    <div id="kadai-id" data-kadai-id="<?= htmlspecialchars($kadai_id); ?>"></div>
</body>

</html>
