<?php

/**
 * File: handlers/api/kadai_resolve.php
 * Description: 課題の解決状況を更新するAPI
 */

require '../../includes/db.php';
require '../../includes/response.php';
require '../../models/Kadai.php';


try {
    $data = json_decode(file_get_contents("php://input"), true);
    $kadai_id = $data["kadai_id"] ?? null;

    if ($kadai_id === null) {
        jsonError("kadai_id is required");
    } else {
        $update_success = Kadai::updateResolveState(
            $pdo,
            $kadai_id
        );

        if ($update_success === false) {
            jsonError("解決状況の更新に失敗しました。");
        } else {
            jsonResponse([
                "kadai_id" => $kadai_id,
                "resolve_state" => "resolved"
            ]);
        }
    }
} catch (Exception $e) {
    jsonError("Unexpected Error: " . $e->getMessage());
}
