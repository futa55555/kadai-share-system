<?php

/**
 * File: handlers/api/kadai_list.php
 * Description: 課題一覧の取得API
 *
 * @param none なし
 *
 * @return JSON 課題一覧
 */

require '../../includes/db.php';
require '../../includes/response.php';
require '../../models/Kadai.php';


try {
    $kadai_list = Kadai::getKadaiList($pdo);

    if ($kadai_list === null) {
        jsonError("課題一覧の取得に失敗しました。");
    } else {
        jsonResponse($kadai_list);
    }
} catch (Exception $e) {
    jsonError("Unexpected Error: " . $e->getMessage());
}
