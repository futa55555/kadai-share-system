<?php

/**
 * File: handlers/api/kadai_detail.php
 * Description: 課題詳細の取得API
 */

require '../../includes/db.php';
require '../../includes/response.php';
require '../../models/Kadai.php';


$kadai_id = $_GET["kadai_id"] ?? null;
if (!$kadai_id || !is_numeric($kadai_id)) {
    jsonError("Invalid kadai_id", 400);
}


try {
    $kadai_detail = Kadai::getKadaiDetailById(
        $pdo,
        $kadai_id
    );

    if ($kadai_detail === null) {
        jsonError("課題詳細の取得に失敗しました。");
    } else {
        jsonResponse($kadai_detail);
    }
} catch (PDOException $e) {
    jsonError("Unexpected Error: " . $e->getMessage());
}
