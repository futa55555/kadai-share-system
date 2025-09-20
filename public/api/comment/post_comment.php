<?php

/**
 * File: public/api/comment/post_comment.php
 * Description: コメント投稿の処理API
 *
 * @param string username ユーザー名
 * @param int kadai_id 課題ID
 * @param string comment_type コメントタイプ
 * @param string content コメント内容
 * @param string comment_code コメントファイル
 *
 * @return JSON []
 */

require '../../../includes/db.php';
require '../../../includes/response.php';
require '../../../models/Comment.php';


try {
    $data = json_decode(file_get_contents("php://input"), true);

    $username = $data["username"] ?? null;
    $kadai_id = $data["kadai_id"] ?? null;
    $comment_type = $data["comment_type"] ?? null;
    $content = $data["content"] ?? null;
    $comment_code = $data["comment_code"];

    if ($username === null || $username === "") {
        jsonError("Username is not specified");
    } elseif ($kadai_id === null || $kadai_id === "") {
        jsonError("Kadai id is not specified");
    } elseif ($comment_type === null || $comment_type === "") {
        jsonError("Enter comment type");
    } elseif ($content === null || $content === "") {
        jsonError("Enter content");
    } else {
        $comment_filename = "";
        if ($comment_code !== "") {
            $dir = __DIR__ . "/../../../uploads/comments/";
            $comment_filename = $username . "-comment-" . date("dHis") . ".txt";
            $comment_file = $dir . $comment_filename;

            $comment_file_put_success = file_put_contents($comment_file, $comment_code);

            if ($comment_file_put_success === false) {
                jsonError("Failed to create comment file");
            }
        }

        $post_success = Comment::postComment(
            $pdo,
            $username,
            $kadai_id,
            $comment_type,
            $content,
            $comment_filename
        );

        if ($post_success === true) {
            jsonResponse([]);
        } else {
            jsonError("Failed to post comment");
        }
    }
} catch (Exception $e) {
    jsonError("Unexpected error: " . $e->getMessage());
}
