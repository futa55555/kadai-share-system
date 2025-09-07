<!-- kadai_detail.php -->

<?php
    session_start();

    require '../db.php';
    
    $kadai_id = $_GET["kadai_id"];
    
    $stmt = $pdo->prepare("SELECT * FROM kadai WHERE kadai_id = :kadai_id");
    $stmt->execute(["kadai_id" => $kadai_id]);
    $kadai = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("SELECT * FROM comment WHERE kadai_id = :kadai_id");
    $stmt->execute(["kadai_id" => $kadai_id]);
    $comment_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql_comment_insert = <<<SQL
        INSERT INTO comment (
            user_name,
            kadai_id,
            content,
            resolve_file,
            created_at
        ) VALUES (
            :user_name,
            :kadai_id,
            :content,
            :resolve_file,
            :created_at
        );
    SQL;
    
    $sql_kadai_update = <<<SQL
        UPDATE kadai SET
            solve_state = :solve_state
        WHERE
            kadai_id = :kadai_id
        ;
    SQL;
?> 

<?php
    $user_name = $_SESSION["user_name"] ?? "";
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>課題詳細ページ</title>
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
        <?php else: ?>
            ログインしていません。<br />
            <div class="log_in">
                <a href="log_in.php">ログイン</a>
            </div>
        <?php endif ?>

        <hr />

        <div class="kadai_detail">
            <?php
                echo "課題id：" . $kadai["kadai_id"] . "<br />";
                echo "ユーザー名：" . $kadai["user_name"] . "<br />";
                echo "ミッション：" . $kadai["mission_genre"] . "-" . $kadai["mission_detail"] . "<br />";
                echo "やりたいこと：" . nl2br($kadai["goal"]) . "<br />";
                echo "問題点：" . nl2br($kadai["problem"]) . "<br />";
            ?>
            問題ファイル：
            <?php if ($kadai["error_file"]): ?>
                <a href="<?= htmlspecialchars($kadai["error_file"]) ?>" target="_blank">
                    <?= htmlspecialchars(basename($kadai["error_file"])) ?>
                </a>
            <?php else: ?>
                ファイルなし
            <?php endif ?>
            <br />
            <?php
                echo "解決状況：" . ($kadai["solve_state"] == "resolved" ? "解決済み" : "未解決") . "<br />";
                echo "投稿日時：" . $kadai["created_at"] . "<br />";
            ?>
            
            <?php if ($kadai["solve_state"] == "unresolved" && $user_name == $kadai["user_name"]): ?>
                <form action="" method="post">
                    <input type="submit" name="resolved" value="解決した！">
                </form>
            <?php endif ?>
        </div>
        
        <?php
            if (isset($_POST["resolved"])) {
                $stmt = $pdo->prepare($sql_kadai_update);
                $stmt->execute([
                    "solve_state" => "resolved",
                    "kadai_id" => $kadai_id
                ]);
                
                header("Location: kadai_detail.php?kadai_id=$kadai_id");
                exit;
            }
        ?>

        <hr />

        <div class="comment_list">
            <?php foreach ($comment_list as $comment): ?>
                <div class="comment">
                    <?php
                        echo "コメントid：" . $comment["comment_id"] . "<br />";
                        echo "ユーザー名：" . $comment["user_name"] . "<br />";
                        echo "解決策：" . nl2br($comment["content"]) . "<br />";
                    ?>

                    改善ファイル：
                    <?php if ($comment["resolve_file"]): ?>
                        <a href="<?= htmlspecialchars($comment["resolve_file"]) ?>" target="_blank">
                            <?= htmlspecialchars(basename($comment["resolve_file"])) ?>
                        </a>
                    <?php else: ?>
                        ファイルなし
                    <?php endif ?>
                    <?= "<br />" ?>
                    <?php
                        echo "コメント日時：" . $comment["created_at"] . "<br />";
                    ?>
                </div>

                <hr />
            <?php endforeach ?>
        </div>

        <?php if ($user_name): ?>
            <form action="" method="post">
                解決策：<textarea name="content"></textarea><br />
                改善ファイル：<textarea name="resolve_file"><?php if (isset($_POST["resolve_file"])) { echo $_POST["resolve_file"]; } ?></textarea>
                <input type="submit" name="submit">
            </form>
        <?php endif ?>

        <?php if (isset($_POST["submit"])): ?>
            <?php
                $content = $_POST["content"];

                $code = $_POST["resolve_file"];
            ?>

            <?php if (isset($content) && $content != ""): ?>
                <?php
                    if ($code != "") {
                        $resolve_file = "uploads/" . $user_name . "-comment-" . time() . ".txt";
                        file_put_contents($resolve_file, $code);
                    }

                    date_default_timezone_set('Asia/Tokyo');
                    $date = date('Y-m-d H:i:s');

                    $stmt = $pdo->prepare($sql_comment_insert);
                    $stmt->execute([
                        "user_name" => $user_name,
                        "kadai_id" => $kadai_id,
                        "content" => $content,
                        "resolve_file" => $resolve_file,
                        "created_at" => $date
                    ]);

                    header("Location: kadai_detail.php?kadai_id=$kadai_id");
                    exit;
                ?>
            <?php else: ?>
                解決策を入力してください。
            <?php endif ?>
        <?php endif ?>
    </body>
</html>