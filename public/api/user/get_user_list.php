<?php

/**
 * File: public/api/user/get_user_list.php
 * Description: ユーザー一覧の取得API
 *
 * @param none なし
 *
 * @return JSON [user]
 */

require '../../../includes/db.php';
require '../../../includes/response.php';
require '../../../models/User.php';


try {
    $user_list = User::getUserList($pdo);

    if ($user_list === null) {
        jsonError("ユーザー一覧の取得に失敗しました");
    } else {
        jsonResponse([
            "user_list" => $user_list
        ]);
    }
} catch (Exception $e) {
    jsonError("想定外のエラー：" . $e->getMessage());
}
