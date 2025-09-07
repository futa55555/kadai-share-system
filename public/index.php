<!-- index.php -->

<?php
    session_start();

    require '../db.php';
    
    $stmt = $pdo->query("SELECT * FROM kadai");
    $kadai_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
    $user_name = $_SESSION["user_name"] ?? "";
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>課題一覧ページ</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <h1>
            <a href="index.php">
                課題共有システム
            </a>
        </h1>

        <?php if ($user_name): ?>
            <?= $user_name ?>としてログインしています。<br />
            <div class="log_in">
                <a href="log_out.php"> ログアウト </a>
            </div>
        <?php else: ?>
            ログインしていません。<br />
            <div class="log_in">
                <a href="log_in.php">ログイン</a>
            </div>
        <?php endif ?>

        <?php if ($user_name): ?>
            <hr />
            <div class="kadai_post">
                <a href="kadai_post.php">投稿</a>
            </div>
        <?php endif ?>

        <hr />

        <div class="kadai_list">
            <?php foreach ($kadai_list as $kadai): ?>
                <div class="kadai">
                    課題id：
                    <a href="kadai_detail.php?kadai_id=<?= $kadai["kadai_id"] ?>">
                        <?= $kadai["kadai_id"] . ", "; ?>
                    </a>
                    <br />

                    <?php
                        echo "ユーザー名：" . $kadai["user_name"] . "<br />";
                        echo "ミッション：" . $kadai["mission_genre"] . "-" . $kadai["mission_detail"] . "<br />";
                        echo "やりたいこと：" . $kadai["goal"] . "<br />";
                        echo "解決状況：" . $kadai["solve_state"] . "<br />";
                        echo "投稿日時：" . $kadai["created_at"] . "<br />";
                    ?>

                    <hr />
                </div>
            <?php endforeach ?>
        </div>
    </body>
</html>
