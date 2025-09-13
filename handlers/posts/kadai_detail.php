<?php

/**
 * File: handlers/posts/kadai_detail.php
 * Description: 課題詳細の処理ファイル
 */

require '../../includes/db.php';


// セッション情報
session_start();

$username = $_SESSION["username"] ?? "";


// コメント処理
$comment_post_message = "";
$post_success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $kadai_id = $_GET["kadai_id"] ?? null;

    $solution = trim($_POST["solution"]);
    $solution_code = $_POST["solution"];


    // ログインチェック
    if ($username === "") {
        $kadai_post_message = "ログインしていません。";
    }


    // 未入力チェック
    if (!$kadai_id || !is_numeric($kadai_id)) {
        $comment_post_message = "課題が指定されていません。";
    } elseif ($solution === "") {
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
                solution,
                solution_file,
                created_at
            )
            VALUES
            (
                :username,
                :kadai_id,
                :solution,
                :solution_file,
                :created_at
            )
        SQL;

        date_default_timezone_set('Asia/Tokyo');
        $date = date('Y-m-d H:i:s');

        $solution_file = "uploads/comments/" . $username . "-comment-" . date("dHis", $now) . ".txt";
        file_put_contents($solution_file, $solution_code);

        $stmt = $pdo->prepare($sql_insert_comment);
        $post_success = $stmt->execute([
            "user_name" => $useranem,
            "kadai_id" => $kadai_id,
            "solution" => $solution,
            "solution_file" => $solution_file,
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
        $_SESSION["solution"] = $solution;
        $_SESSION["solution_code"] = $solution_code;

        $_SESSION["comment_post_message"] = $comment_post_message;
    }


    // 然るべきページに遷移
    header("Location ../../public/pages/kadai_detail.php?kadai_id=" . $kadai_id);
    exit;
}
