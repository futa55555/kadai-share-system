<?php

/**
 * File: public/api/kadai/get_kadai_list.php
 * Description: 課題一覧の取得API
 *
 * @param none なし
 *
 * @return JSON [kadai]
 */

require '../../../includes/db.php';
require '../../../includes/response.php';
require '../../../models/Kadai.php';


try {
    $kadai_list = kadai::getKadaiList($pdo);

    if ($kadai_list === null) {
        jsonError("課題一覧の取得に失敗しました");
    } else {
        jsonResponse([
            "kadai_list" => $kadai_list
        ]);
    }
} catch (Exception $e) {
    jsonError("想定外のエラー：" . $e->getMessage());
}
