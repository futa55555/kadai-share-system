<?php

/**
 * File: includes/response.php
 * Description: JSONレスポンスの汎用関数
 */

function jsonResponse($data = [], $status = "success", $code = 200)
{
    http_response_code($code);
    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode([
        "status" => $status,
        "data" => $data
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

function jsonError($message, $code = 500)
{
    http_response_code($code);
    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode([
        "status" => "error",
        "message" => $message
    ], JSON_UNESCAPED_UNICODE);
    exit;
}
