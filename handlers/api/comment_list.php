<?php

/**
 * File: handlers/api/comment_list.php
 * Description: コメント一覧の取得API
 */

require '../../includes/db.php';
require '../../includes/response.php';

try {
    $sql_get_comment_list = <<<SQL
        SELECT
            comment_id
        FROM
            comment
        ;
    SQL;
    $stmt = $pdo->query($sql_get_comment_list);
    $comment_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

    jsonResponse($comment_list);
} catch (PDOException $e) {
    jsonError($e->getMessage());
}
