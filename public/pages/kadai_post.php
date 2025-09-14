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


    <div class="user-message">
        <?php if ($username !== ""): ?>
            <div class="login-message">
                <p><?= htmlspecialchars($username) ?>としてログインしています。</p>
                <p>ログアウトは<a href="../../handlers/auth/log_out.php">こちら</a></p>
            </div>
        <?php else: ?>
            <div class="login-message">
                <p>ログインしていません。</p>
                <p>ログインは<a href="log_in.php">こちら</a></p>
            </div>
        <?php endif ?>
    </div>


    <hr />


    <?php if ($username !== ""): ?>
        <div class="kadai-form">
            <form action="../../handlers/posts/kadai_post.php" method="post">
                <div class="kadai-group">
                    <label for="mission-genre" class="kadai-label">
                        ミッション：
                    </label>

                    <select name="mission_genre" id="mission-genre" class="kadai-input mission-genre" data-prev-genre="<?= htmlspecialchars($mission_genre) ?>" required></select>

                    <span class="separator">-</span>

                    <select name="mission_detail" id="mission-detail" class="kadai-input mission-detail" data-prev-detail="<?= htmlspecialchars($mission_detail) ?>" required></select>
                </div>

                <div class="kadai-group">
                    <label for="goal" class="kadai-label">
                        やりたいこと：
                    </label>

                    <input type="text" id="goal" name="goal" class="kadai-input" value="<?= htmlspecialchars($goal) ?>">

                </div>
                <div class="kadai-group">
                    <label for="problem" class="kadai-label">
                        問題点：
                    </label>

                    <textarea id="problem" name="problem" class="kadai-input"><?= htmlspecialchars($problem) ?></textarea>

                </div>
                <div class="kadai-group">
                    <label for="error-code" class="kadai-label">
                        問題ファイル：
                    </label>

                    <textarea id="error-code" name="error_code" class="kadai-input"><?= htmlspecialchars($error_code) ?></textarea>
                </div>
                <div class="kadai-group">
                    <label for="resolve-state" class="kadai-label">
                        解決状況：
                    </label>

                    <select id="resolve-state" name="resolve_state" class="kadai-input">
                        <option value="unresolved" <?= ($resolve_state === 'unresolved') ? 'selected' : '' ?>>未解決</option>
                        <option value="resolved" <?= ($resolve_state === 'resolved') ? 'selected' : '' ?>>解決済み</option>
                    </select>
                </div>

                <div id="comment-box" style="display:none;">
                    <div class="comment-group">
                        <label for="content" class="comment-label">
                            解決策：
                        </label>

                        <textarea id="content" name="content" class="comment-input"><?= htmlspecialchars($content) ?></textarea>
                    </div>

                    <div class="comment-group">
                        <label for="comment-code" class="comment-label">
                            解決ファイル：
                        </label>

                        <textarea id="comment-code" name="comment_code" class="comment-input" placeholder="空欄可"><?= htmlspecialchars($comment_code) ?></textarea>
                    </div>
                </div>

                <input type="submit" name="submit" class="btn btn-submit" value="投稿">
            </form>
        </div>


        <?php if ($kadai_post_message !== "" || $comment_post_message !== ""): ?>
            <div class="error-message">
                <?php if ($kadai_post_message !== ""): ?>
                    <p><?= htmlspecialchars($kadai_post_message) ?></p>
                <?php endif ?>
                <?php if ($comment_post_message !== ""): ?>
                    <p><?= htmlspecialchars($comment_post_message) ?></p>
                <?php endif ?>
            </div>
        <?php endif ?>
    <?php else: ?>
        <!-- ダミー -->
        <select id="mission-genre" style="display:none;"></select>
        <select id="mission-detail" style="display:none;"></select>
        <select id="resolve-state" style="display:none;">
            <option value="unresolved" selected></option>
        </select>


        <div class="login-prompt">
            <p>投稿をするにはログインしてください。</p>
        </div>
    <?php endif ?>
</body>

</html>
