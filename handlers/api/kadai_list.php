<?php

/**
 * File: handlers/api/kadai_list.php
 * Description: 課題一覧の取得API
 */

require '../../includes/db.php';
require '../../includes/response.php';

try {
    $sql_get_kadai_list = <<<SQL
        SELECT
            kadai_id
        FROM
            kadai
        ;
    SQL;
    $stmt = $pdo->query($sql_get_kadai_list);
    $kadai_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

    jsonResponse($kadai_list);
} catch (PDOException $e) {
    jsonError($e->getMessage());
}
