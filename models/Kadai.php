<?php

/**
 * File: models/Kadai.php
 * Description: kadaiテーブルに関するデータベース操作
 */

class Kadai
{
    // 課題一覧を取得
    public static function getKadaiList(
        PDO $pdo,
        string $option
    ): ?array {
        $sql_get_kadai_list = "SELECT * FROM kadai";
        $params = [];

        if ($option === "") {
            // 何もしない
        } elseif ($option === "unresolved" || $option === "resolved") {
            $sql_get_kadai_list .= " WHERE resolve_state = :resolve_state";
            $params["resolve_state"] = $option;
        } else {
            error_log("Filter option is invalid");
            return null;
        }

        $sql_get_kadai_list .= " ORDER BY created_at DESC";

        try {
            $stmt = $pdo->prepare($sql_get_kadai_list);
            $stmt->execute($params);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("DB Error in getKadaiList: " . $e->getMessage());

            return null;
        }
    }


    // 課題詳細を取得
    public static function getKadaiDetailById(
        PDO $pdo,
        int $kadai_id
    ): ?array {
        $sql_get_kadai_detail_by_id = "SELECT * FROM kadai WHERE kadai_id = :kadai_id";

        try {
            $stmt = $pdo->prepare($sql_get_kadai_detail_by_id);
            $stmt->execute([
                "kadai_id" => $kadai_id
            ]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("DB Error in getKadaiDetailById: " . $e->getMessage());

            return null;
        }
    }


    // ユーザーが投稿した最新の課題のidを取得
    public static function getLatestKadaiId(
        PDO $pdo,
        string $username
    ): ?int {
        $sql_get_latest_kadai_id = "SELECT kadai_id FROM kadai WHERE username = :username ORDER BY kadai_id DESC";

        try {
            $stmt = $pdo->prepare($sql_get_latest_kadai_id);
            $stmt->execute([
                "username" => $username
            ]);

            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("DB Erro in getLatestKadaiId: " . $e->getMessage());

            return null;
        }
    }


    // 課題投稿
    public static function postKadai(
        PDO $pdo,
        string $username,
        int $mission_genre,
        int $mission_detail,
        string $goal,
        string $problem,
        string $error_filename,
        string $resolve_state
    ): bool {
        $sql_post_kadai = <<<SQL
            INSERT INTO
                kadai
            (
                username,
                mission_genre,
                mission_detail,
                goal,
                problem,
                error_filename,
                resolve_state,
                created_at,
                resolved_at
            )
            VALUES
            (
                :username,
                :mission_genre,
                :mission_detail,
                :goal,
                :problem,
                :error_filename,
                :resolve_state,
                :created_at,
                :resolved_at
            )
        SQL;

        try {
            date_default_timezone_set('Asia/Tokyo');
            $date = date('Y-m-d H:i:s');

            $stmt = $pdo->prepare($sql_post_kadai);

            if ($resolve_state === "unresolved") {
                return $stmt->execute([
                    "username" => $username,
                    "mission_genre" => $mission_genre,
                    "mission_detail" => $mission_detail,
                    "goal" => $goal,
                    "problem" => $problem,
                    "error_filename" => $error_filename,
                    "resolve_state" => $resolve_state,
                    "created_at" => $date,
                    "resolved_at" => null
                ]);
            } else {
                return $stmt->execute([
                    "username" => $username,
                    "mission_genre" => $mission_genre,
                    "mission_detail" => $mission_detail,
                    "goal" => $goal,
                    "problem" => $problem,
                    "error_filename" => $error_filename,
                    "resolve_state" => $resolve_state,
                    "created_at" => $date,
                    "resolved_at" => $date
                ]);
            }
        } catch (PDOException $e) {
            error_log("DB Error in postKadai: " . $e->getMessage());

            return false;
        }
    }


    // 解決状況の更新
    public static function updateResolveState(
        PDO $pdo,
        int $kadai_id
    ): bool {
        $sql_update_resolve_state = "UPDATE kadai SET resolve_state = 'resolved', resolved_at = :resolved_at WHERE kadai_id = :kadai_id";

        try {
            date_default_timezone_set('Asia/Tokyo');
            $date = date('Y-m-d H:i:s');

            $stmt = $pdo->prepare($sql_update_resolve_state);

            return $stmt->execute([
                "kadai_id" => $kadai_id,
                "resolved_at" => $date
            ]);
        } catch (PDOException $e) {
            error_log("DB Error in updateResolveState: " . $e->getMessage());

            return false;
        }
    }
}
