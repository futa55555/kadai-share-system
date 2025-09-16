<?php

/**
 * File: handlers/api/comment_list.php
 * Description: コメント一覧の取得API
 *
 * @param int $kadai_id 課題ID（クエリパラメータ）
 *
 * @return JSON コメント一覧
 */

require '../../includes/db.php';
require '../../includes/response.php';
require '../../models/Comment.php';


$kadai_id = $_GET["kadai_id"] ?? null;
if (!$kadai_id || !is_numeric($kadai_id)) {
    jsonError("Invalid kadai_id", 400);
}


try {
    $comment_list = Comment::getCommentListByKadaiId(
        $pdo,
        $kadai_id
    );

    if ($comment_list === null) {
        jsonError("コメント一覧の取得に失敗しました。");
    } else {
        jsonResponse($comment_list);
    }
} catch (Exception $e) {
    jsonError("Unexpected Error: " . $e->getMessage());
}
