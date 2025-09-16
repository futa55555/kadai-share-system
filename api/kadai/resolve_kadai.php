<?php

/**
 * File: api/kadai/resolve_kadai.php
 * Description: 解決状況の更新の処理API
 *
 * @param int kadai_id 課題ID
 *
 * @return JSON []
 */

require '../../includes/db.php';
require '../../includes/response.php';
require '../../models/Kadai.php';


try {
    $data = json_decode(file_get_contents("php://input"), true);

    $kadai_id = $data["kadai_id"] ?? null;

    if ($kadai_id === null) {
        jsonError("Kadai id is not specified");
    } else {
        $success = Kadai::updateResolveState(
            $pdo,
            $kadai_id
        );

        if ($success === true) {
            jsonResponse([
                "username" => $username,
                "kadai_id" => $kadai_id
            ]);
        } else {
            jsonError("Failed to update resolve state");
        }
    }
} catch (Exception $e) {
    jsonError("Unexpected error: " . $e->getMessage());
}
