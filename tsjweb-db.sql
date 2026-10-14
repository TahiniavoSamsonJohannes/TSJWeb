CREATE DATABASE IF NOT EXISTS `tsjweb`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `tsjweb`;

CREATE TABLE IF NOT EXISTS `users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `firstname` VARCHAR(100) NOT NULL,
  `lastname` VARCHAR(100) NOT NULL,
  `birthday` DATE NOT NULL,
  `sex` VARCHAR(20) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_users_firstname_lastname` (`firstname`, `lastname`)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `chatbox` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `fromUser` INT UNSIGNED NOT NULL,
  `toUser` INT UNSIGNED NOT NULL,
  `messages` TEXT NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_chatbox_from_to` (`fromUser`, `toUser`),
  KEY `idx_chatbox_to_from` (`toUser`, `fromUser`),
  CONSTRAINT `fk_chatbox_sender`
    FOREIGN KEY (`fromUser`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_chatbox_recipient`
    FOREIGN KEY (`toUser`) REFERENCES `users` (`id`)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;