<?php

/**
 * File: public/api/comment/get_comment_list.php
 * Description: コメント一覧の取得API
 *
 * @param int kadai_id 課題ID
 *
 * @return JSON [comment]
 */

require '../../../includes/db.php';
require '../../../includes/response.php';
require '../../../models/Comment.php';


try {
    $kadai_id = $_GET["kadai_id"];
    $option = $_GET["filter"] ?? "";

    if ($kadai_id === null) {
        jsonError("Kadai id is not specified");
    } elseif (is_numeric($kadai_id) === false) {
        jsonError("Kadai id is invalid");
    } else {
        $comment_list = comment::getCommentListByKadaiId($pdo, $kadai_id, $option);

        if ($comment_list === null) {
            jsonError("Kadai id is invalid");
        } else {
            jsonResponse([
                "comment_list" => $comment_list
            ]);
        }
    }
} catch (Exception $e) {
    jsonError("Unexpected error: " . $e->getMessage());
}
