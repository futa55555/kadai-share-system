<?php

/**
 * File: handlers/api/kadai_detail.php
 * Description: 課題詳細の取得API
 */

require '../../includes/db.php';
require '../../includes/response.php';

$kadai_id = $_GET["kadai_id"] ?? null;
if (!$kadai_id || !is_numeric($kadai_id)) {
    jsonError("Invalid kadai_id", 400);
}

try {
    $sql_get_kadai_detail = <<<SQL
        SELECT
            kadai_id,
            username,
            mission_genre,
            mission_detail,
            goal,
            problem,
            error_file,
            resolve_state,
            created_at
        FROM
            kadai
        WHERE
            kadai_id = :kadai_id
        ;
    SQL;
    $stmt = $pdo->prepare($sql_get_kadai_detail);
    $stmt->execute([
        "kadai_id" => $kadai_id
    ]);
    $kadai_detail = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$kadai_detail) {
        jsonError("Kadai not found", 404);
    }

    jsonResponse($kadai_detail);
} catch (PDOException $e) {
    jsonError($e->getMessage());
}
