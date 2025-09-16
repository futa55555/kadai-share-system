<?php

/**
 * File: api/auth/get_session.php
 * Description: ログインセッションの取得API
 *
 * @param none なし
 *
 * @return JSON []
 */

require '../../includes/db.php';
require '../../includes/response.php';

try {
    session_start();

    $username = $_SESSION["username"] ?? null;

    if ($username === null) {
        jsonResponse([
            "username" => null
        ]);
    } else {
        jsonResponse([
            "username" => $username
        ]);
    }
} catch (Exception $e) {
    jsonError("想定外のエラー：" . $e->getMessage());
}
