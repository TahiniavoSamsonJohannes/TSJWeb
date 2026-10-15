CREATE DATABASE IF NOT EXISTS `if0_43180411_tsjweb`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `if0_43180411_tsjweb`;

CREATE TABLE IF NOT EXISTS `users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `firstname` VARCHAR(100) NOT NULL,
  `lastname` VARCHAR(100) NOT NULL,
  `birthday` DATE NOT NULL,
  `sex` VARCHAR(20) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `profile_image` VARCHAR(32) NOT NULL DEFAULT 'cat.png',
  `last_seen` DATETIME DEFAULT NULL,
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
  `image_path` VARCHAR(255) DEFAULT NULL,
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

CREATE TABLE IF NOT EXISTS `friendships` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED NOT NULL,
  `friend_id` INT UNSIGNED NOT NULL,
  `status` ENUM('pending','accepted','removed') NOT NULL DEFAULT 'pending',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_friendship_pair` (`user_id`,`friend_id`),
  KEY `idx_friendship_friend_status` (`friend_id`,`status`),
  CONSTRAINT `fk_friendships_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_friendships_friend` FOREIGN KEY (`friend_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `posts` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED NOT NULL,
  `content` TEXT NOT NULL,
  `image_path` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `visibility` ENUM('public','private') NOT NULL DEFAULT 'private',
  PRIMARY KEY (`id`),
  KEY `idx_posts_created_at` (`created_at`),
  KEY `idx_posts_user_id` (`user_id`),
  CONSTRAINT `fk_posts_user`
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `post_likes` (
  `post_id` BIGINT UNSIGNED NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`post_id`,`user_id`),
  KEY `idx_post_likes_user` (`user_id`),
  CONSTRAINT `fk_post_likes_post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_post_likes_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

