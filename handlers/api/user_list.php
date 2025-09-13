<?php

/**
 * File: handlers/api/user_list.php
 * Description: ユーザー一覧の取得API
 */

require '../../includes/db.php';
require '../../includes/response.php';

try {
    $sql_get_user_list = <<<SQL
        SELECT
            username
        FROM
            user
        ;
    SQL;
    $stmt = $pdo->query($sql_get_user_list);
    $user_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

    jsonResponse($user_list);
} catch (PDOException $e) {
    jsonError($e->getMessage());
}
