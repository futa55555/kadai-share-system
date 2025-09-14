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
    <link rel="stylesheet" href="../css/comment_list.css">
    <script src="../js/kadai_detail.js" defer></script>
    <script src="../js/comment_list.js" defer></script>
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


    <div class="kadai-detail" id="kadai-detail"></div>


    <hr />


    <div class="comment-list" id="comment-list"></div>


    <?php if ($username !== ""): ?>
        <div class="comment-form">
            <form action="../../handlers/posts/kadai_detail.php?kadai_id=<?= htmlspecialchars($kadai_id) ?>" method="post">
                <div class="comment-group">
                    <label for="comment-type" class="comment-label">
                        種類：
                    </label>

                    <select id="comment-type" name="comment_type" class="comment-input">
                        <option value="solution" <?= ($comment_type === 'solution') ? 'selected' : '' ?>>解決策</option>
                        <option value="empathy" <?= ($comment_type === 'empathy') ? 'selected' : '' ?>>共感</option>
                    </select>
                </div>
                <div class="comment-group">
                    <label for="content" class="comment-label">
                        コメント：
                    </label>

                    <textarea id="content" name="content" class="comment-input"><?= htmlspecialchars($content) ?></textarea>
                </div>
                <div class="comment-group">
                    <label for="comment-code" class="comment-label">
                        添付ファイル：
                    </label>

                    <textarea id="comment-code" name="comment_code" class="comment-input"><?= htmlspecialchars($comment_code) ?></textarea>
                </div>

                <input type="submit" name="submit" class="btn btn-submit" value="投稿">
            </form>
        </div>


        <?php if ($comment_post_message !== ""): ?>
            <div class="error-message">
                <p><?= htmlspecialchars($comment_post_message) ?></p>
            </div>
        <?php endif ?>


    <?php else: ?>
        <div class="login-prompt">
            <p>コメントをするにはログインしてください。</p>
        </div>
    <?php endif ?>


    <div id="kadai-id" data-kadai-id="<?= htmlspecialchars($kadai_id) ?>"></div>
</body>

</html>
