<?php

/**
 * File: api/auth/logout.php
 * Description: ログアウトの処理API
 *
 * @param none なし
 *
 * @return JSON []
 */

require '../../includes/response.php';


try {
    session_start();
    session_destroy();

    jsonResponse([]);
} catch (Exception $e) {
    jsonError("Unexpected error: " . $e->getMessage());
}
