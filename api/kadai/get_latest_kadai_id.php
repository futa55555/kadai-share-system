<?php

/**
 * File: api/kadai/get_latest_kadai_id.php
 * Description: 課題一覧の取得API
 *
 * @param none なし
 *
 * @return JSON [kadai]
 */

require '../../includes/db.php';
require '../../includes/response.php';
require '../../models/Kadai.php';


try {
    $data = json_decode(file_get_contents("php://input"), true);

    $username = $data["username"] ?? null;

    $kadai_id = Kadai::getLatestKadaiId($pdo, $username);

    if ($kadai_id === null) {
        jsonError("Failed to get latest kadai id");
    } else {
        jsonResponse([
            "kadai_id" => $kadai_id
        ]);
    }
} catch (Exception $e) {
    jsonError("Unexpected error: " . $e->getMessage());
}
