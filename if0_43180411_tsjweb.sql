-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : sql208.infinityfree.com
-- Généré le :  jeu. 15 oct. 2026 à 16:38
-- Version du serveur :  11.4.13-MariaDB
-- Version de PHP :  7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";
SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS `post_likes`,`chatbox`,`friendships`,`posts`,`users`;
SET FOREIGN_KEY_CHECKS=1;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `if0_43180411_tsjweb`
--

-- --------------------------------------------------------

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

INSERT INTO `chatbox` (`id`, `fromUser`, `toUser`, `messages`, `image_path`) VALUES
(1, 1, 2, 'Hello', NULL),
(2, 2, 1, 'Akory', NULL),
(3, 3, 1, 'Coucou kolahy', NULL),
(4, 1, 3, 'Akory izy io', NULL),
(5, 1, 3, 'Maresaky nareo ao?', NULL),
(6, 3, 1, '😅😅😅🤣🤣🤣. Da mety kala', NULL),
(7, 1, 3, '🤭hehe', NULL),
(8, 3, 1, 'Tsisy fa Zao', NULL),
(9, 3, 1, 'Mahay raha', NULL),
(10, 3, 1, 'Kay Zao izio', NULL),
(11, 3, 1, 'Iza moa i Hary?', NULL),
(12, 3, 1, 'Nao??', NULL),
(13, 1, 3, 'C\'est la femme ménagère', NULL),
(14, 3, 1, 'Kay ,  votre bonne?', NULL),
(15, 1, 3, 'Oui, en fait, elles sont deux, Prisca celle qui fait la cuisine et range le salon et la salle à manger. Quant à Hary, elle est plutôt babysitter, elle s\'occupe de la petite Zoé, et aussi des deux autres mioches, Kanto et Fitia, elle leur fait prendre le bain et les habille. Mais elle range aussi une partie de la maison, la chambre de mamy, et la mienne juste un coup de balai vu que je range moi-même mon lit.', NULL),
(16, 1, 2, '', 'uploads/messages/889f7c38e43a6c998dfe30d7b2ea831f.jpg'),
(17, 1, 6, 'Hello', NULL),
(18, 1, 6, '', 'uploads/messages/28694207047cc0f7989af12ca5009d35.jpg'),
(19, 1, 6, 'Look', NULL),
(20, 1, 6, '', 'uploads/messages/abbbdcc574ba4f54348b4861f23d4f4e.jpg'),
(21, 1, 6, 'Hehe', NULL),
(22, 1, 7, 'Salut', NULL),
(23, 7, 1, 'Zan aazz', NULL),
(24, 1, 7, '', 'uploads/messages/2c3e9a96618fb28ff875b05915185488.jpg'),
(25, 1, 7, 'Samedi — Messages à ma meilleure amie 💬\r\n\r\n10 h 15\r\n\r\nCoucou ! Tu ne devineras jamais qui j\'ai croisé à la plage aujourd\'hui… Meursault ! Oui, lui, celui dont la mère vient de mourir. Il avait l\'air tellement normal. Ça m\'a surprise, je ne sais pas trop quoi penser. 🤔\r\n\r\n11 h 00\r\n\r\nOn s\'est baignés ensemble. Il souriait, il semblait heureux… Comment peut-on être aussi tranquille après la mort de sa mère ? Je n\'ai pas osé lui poser la question. Il est tellement difficile à comprendre.\r\n\r\n14 h 00\r\n\r\nJe lui ai proposé d\'aller au cinéma. Il a accepté sans hésiter ! On a regardé une comédie et on a même ri ensemble. Pendant un instant, j\'ai oublié mes interrogations. Peut-être qu\'il est simplement différent des autres ?\r\n\r\n17 h 30\r\n\r\nOn s\'est quittés après le film. Il est rentré chez lui, comme si cette journée n\'avait rien eu de particulier.\r\n\r\nJe ne sais pas s\'il est insensible ou s\'il cache ses émotions. Ce qui est étrange, c\'est que son indifférence me trouble autant qu\'elle m\'attire. J\'aimerais vraiment comprendre ce qui se passe dans sa tête… ❤️', NULL),
(26, 1, 7, 'Io ny Atelier 2 tsika', NULL),
(27, 7, 1, 'Merci pour ton initiative', NULL),
(28, 7, 2, 'Salut', NULL),
(29, 7, 2, 'Ka akor droky', NULL),
(30, 7, 2, '', 'uploads/messages/906e5d28c07cc344735745a79c916b34.jpg'),
(32, 7, 2, 'Dry no sisa andrasana', NULL),
(33, 6, 3, 'Danielle kioukiou', NULL),
(34, 6, 1, 'Bonjournossss', NULL),
(35, 1, 6, 'Bonsoirnossss', NULL),
(36, 6, 1, 'Oh bonsoirnosss', NULL),
(37, 1, 2, '', 'uploads/messages/1406f529518cb30cadae468f5be29a4c.jpg'),
(38, 1, 2, 'Aiza ee', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `friendships`
--

CREATE TABLE `friendships` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `friend_id` int(10) UNSIGNED NOT NULL,
  `status` enum('pending','accepted','removed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ;

--
-- Déchargement des données de la table `friendships`
--

INSERT INTO `friendships` (`id`, `user_id`, `friend_id`, `status`, `created_at`) VALUES
(1, 1, 3, 'pending', '2026-10-15 11:18:40'),
(2, 1, 2, 'accepted', '2026-10-15 12:00:32'),
(3, 1, 6, 'accepted', '2026-10-15 13:33:15'),
(4, 1, 7, 'accepted', '2026-10-15 13:58:48'),
(5, 7, 2, 'accepted', '2026-10-15 14:10:30'),
(6, 6, 3, 'pending', '2026-10-15 17:09:21');

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

INSERT INTO `posts` (`id`, `user_id`, `content`, `image_path`, `created_at`, `visibility`) VALUES
(1, 1, 'Hary et Prisca', 'uploads/posts/01cbe25110b9f74b5f63ada7a6bc36dd.jpg', '2026-10-15 07:57:20', 'private'),
(2, 3, 'Believe in yourself🥰', 'uploads/posts/96bc5003c819fd255f2cd5814991bf9d.jpg', '2026-10-15 08:00:34', 'private'),
(3, 3, 'Me and my bestie at church🥰👑', 'uploads/posts/381603b7453240b4c57848724f152eb3.jpg', '2026-10-15 08:05:04', 'private'),
(4, 1, 'Mon logo', 'uploads/posts/8b0b1bd2a5957f278711a5e28ca964fa.png', '2026-10-15 08:05:25', 'private'),
(6, 7, 'Souvenir 2023, Ranomafana Fianarantsoa,', 'uploads/posts/f8a37c5689be50266f30632996ea1c17.jpg', '2026-10-15 14:25:15', 'private'),
(7, 1, 'MARTIAL Lucio', 'uploads/posts/5f9d9159243941eaf518cd67a0935463.jpg', '2026-10-15 14:27:52', 'private'),
(8, 6, '', 'uploads/posts/aa28953aca333acd650fd0036bab8065.jpg', '2026-10-15 17:12:22', 'private');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `birthday` date NOT NULL,
  `sex` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_image` varchar(32) NOT NULL DEFAULT 'cat.png',
  `last_seen` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Structure de la table `post_likes`
-- --------------------------------------------------------

CREATE TABLE `post_likes` (
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`post_id`,`user_id`),
  KEY `idx_post_likes_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `birthday`, `sex`, `password`) VALUES
(1, 'Samson', 'TAHINIAVO ', '2003-03-05', 'M', '202cb962ac59075b964b07152d234b70'),
(2, 'Hary', 'RASOARINOMENJANAHARY ', '2000-09-18', 'F', '1b1464a2413c5dfbf6a472213ba535d6'),
(3, 'Danielle ', 'Tahiniavo ', '2010-08-20', 'Female', '47b02dbfb74662552299ddb5c4784715'),
(4, 'Hery', 'Norbert', '0000-00-00', 'Homme', '7cda3dd6e220577fceced99c15cac146'),
(5, 'Norbert', 'Hery', '0000-00-00', 'Homme', 'c92a10324374fac681719d63979d00fe'),
(6, 'Melinda Johannès ', 'TAHINIAVO ', '0000-00-00', 'Femme ', 'fcea920f7412b5da7be0cf42b8c93759'),
(7, 'Norbrt', 'Hery', '0000-00-00', 'Homme', '7cda3dd6e220577fceced99c15cac146');

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
-- Index pour la table `friendships`
--
ALTER TABLE `friendships`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_friendship_pair` (`user_id`,`friend_id`),
  ADD KEY `idx_friendship_friend_status` (`friend_id`,`status`);

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_users_firstname_lastname` (`firstname`,`lastname`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `chatbox`
--
ALTER TABLE `chatbox`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT pour la table `friendships`
--
ALTER TABLE `friendships`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
-- Contraintes pour la table `friendships`
--
ALTER TABLE `friendships`
  ADD CONSTRAINT `fk_friendships_friend` FOREIGN KEY (`friend_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_friendships_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_posts_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `post_likes`
--
ALTER TABLE `post_likes`
  ADD CONSTRAINT `fk_post_likes_post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_post_likes_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
