-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 16 déc. 2024 à 11:06
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `service_etudiant`
--

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `category` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `title`, `description`, `created_at`, `category`) VALUES
(20, 17, 'Orthographe', 'Quand utiliser On / Ont', '2024-12-16 10:10:55', 'Langues'),
(19, 8, 'Auteur Français', 'Qui a écrit les misérable ?', '2024-12-16 10:08:48', 'Littérature'),
(18, 8, 'Lois de newton en aviation', 'Quelqu\'un peut m\'expliquer comment fonctionne le bras de levier en aviation ', '2024-12-16 10:07:41', 'Physique'),
(17, 8, 'linux', 'Quelle est la commande pour accéder au droit admin sous unix ?', '2024-12-16 10:05:57', 'Informatique'),
(16, 8, 'DM Maths dérivation', 'J\'ai besoin d\'aide pour mon dm de maths pour la dérivé suivante : f(x)=3x²+5x+2', '2024-12-16 10:04:51', 'Mathématiques'),
(23, 19, 'test demo', 'présentation', '2024-12-16 10:39:06', 'Informatique');

-- --------------------------------------------------------

--
-- Structure de la table `responses`
--

DROP TABLE IF EXISTS `responses`;
CREATE TABLE IF NOT EXISTS `responses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `post_id` int NOT NULL,
  `user_id` int NOT NULL,
  `response_text` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `responses`
--

INSERT INTO `responses` (`id`, `post_id`, `user_id`, `response_text`, `created_at`) VALUES
(30, 18, 18, 'Le bras de levier est la distance perpendiculaire entre le point d\'application d\'une force et un point de référence : Moment=Force×Bras de levier', '2024-12-16 10:27:42'),
(29, 16, 18, 'Le bras de levier est la distance perpendiculaire entre le point d\'application d\'une force et un point de référence  : Moment=Force×Bras de levier', '2024-12-16 10:24:21'),
(28, 17, 18, '*Et mettre le mot de passe admin (root)', '2024-12-16 10:21:40'),
(27, 17, 18, 'Il faut utiliser sudo avant ta commande', '2024-12-16 10:20:24'),
(26, 20, 18, 'test3', '2024-12-16 10:19:12'),
(25, 20, 17, 'test 2', '2024-12-16 10:18:23'),
(24, 20, 8, 'test', '2024-12-16 10:12:16'),
(23, 19, 8, 'C\'est Molière !!', '2024-12-16 10:09:44'),
(31, 16, 16, 'f ′(x)=6x+5', '2024-12-16 10:28:36'),
(37, 23, 19, 'test de réponse', '2024-12-16 10:39:26'),
(38, 17, 19, 'test 2', '2024-12-16 10:39:36');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `points` int NOT NULL DEFAULT '5',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `created_at`, `points`) VALUES
(8, 'test', 'test@gmail.com', '$2y$10$97qArkqsb1zkkY971WF2i.LIBpYSGufOrc1zddw2mhcGEskKsU0Oa', '2024-12-11 22:21:20', 13),
(18, 'gregoin', 'gregoin@gmail.com', '$2y$10$jyemTr1h85X4qP6DaakyGOKJ3pPAjMGVkjsHQkTqrIwk1JivpYPri', '2024-12-16 10:03:03', 5),
(19, 'demo', 'demo@gmail.com', '$2y$10$XZdULoO/GCYOYHqv3PzufeYjNLdMxTwtwsMGCXvm9HrEwez7V1vlK', '2024-12-16 10:38:00', 6),
(12, 'rayan', 'rayan@gmail.com', '$2y$10$O.eyjdXyWnmeGxFLRjK9R.QHFcTpm35y.p3clYUJbcMvMwoVF8x1q', '2024-12-13 21:12:01', 5),
(16, 'jean Eud', 'jean@gmail.com', '$2y$10$r46ojLlWZrhxs93KNroxXeDDld31GV3wXxbaQJWPK.1TAbXqZ0NEe', '2024-12-16 10:02:06', 4),
(14, 'rayou', 'rayou@gmail.com', '$2y$10$yBk/rn0dk2C67PwvFFvV3.9ozvgrW7pHxMaglQvolCLUWPDyGOWma', '2024-12-15 20:30:06', 4),
(17, 'Harry stop', 'harrystop@gmail.com', '$2y$10$ktTJOvGY/JruDKDq622x..vCImGhFbWrwgTFl9aD7S2KNkDCvZj2u', '2024-12-16 10:02:41', 4);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
