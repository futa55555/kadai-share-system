<?php

/**
 * File: handlers/auth/log_in.php
 * Description: ログインの処理ファイル
 */

require '../../includes/db.php';


// セッション情報
session_start();

$username = $_SESSION["username"] ?? "";


// ログイン処理
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

        if (!$db_password_hash) {
            $_SESSION["old_input_username"] = $input_username;
            $credential_message = "Not found your username.";
        }


        // 入力されたパスワードとデータベースのハッシュを比較
        elseif (!password_verify($input_password, $db_password_hash)) {
            $_SESSION["old_input_username"] = $input_username;
            $credential_message = "Invalid password.";
        } else {
            $_SESSION["username"] = $input_username;
            $credential_message = "Log-in success!";
            $credential_success = true;
        }
    }


    // セッションに登録
    $_SESSION["credential_message"] = $credential_message;


    // 然るべきページに遷移
    $location = ($credential_success) ? "index.php" : "log_in.php";
    header("Location: ../../public/pages/" . $location);
    exit;
}
