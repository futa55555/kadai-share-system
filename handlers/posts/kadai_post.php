<?php

/**
 * File: handlers/posts/kadai_post.php
 * Description: 課題投稿の処理ファイル
 */

require '../../includes/db.php';


// セッション情報
session_start();

$username = $_SESSION["username"] ?? "";


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
        $sql_insert_kadai = <<<SQL
            INSERT INTO
                kadai
            (
                username,
                mission_genre,
                mission_detail,
                goal,
                problem,
                error_file,
                resolve_state,
                created_at
            )
            VALUES
            (
                :username,
                :mission_genre,
                :mission_detail,
                :goal,
                :problem,
                :error_file,
                :resolve_state,
                :created_at
            )
            ;
        SQL;

        date_default_timezone_set('Asia/Tokyo');
        $date = date('Y-m-d H:i:s');

        if ($error_code !== "") {
            $error_file = "uploads/kadais/" . $username . "-kadai-" . date("dHis", $now) . ".txt";
            file_put_contents($error_file, $error_code);
        }

        $stmt = $pdo->prepare($sql_insert_kadai);
        $kadai_post_success = $stmt->execute([
            "username" => $username,
            "mission_genre" => $mission_genre,
            "mission_detail" => $mission_detail,
            "goal" => $goal,
            "problem" => $problem,
            "error_file" => $error_file,
            "resolve_state" => $resolve_state,
            "created_at" => $date
        ]);

        if (!$kadai_post_success) {
            $kadai_post_message = "課題の投稿に失敗しました。";
        } else {
            $kadai_post_message = "課題投稿成功！";
            $post_success = true;


            if ($resolve_state === "resolved") {
                // コメントを投稿
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
                        'solution',
                        :content,
                        :comment_file,
                        :created_at
                    )
                    ;
                SQL;

                $sql_get_kadai_id = <<<SQL
                    SELECT
                        kadai_id
                    FROM
                        kadai
                    WHERE
                        username = :username
                    ORDER BY
                        kadai_id DESC
                    ;
                SQL;

                $stmt = $pdo->prepare($sql_get_kadai_id);
                $stmt->execute([
                    "username" => $username
                ]);
                $kadai_id = $stmt->fetchColumn();

                if ($comment_code !== "") {
                    $comment_file = "uploads/comments/" . $username . "-kadai-" . date("dHis", $now) . ".txt";
                    file_put_contents($comment_file, $comment_code);
                }

                $stmt = $pdo->prepare($sql_insert_comment);
                $comment_post_success = $stmt->execute([
                    "username" => $username,
                    "kadai_id" => $kadai_id,
                    "content" => $content,
                    "comment_file" => $comment_file,
                    "created_at" => $date
                ]);

                if (!$comment_post_success) {
                    $comment_post_message = "コメントの投稿に失敗しました。";
                } else {
                    $comment_post_message = "コメント投稿成功！";
                }
            }
        }
    }


    // セッションに登録
    if (!$post_success) {
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
    $location = ($post_success) ? "index.php" : "kadai_post.php";
    header("Location: ../../public/pages/" . $location);
    exit;
}
