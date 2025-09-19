<?php

/**
 * File: public/api/kadai/get_kadai_detail.php
 * Description: 課題詳細の取得API
 *
 * @param int kadai_id 課題ID
 *
 * @return JSON kadai
 */

require '../../../includes/db.php';
require '../../../includes/response.php';
require '../../../models/Kadai.php';


try {
    $kadai_id = $_GET["kadai_id"];

    if ($kadai_id === null) {
        jsonError("Kadai id is not specified");
    } elseif (is_numeric($kadai_id) === false) {
        jsonError("kadai id is invalid");
    } else {
        $kadai_detail = Kadai::getKadaiDetailById($pdo, $kadai_id);

        if ($kadai_detail === null) {
            jsonError("Kadai id is invalid");
        } else {
            jsonResponse([
                "kadai_id" => $kadai_detail["kadai_id"],
                "username" => $kadai_detail["username"],
                "mission_genre" => $kadai_detail["mission_genre"],
                "mission_detail" => $kadai_detail["mission_detail"],
                "goal" => $kadai_detail["goal"],
                "problem" => $kadai_detail["problem"],
                "error_filename" => $kadai_detail["error_filename"],
                "resolve_state" => $kadai_detail["resolve_state"],
                "created_at" => $kadai_detail["created_at"],
                "resolved_at" => $kadai_detail["resolved_at"]
            ]);
        }
    }
} catch (Exception $e) {
    jsonError("Unexpected error: " . $e->getMessage());
}
