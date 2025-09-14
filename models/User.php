<?php

/**
 * File: models/User.php
 * Description: userテーブルに関するデータベース操作
 */

class User
{
    // ユーザー一覧を取得
    public static function getUserList(
        PDO $pdo
    ): ?array {
        $sql_get_user_list = "SELECT username FROM user;";

        try {
            $stmt = $pdo->query($sql_get_user_list);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("DB Error in getUserList: " . $e->getMessage());

            return null;
        }
    }


    // ユーザー名からパスワードを取得
    public static function getPasswordByUsername(
        PDO $pdo,
        string $username
    ): ?string {
        $sql_get_password_by_username = "SELECT password_hash FROM user WHERE username = :username;";

        try {
            $stmt = $pdo->prepare($sql_get_password_by_username);
            $stmt->execute([
                "username" => $username
            ]);

            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("DB Error in getPasswordByUsername: " . $e->getMessage());

            return null;
        }
    }


    // ユーザー登録
    public static function registerUser(
        PDO $pdo,
        string $username,
        string $password_hash
    ): bool {
        $sql_register_user = "INSERT INTO user (username, password_hash) VALUES (:username, :password_hash);";

        try {
            $stmt = $pdo->prepare($sql_register_user);

            return $stmt->execute([
                "username" => $username,
                "password_hash" => $password_hash
            ]);
        } catch (PDOException $e) {
            error_log("DB Error in registerUser: " . $e->getMessage());

            return false;
        }
    }
}
