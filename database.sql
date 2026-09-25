-- =========================================================
-- FindMyLeague — Skema Database MySQL
-- Cara pakai: import file ini via phpMyAdmin, atau:
--   mysql -u root -p < database.sql
-- =========================================================

CREATE DATABASE IF NOT EXISTS findmyleague
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE findmyleague;

-- ---------- TABEL PENGGUNA ----------
CREATE TABLE IF NOT EXISTS users (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(100) NOT NULL,
    email      VARCHAR(150) NOT NULL UNIQUE,
    pass_hash  VARCHAR(255) NOT NULL,          -- password_hash() bawaan PHP
    fav_sport  VARCHAR(50)  DEFAULT '-',
    created_at DATETIME     DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------- TABEL POSTINGAN ----------
CREATE TABLE IF NOT EXISTS posts (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    user_id    INT NOT NULL,
    type       ENUM('turnamen','sparing') NOT NULL,
    sport      VARCHAR(50)  NOT NULL,
    sport_icon VARCHAR(10)  DEFAULT '🏅',
    title      VARCHAR(200) NOT NULL,
    loc        VARCHAR(200) DEFAULT '',
    event_date VARCHAR(100) DEFAULT '',
    fee        VARCHAR(50)  DEFAULT 'Gratis',
    level      VARCHAR(50)  DEFAULT 'Semua Level',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;
