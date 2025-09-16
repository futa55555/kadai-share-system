<?php

/**
 * File: api/auth/signup.php
 * Description: サインアップの処理API
 *
 * @param string username ユーザー名
 * @param string password パスワード
 *
 * @return JSON []
 */

require '../../includes/db.php';
require '../../includes/response.php';
require '../../models/User.php';


try {
    $data = json_decode(file_get_contents("php://input"), true);

    $input_username = $data["username"] ?? null;
    $input_password = $data["password"] ?? null;

    if ($input_username === null) {
        jsonError("Enter username");
    } else {
        $db_password = User::getPasswordByUsername($pdo, $input_username);

        if ($db_password === "") {
            if ($input_password === null) {
                jsonError("Enter password");
            } else {
                $success = User::registerUser($pdo, $input_username, $input_password);

                if ($success === true) {
                    jsonResponse([]);
                } else {
                    jsonError("Failed to register new user");
                }
            }
        } else {
            jsonError($input_username . " already exists");
        }
    }
} catch (Exception $e) {
    jsonError("Unexpected error: " . $e->getMessage());
}
