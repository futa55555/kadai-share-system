<?php

/**
 * File: handlers/api/comment_list.php
 * Description: コメント一覧の取得API
 */

require '../../includes/db.php';
require '../../includes/response.php';

$kadai_id = $_GET["kadai_id"] ?? null;
if (!$kadai_id || !is_numeric($kadai_id)) {
    jsonError("Invalid kadai_id", 400);
}

try {
    $sql_get_comment_list = <<<SQL
        SELECT
            comment_id
        FROM
            comment
        WHERE
            kadai_id = :kadai_id
        ;
    SQL;
    $stmt = $pdo->prepare($sql_get_comment_list);
    $stmt->execute([
        "kadai_id" => $kadai_id
    ]);
    $comment_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

    jsonResponse($comment_list);
} catch (PDOException $e) {
    jsonError($e->getMessage());
}
