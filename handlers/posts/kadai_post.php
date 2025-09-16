<?php

/**
 * File: handlers/posts/kadai_post.php
 * Description: 課題投稿の処理ファイル
 */

require '../../includes/db.php';
require '../../models/Kadai.php';
require '../../models/Comment.php';


// セッション情報
session_start();

$username = $_SESSION["username"] ?? "";


// ログインしてなければ戻る
if ($username === "") {
    header("Location: ../../public/pages/kadai_post.php");
    exit;
}


// 投稿処理
$kadai_post_message = "";
$comment_post_message = "";
$post_success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mission_genre = $_POST["mission_genre"];
    $mission_detail = $_POST["mission_detail"];
    $goal = trim($_POST["goal"]);
    $problem = trim($_POST["problem"]);
    $error_code = trim($_POST["error_code"]);
    $resolve_state = $_POST["resolve_state"];
    $content = trim($_POST["content"]);
    $comment_code = trim($_POST["comment_code"]);


    // ログインチェック
    if ($username === "") {
        $kadai_post_message = "ログインしていません。";
    }


    // 未入力チェック（未解決）
    // error_codeは空でもいい
    elseif ($mission_genre === "") {
        $kadai_post_message = "ミッションの大分類を入力してください。";
    } elseif ($mission_detail === "") {
        $kadai_post_message = "ミッションの小分類を入力してください";
    } elseif ($goal === "") {
        $kadai_post_message = "「やりたいこと」を入力してください。";
    } elseif ($problem === "") {
        $kadai_post_message = "「問題点」を入力してください。";
    }


    // 未入力チェック（解決済み）
    // comment_codeは空でもいい
    elseif ($resolve_state === "resolved" && $content === "") {
        $comment_post_message = "解決済みの場合、「解決策」を入力してください。";
    }


    // 入力内容を投稿
    else {
        date_default_timezone_set('Asia/Tokyo');
        $created_at = date('Y-m-d H:i:s');

        $error_filename = "";
        if ($error_code !== "") {
            $dir = __DIR__ . "/../../uploads/kadais/";
            $error_filename = $username . "-kadai-" . date("dHis") . ".txt";
            $error_file = $dir . $error_filename;

            file_put_contents($error_file, $error_code);
        }

        $kadai_post_success = Kadai::postKadai(
            $pdo,
            $username,
            $mission_genre,
            $mission_detail,
            $goal,
            $problem,
            $error_filename,
            $resolve_state,
            $created_at
        );

        if ($kadai_post_success === false) {
            $kadai_post_message = "課題の投稿に失敗しました。";
        } else {
            $kadai_post_message = "課題投稿成功！";
            $post_success = true;


            if ($resolve_state === "resolved") {
                // 課題idを取得
                $kadai_id = Kadai::getLatestKadaiId(
                    $pdo,
                    $username
                );

                if ($kadai_id === null) {
                    $comment_post_message = "課題idの取得に失敗しました。";
                }


                // コメントを投稿
                else {
                    $comment_filename = "";
                    if ($comment_code !== "") {
                        $dir = __DIR__ . "/../../uploads/comments/";
                        $comment_filename = $username . "-comment-" . date("dHis") . ".txt";
                        $comment_file = $dir . $comment_filename;

                        file_put_contents($comment_file, $comment_code);
                    }

                    $comment_post_success = Comment::postComment(
                        $pdo,
                        $username,
                        $kadai_id,
                        'solution',
                        $content,
                        $comment_filename,
                        $created_at
                    );

                    if ($comment_post_success === false) {
                        $comment_post_message = "コメントの投稿に失敗しました。";
                    } else {
                        $comment_post_message = "コメント投稿成功！";
                    }
                }
            }
        }
    }


    // セッションに登録
    if ($post_success === false) {
        $_SESSION["mission_genre"] = $mission_genre;
        $_SESSION["mission_detail"] = $mission_detail;
        $_SESSION["goal"] = $goal;
        $_SESSION["problem"] = $problem;
        $_SESSION["error_code"] = $error_code;
        $_SESSION["resolve_state"] = $resolve_state;
        $_SESSION["content"] = $content;
        $_SESSION["comment_code"] = $comment_code;

        $_SESSION["kadai_post_message"] = $kadai_post_message;
        $_SESSION["comment_post_message"] = $comment_post_message;
    }


    // 然るべきページに遷移
    $location = ($post_success === true) ? "index.html" : "kadai_post.php";
    header("Location: ../../public/pages/" . $location);
    exit;
}
