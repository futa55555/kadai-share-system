<?php

/**
 * File: public/api/kadai/post_kadai.php
 * Description: 課題投稿の処理API
 *
 * @param string username ユーザー名
 * @param int mission_genre ミッション大分類
 * @param int mission_detail ミッション小分類
 * @param string goal やりたいこと
 * @param string problem 問題点
 * @param string error_code エラーファイル
 * @param string resolve_state 解決状況
 *
 * @return JSON []
 */

require '../../../includes/db.php';
require '../../../includes/response.php';
require '../../../models/Kadai.php';


try {
    $data = json_decode(file_get_contents("php://input"), true);

    $username = $data["username"] ?? null;
    $mission_genre = $data["mission_genre"] ?? null;
    $mission_detail = $data["mission_detail"] ?? null;
    $goal = $data["goal"] ?? null;
    $problem = $data["problem"] ?? null;
    $error_code = $data["error_code"];
    $resolve_state = $data["resolve_state"] ?? null;

    if ($username === null) {
        jsonError("Enter username");
    } elseif ($mission_genre === null) {
        jsonError("Select mission genre");
    } elseif ($mission_detail === null) {
        jsonError("Select mission detail");
    } elseif ($goal === null) {
        jsonError("Enter goal");
    } elseif ($problem === null) {
        jsonError("Enter problem");
    } elseif ($resolve_state === null) {
        jsonError("Select resolve state");
    } else {
        date_default_timezone_set('Asia/Tokyo');
        $created_at = date('Y-m-d H:i:s');

        $error_filename = "";
        if ($error_code !== "") {
            $dir = __DIR__ . "/../../../uploads/kadais/";
            $error_filename = $username . "-kadai-" . date("dHis") . ".txt";
            $error_file = $dir . $error_filename;

            $error_file_put_success = file_put_contents($error_file, $error_code);

            if ($error_file_put_success === false) {
                jsonError("Failed to create error file");
            }
        }

        $post_success = Kadai::postKadai(
            $pdo,
            $username,
            $mission_genre,
            $mission_detail,
            $goal,
            $problem,
            $error_filename,
            $resolve_state
        );

        if ($post_success === true) {
            jsonResponse([]);
        } else {
            jsonError("Failed to post kadai");
        }
    }
} catch (Exception $e) {
    jsonError("Unexpected error: " . $e->getMessage());
}
