<?php

/**
 * File: handlers/auth/sign_up.php
 * Description: サインアップの処理ファイル
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


// サインアップ処理
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


    // usernameは空白文字の仕様を禁止
    elseif (preg_match('/^\s+$/', $input_username)) {
        $credential_message = "ユーザー名に空白文字は使えません。";
    }


    // 入力されたusernameからpasswordを取得
    else {
        $db_password_hash = User::getPasswordByUsername(
            $pdo,
            $input_username
        );

        if ($db_password_hash !== "") {
            $credential_message = "ユーザー名：" . $input_username . "は既に使用されています。";
        }


        // ユーザー登録
        else {
            $password_hash = password_hash($input_password, PASSWORD_DEFAULT);

            $success = User::registerUser(
                $pdo,
                $input_username,
                $password_hash
            );

            if ($success === false) {
                $credential_message = "サインアップに失敗しました。";
            } else {
                $credential_message = "サインアップ成功！";
                $credential_success = true;
            }
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
    $location = ($credential_success === true) ? "index.php" : "sign_up.php";
    header("Location: ../../public/pages/" . $location);
    exit;
}
