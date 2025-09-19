<?php

/**
 * File: public/api/auth/login.php
 * Description: ログインの処理API
 *
 * @param string username ユーザー名
 * @param string password パスワード
 *
 * @return JSON []
 */

require '../../../includes/db.php';
require '../../../includes/response.php';
require '../../../models/User.php';


try {
    $data = json_decode(file_get_contents("php://input"), true);

    $input_username = $data["username"];
    $input_password = $data["password"];

    if ($input_username === null || $input_username === "") {
        jsonError("Enter username");
    } elseif ($input_password === null || $input_password === "") {
        jsonError("Enter password");
    } else {
        $db_password = User::getPasswordByUsername(
            $pdo,
            $input_username
        );

        if ($db_password === null) {
            jsonError($input_username . " does not exist");
        } else {
            if (password_verify($input_password, $db_password) === true) {
                session_start();
                $_SESSION["username"] = $input_username;

                jsonResponse([]);
            } else {
                jsonError("Password is incorrect");
            }
        }
    }
} catch (Exception $e) {
    jsonError("Unexpected error: " . $e->getMessage());
}
