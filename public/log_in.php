<!-- log_in.php -->

<?php
    session_start();

    require '../db.php';

    $user_name = $_SESSION["user_name"] ?? "";
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>ログインページ</title>
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
            アカウントをもっていない場合⇒<a href="sign_up.php">サインアップ</a>
        <?php endif ?>

        <hr />

        <?php if (!$user_name): ?>
            <form action="" method="post">
                ユーザー名：<input type="text" name="user_name" value=<?php if (isset($_POST["user_name"])) { echo $_POST["user_name"]; } ?>><br />
                パスワード：<input type="text" name="pass" value=<?php if (isset($_POST["pass"])) { echo $_POST["pass"]; } ?>><br />
                <input type="submit" name="submit" value="ログイン">
            </form>
            
            <?php
                function is_input($value) {
                    return isset($value) && $value != "";
                }
            ?>

            <?php if (isset($_POST["submit"])): ?>
                <?php
                    $user_name_input = $_POST["user_name"];
                    $pass_input = $_POST["pass"];
                ?>
            
                <?php if (!is_input($user_name_input)): ?>
                    ユーザー名が入力されていません。
                <?php elseif (!is_input($pass_input)): ?>
                    パスワードが入力されていません。
                <?php endif ?>
            

                <?php if (is_input($user_name_input) && is_input($pass_input)): ?>
                    <?php
                        $stmt = $pdo->prepare("SELECT pass FROM user WHERE user_name = :user_name");
                        $stmt->execute(['user_name' => $user_name_input]);
                        $pass = $stmt->fetch(PDO::FETCH_ASSOC)["pass"];
                    ?>
    
                    <?php if (!$pass): ?>
                        <?= "ユーザー：" . $user_name_input ." が存在しません。"; ?>
                    <?php else: ?>
                        <?php if ($pass == $pass_input): ?>
                            <?php
                                $_SESSION["user_name"] = $user_name_input;
                                header("Location: index.php");
                            ?>
                        <?php else: ?>
                            パスワードが一致しません。
                        <?php endif ?>
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
