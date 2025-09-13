<?php

/**
 * File: handlers/posts/kadai_detail.php
 * Description: 課題詳細の処理ファイル
 */

require '../../includes/db.php';


// セッション情報
session_start();

$username = $_SESSION["username"] ?? "";
$kadai_id = $_GET["kadai_id"] ?? null;


// コメント処理
$comment_post_message = "";
$post_success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $comment_type = $_POST["comment_type"];
    $content = trim($_POST["content"]);
    $comment_code = trim($_POST["comment_code"]);


    // ログインチェック
    if ($username === "") {
        $kadai_post_message = "ログインしていません。";
    }


    // 未入力チェック
    if (!$kadai_id || !is_numeric($kadai_id)) {
        $comment_post_message = "課題が指定されていません。";
    } elseif ($content === "") {
        $comment_post_message = "「コメント」を入力してください。";
    }


    // 入力内容を投稿
    else {
        $sql_insert_comment = <<<SQL
            INSERT INTO
                comment
            (
                username,
                kadai_id,
                comment_type,
                content,
                comment_file,
                created_at
            )
            VALUES
            (
                :username,
                :kadai_id,
                :comment_type,
                :content,
                :comment_file,
                :created_at
            )
        SQL;

        date_default_timezone_set('Asia/Tokyo');
        $date = date('Y-m-d H:i:s');

        if ($comment_code !== "") {
            $comment_file = "uploads/comments/" . $username . "-comment-" . date("dHis", $now) . ".txt";
            file_put_contents($comment_file, $comment_code);
        }

        $stmt = $pdo->prepare($sql_insert_comment);
        $post_success = $stmt->execute([
            "username" => $username,
            "kadai_id" => $kadai_id,
            "comment_type" => $comment_type,
            "content" => $content,
            "comment_file" => $comment_file,
            "created_at" => $date
        ]);

        if (!$post_success) {
            $comment_post_message = "コメントの投稿に失敗しました。";
        } else {
            $comment_post_message = "コメント投稿成功！";
            $post_success = true;
        }
    }


    // セッションに登録
    if (!$post_success) {
        $_SESSION["comment_type"] = $comment_type;
        $_SESSION["content"] = $content;
        $_SESSION["comment_code"] = $comment_code;

        $_SESSION["comment_post_message"] = $comment_post_message;
    }


    // 然るべきページに遷移
    header("Location: ../../public/pages/kadai_detail.php?kadai_id=" . $kadai_id);
    exit;
}
