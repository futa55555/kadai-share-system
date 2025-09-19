-- ==========================
-- ユーザーテーブル
-- ==========================
DROP TABLE IF EXISTS user;
CREATE TABLE user (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    password_hash VARCHAR(255)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
-- ==========================
-- 課題テーブル
-- ==========================
DROP TABLE IF EXISTS kadai;
CREATE TABLE kadai (
    kadai_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    mission_genre INT NOT NULL,
    mission_detail INT NOT NULL,
    goal VARCHAR(200) NOT NULL,
    problem TEXT NOT NULL,
    error_filename VARCHAR(255),
    resolve_state VARCHAR(20),
    created_at DATETIME NOT NULL,
    resolved_at DATETIME
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
-- ==========================
-- 解決策テーブル
-- ==========================
DROP TABLE IF EXISTS comment;
CREATE TABLE comment (
    comment_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    kadai_id INT NOT NULL,
    comment_type ENUM('solution', 'empathy') NOT NULL,
    content TEXT NOT NULL,
    comment_filename VARCHAR(255),
    created_at DATETIME NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
