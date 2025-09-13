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
    $error_code = $_POST["error_code"];
    $resolve_state = $_POST["resolve_state"];
    $solution = trim($_POST["solution"]);
    $solution_code = $_POST["solution_code"];


    // 未入力チェック（未解決）
    // error_codeは空でもいい
    if ($mission_genre === "") {
        $kadai_post_message = "Mission_genre is empty.";
    } elseif ($mission_detail === "") {
        $kadai_post_message = "Mission_detail is empty.";
    } elseif ($goal === "") {
        $kadai_post_message = "Goal is empty.";
    } elseif ($problem === "") {
        $kadai_post_message = "Problem is empty.";
    }


    // 未入力チェック（解決済み）
    // solution_codeは空でもいい
    elseif ($resolve_state === "resolved" && $solution === "") {
        $comment_post_message = "Solution is empty.";
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

        $error_file = "uploads/kadais/" . $username . "-kadai-" . date("dHis", $now) . ".txt";
        file_put_contents($error_file, $error_code);

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
            $kadai_post_message = "Kadai post failed!";
        } else {
            $kadai_post_message = "Kadai post success!";
            $post_success = true;


            if ($resolve_state === "resolved") {
                // コメントを投稿
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

                $solution_file = "uploads/comments/" . $username . "-kadai-" . date("dHis", $now) . ".txt";
                file_put_contents($solution_file, $solution_code);

                $stmt = $pdo->prepare($sql_insert_comment);
                $comment_post_success = $stmt->execute([
                    "username" => $username,
                    "kadai_id" => $kadai_id,
                    "solution" => $solution,
                    "solution_file" => $solution_file,
                    "created_at" => $date
                ]);

                if (!$comment_post_success) {
                    $comment_post_message = "Comment post failed!";
                } else {
                    $comment_post_message = "Comment post success";
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
        $_SESSION["solution"] = $solution;
        $_SESSION["solution_code"] = $solution_code;

        $_SESSION["kadai_post_message"] = $kadai_post_message;
        $_SESSION["comment_post_message"] = $comment_post_message;
    }


    // 然るべきページに遷移
    $location = ($post_success) ? "index.php" : "kadai_post.php";
    header("Location: ../../public/pages/" . $location);
    exit;
}
