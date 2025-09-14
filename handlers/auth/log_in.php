<?php

/**
 * File: handlers/auth/log_in.php
 * Description: ログインの処理ファイル
 */

require '../../includes/db.php';
require '../../models/User.php';


// セッション情報
session_start();

$username = $_SESSION["username"] ?? "";


// ログイン済みならトップページへ
if ($username !== "") {
    header("Location: ../../public/pages/index.php");
    exit;
}


// ログイン処理
$credential_message = "";
$credential_success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input_username = $_POST["username"];
    $input_password = $_POST["password"];


    // 未入力チェック
    // ともに未入力の場合、username未入力を出す
    if ($input_username === "") {
        $credential_message = "ユーザー名を入力してください。";
    } elseif ($input_password === "") {
        $credential_message = "パスワードを入力してください。";
    }


    // 入力されたusernameからpasswordを取得
    else {
        $db_password_hash = User::getPasswordByUsername(
            $pdo,
            $input_username
        );

        if ($db_password_hash === "") {
            $credential_message = "ユーザー名：" . $input_username . "は存在しません。";
        }


        // 入力されたパスワードとデータベースのハッシュを比較
        elseif (password_verify($input_password, $db_password_hash) === false) {
            $credential_message = "パスワードが違います。";
        } else {
            $credential_message = "ログイン成功！";
            $credential_success = true;
        }
    }


    // セッションに登録
    if ($credential_success === false) {
        $_SESSION["old_input_username"] = $input_username;
    } else {
        $_SESSION["username"] = $input_username;
    }
    $_SESSION["credential_message"] = $credential_message;


    // 然るべきページに遷移
    $location = ($credential_success === true) ? "index.php" : "log_in.php";
    header("Location: ../../public/pages/" . $location);
    exit;
}
