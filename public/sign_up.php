<!-- sign_up.php -->

<?php
    session_start();

    require '../db.php';

    $user_name = $_SESSION["user_name"] ?? "";

    $user_name_exist = false;

    $sql_insert = <<<SQL
        INSERT INTO user (
            user_name,
            pass
        ) VALUES (
            :user_name,
            :pass
        )
    SQL;
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>サインアップページ</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <h1>
            <a href="index.php<?php $user ?>">
                課題共有システム
            </a>
        </h1>

        <?php if ($user_name): ?>
            <?= $user_name ?>としてログインしています。<br />
        <?php else: ?>
            ログインしていません。<br />
        <?php endif ?>

        <a href="log_in.php">ログイン</a>ページに戻る

        <hr />

        <?php if ($user_name): ?>
            <?php
                header("Location: index.php");
                exit;
            ?>
        <?php endif ?>

        <form action="" method="post">
            ユーザー名：<input type="text" name="user_name" value=<?php if (isset($_POST["user_name"])) { echo $_POST["user_name"]; } ?>><br />
            パスワード：<input type="text" name="pass" value=<?php if (isset($_POST["pass"])) { echo $_POST["pass"]; } ?>><br />
            <input type="submit" name="submit" value="サインアップ">
        </form>

        <?php if (isset($_POST["submit"])): ?>
            <?php
            
                $user_name_input = $_POST["user_name"];
                $pass_input = $_POST["pass"];
    
                function is_input($value) {
                    return isset($value) && $value != "";
                }
            ?>
            
            <?php if (!is_input($user_name_input)): ?>
                ユーザー名が入力されていません。
            <?php elseif (!is_input($pass_input)): ?>
                パスワードが入力されていません。
            <?php else: ?>
                <?php if (isset($_POST["user_name"]) && $_POST["user_name"] != ""): ?>
                    <?php
                        $stmt = $pdo->prepare("SELECT COUNT(user_id) AS cnt FROM user WHERE user_name = :user_name");
                        $stmt->execute(["user_name" => $user_name_input]);
                        $cnt = $stmt->fetch(PDO::FETCH_ASSOC)["cnt"];

                        if ($cnt > 0) { $user_name_exist = true; }
                    ?>
                <?php endif ?>

                <?php if ($_POST["submit"]): ?>
                    <?php if ($cnt == 0): ?>
                        <?php
                            $stmt = $pdo->prepare($sql_insert);
                            $stmt->execute([
                                "user_name" => $user_name_input,
                                "pass" => $pass_input
                            ]);

                            $_SESSION["user_name"] = $user_name_input;
                            header("Location: index.php");
                        ?>
                    <?php else: ?>
                        そのユーザー名は既に使用されています。
                    <?php endif ?>
                <?php endif ?>
            <?php endif ?>
        <?php endif ?>

        <hr />

        <?php
            $stmt = $pdo->query("SELECT user_name FROM user");
            $user_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <div>
            アカウント一覧 <br />
            <ul>
                <?php foreach ($user_list as $user): ?>
                    <li><?= $user["user_name"] . "<br />"; ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    </body>
</html>
