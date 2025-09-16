<?php

/**
 * File: models/Comment.php
 * Description: commentテーブルに関するデータベース操作
 */

class Comment
{
    // コメント一覧を取得
    public static function getCommentListByKadaiId(
        PDO $pdo,
        int $kadai_id
    ): ?array {
        $sql_get_comment_list = "SELECT * FROM comment WHERE kadai_id = :kadai_id;";

        try {
            $stmt = $pdo->prepare($sql_get_comment_list);
            $stmt->execute([
                "kadai_id" => $kadai_id
            ]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("DB Error in getCommentList: " . $e->getMessage());

            return null;
        }
    }


    // コメント投稿
    public static function postComment(
        PDO $pdo,
        string $username,
        int $kadai_id,
        string $comment_type,
        string $content,
        string $comment_filename
    ): bool {
        $sql_post_comment = <<<SQL
            INSERT INTO
                comment
            (
                username,
                kadai_id,
                comment_type,
                content,
                comment_filename,
                created_at
            )
            VALUES
            (
                :username,
                :kadai_id,
                :comment_type,
                :content,
                :comment_filename,
                :created_at
            )
        SQL;

        try {
            date_default_timezone_set('Asia/Tokyo');
            $date = date('Y-m-d H:i:s');

            $stmt = $pdo->prepare($sql_post_comment);

            return $stmt->execute([
                "username" => $username,
                "kadai_id" => $kadai_id,
                "comment_type" => $comment_type,
                "content" => $content,
                "comment_filename" => $comment_filename,
                "created_at" => $date
            ]);
        } catch (PDOException $e) {
            error_log("DB Error in postComment: " . $e->getMessage());

            return false;
        }
    }
}
