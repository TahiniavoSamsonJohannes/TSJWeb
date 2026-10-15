-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : sql208.infinityfree.com
-- Généré le :  jeu. 15 oct. 2026 à 05:35
-- Version du serveur :  11.4.13-MariaDB
-- Version de PHP :  7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET FOREIGN_KEY_CHECKS = 0;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `if0_43180411_tsjweb`
--

-- --------------------------------------------------------

-- Recréer les tables avant de réimporter les données du dump.
DROP TABLE IF EXISTS `friendships`;
DROP TABLE IF EXISTS `chatbox`;
DROP TABLE IF EXISTS `posts`;
DROP TABLE IF EXISTS `users`;

--
-- Structure de la table `chatbox`
--

CREATE TABLE `chatbox` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fromUser` int(10) UNSIGNED NOT NULL,
  `toUser` int(10) UNSIGNED NOT NULL,
  `messages` text NOT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `chatbox`
--

INSERT INTO `chatbox` (`id`, `fromUser`, `toUser`, `messages`) VALUES
(1, 1, 2, 'Hello'),
(2, 2, 1, 'Akory'),
(3, 3, 1, 'Coucou kolahy'),
(4, 1, 3, 'Akory izy io'),
(5, 1, 3, 'Maresaky nareo ao?'),
(6, 3, 1, '😅😅😅🤣🤣🤣. Da mety kala'),
(7, 1, 3, '🤭hehe'),
(8, 3, 1, 'Tsisy fa Zao'),
(9, 3, 1, 'Mahay raha'),
(10, 3, 1, 'Kay Zao izio'),
(11, 3, 1, 'Iza moa i Hary?'),
(12, 3, 1, 'Nao??'),
(13, 1, 3, 'C\'est la femme ménagère'),
(14, 3, 1, 'Kay ,  votre bonne?'),
(15, 1, 3, 'Oui, en fait, elles sont deux, Prisca celle qui fait la cuisine et range le salon et la salle à manger. Quant à Hary, elle est plutôt babysitter, elle s\'occupe de la petite Zoé, et aussi des deux autres mioches, Kanto et Fitia, elle leur fait prendre le bain et les habille. Mais elle range aussi une partie de la maison, la chambre de mamy, et la mienne juste un coup de balai vu que je range moi-même mon lit.');

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `visibility` enum('public','private') NOT NULL DEFAULT 'private'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `content`, `image_path`, `created_at`) VALUES
(1, 1, 'Hary et Prisca', 'uploads/posts/01cbe25110b9f74b5f63ada7a6bc36dd.jpg', '2026-10-15 07:57:20'),
(2, 3, 'Believe in yourself🥰', 'uploads/posts/96bc5003c819fd255f2cd5814991bf9d.jpg', '2026-10-15 08:00:34'),
(3, 3, 'Me and my bestie at church🥰👑', 'uploads/posts/381603b7453240b4c57848724f152eb3.jpg', '2026-10-15 08:05:04'),
(4, 1, 'Mon logo', 'uploads/posts/8b0b1bd2a5957f278711a5e28ca964fa.png', '2026-10-15 08:05:25');

-- Les publications exportees sont privees dans cette importation.
UPDATE `posts` SET `visibility` = 'private' WHERE `visibility` = 'public';

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `birthday` date NOT NULL,
  `sex` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `birthday`, `sex`, `password`) VALUES
(1, 'Samson', 'TAHINIAVO ', '2003-03-05', 'M', '202cb962ac59075b964b07152d234b70'),
(2, 'Hary', 'RASOARINOMENJANAHARY ', '2000-09-18', 'F', '1b1464a2413c5dfbf6a472213ba535d6'),
(3, 'Danielle ', 'Tahiniavo ', '2010-08-20', 'Female', '47b02dbfb74662552299ddb5c4784715');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `chatbox`
--
ALTER TABLE `chatbox`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_chatbox_from_to` (`fromUser`,`toUser`),
  ADD KEY `idx_chatbox_to_from` (`toUser`,`fromUser`);

--
-- Index pour la table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_posts_created_at` (`created_at`),
  ADD KEY `idx_posts_user_id` (`user_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `uq_users_firstname_lastname` (`firstname`,`lastname`);

-- Demandes d'amitie et amities acceptees.
CREATE TABLE `friendships` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `friend_id` int(10) UNSIGNED NOT NULL,
  `status` enum('pending','accepted','removed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_friendship_pair` (`user_id`,`friend_id`),
  KEY `idx_friendship_friend_status` (`friend_id`,`status`),
  CONSTRAINT `fk_friendships_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_friendships_friend` FOREIGN KEY (`friend_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `chk_friendship_pair` CHECK (`user_id` <> `friend_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `chatbox`
--
ALTER TABLE `chatbox`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `chatbox`
--
ALTER TABLE `chatbox`
  ADD CONSTRAINT `fk_chatbox_recipient` FOREIGN KEY (`toUser`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_chatbox_sender` FOREIGN KEY (`fromUser`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_posts_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;
SET FOREIGN_KEY_CHECKS = 1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
