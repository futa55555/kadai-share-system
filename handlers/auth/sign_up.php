<?php

/**
 * File: handlers/auth/sign_up.php
 * Description: サインアップの処理ファイル
 */

require '../../includes/db.php';


// セッション情報
session_start();

$username = $_SESSION["username"] ?? "";



// サインアップ処理
$credential_message = "";
$credential_success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input_username = $_POST["username"];
    $input_password = $_POST["password"];


    // 未入力チェック
    // ともに未入力の場合、username未入力を出す
    if ($input_username === "") {
        $credential_message = "Please input username!";
    } elseif ($input_password === "") {
        $_SESSION["old_input_username"] = $input_username;
        $credential_message = "Please input password!";
    }


    // usernameは空白文字の仕様を禁止
    elseif (preg_match('/^\s+$/', $input_username)) {
        $_SESSION["old_input_username"] = $input_username;
        $credential_message = "You can't use whitespaces for your username.";
    }


    // 入力されたusernameからpasswordを取得
    else {
        $sql_get_password_hash = <<<SQL
                SELECT
                    password_hash
                FROM
                    user
                WHERE
                    username = :username
                ;
            SQL;

        $stmt = $pdo->prepare($sql_get_password_hash);
        $stmt->execute([
            "username" => $input_username
        ]);
        $db_password_hash = $stmt->fetchColumn();

        if ($db_password_hash) {
            $_SESSION["old_input_username"] = $input_username;
            $credential_message = "Username: " . $input_username . " is already used.";
        }


        // 入力されたパスワードのハッシュを生成
        else {
            $password_hash = password_hash($input_password, PASSWORD_DEFAULT);

            $sql_insert_user = <<<SQL
                INSERT INTO
                    user
                (
                    username,
                    password_hash
                )
                VALUES
                (
                    :username,
                    :password_hash
                )
                ;
            SQL;

            $stmt = $pdo->prepare($sql_insert_user);
            $success = $stmt->execute([
                "username" => $input_username,
                "password_hash" => $password_hash
            ]);

            if (!$success) {
                $_SESSION["old_input_username"] = $input_username;
                $credential_message = "Insert failed!";
            } else {
                $_SESSION["username"] = $input_username;
                $credential_message = "Sign-up success!";
                $credential_success = true;
            }
        }
    }


    // セッションにログインメッセージを登録
    $_SESSION["credential_message"] = $credential_message;


    // 然るべきページに遷移
    $location = ($credential_success) ? "index.php" : "sign_up.php";
    header("Location: ../../public/pages/" . $location);
    exit;
}
