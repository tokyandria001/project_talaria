-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 15 jan. 2026 à 14:33
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `symfony_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `inscription`
--

CREATE TABLE `inscription` (
  `id` int(11) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `budget` longtext NOT NULL,
  `activity` longtext NOT NULL,
  `food` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `inscription`
--

INSERT INTO `inscription` (`id`, `lastname`, `firstname`, `mail`, `password`, `phone`, `budget`, `activity`, `food`) VALUES
(1, 'Doe', 'Alex', 'alex@test.com', '$2y$10$8y5LFCXPWrcr6l.1B5W8Qef84eRU1wM4TZ7zRv7Ug7TtRulg9SBWS', '0600000000', 'low', 'sport', 'vegan'),
(2, 'Doe', 'Alex', 'antoine@test.com', '$2y$10$Eupl1EisM86dp8qL6p1r/ORub9RIScykbx130r916XLqCy9cRjURW', '0600000000', 'low', 'sport', 'vegan'),
(3, 'Jackson', 'Michael', 'Mjackson@test.com', '$2y$10$wVTikxXgfnVbb1ddgFlzq.aCZ2JGyYrW5rpJZgE6Dfo1XUY/v0cta', '0500000000', 'low', 'sport', 'vegan'),
(4, 'lala', 'toto', 'toto@yolo.fr', '$2y$10$VqHGgpZuioJifOIxULQRoe/ridqtjC4gNQha6ei.f8cC/OoyzO6GK', '0253417895', '1000', 'foot', 'vegan'),
(5, 'lala', 'toto', 'toto@yala.fr', '$2y$10$1KubnBAVV.ZEGhNaXonoReLJmy9Qg4gxnsFeXu0Lx3i9Q3yDjAMBm', '0214587963', '1000', 'rando', 'vegan');

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `place`
--

CREATE TABLE `place` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `tags` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `place`
--

INSERT INTO `place` (`id`, `name`, `description`, `price`, `latitude`, `longitude`, `tags`) VALUES
(1, 'Place 1', 'Description du lieu 1', 24, 48.804, 2.344, 'bar,restaurant'),
(2, 'Place 2', 'Description du lieu 2', 17, 48.817, 2.277, 'bar,restaurant'),
(3, 'Place 3', 'Description du lieu 3', 80, 48.77, 2.21, 'bar,restaurant'),
(4, 'Place 4', 'Description du lieu 4', 97, 48.775, 2.23, 'bar,restaurant'),
(5, 'Place 5', 'Description du lieu 5', 61, 48.882, 2.382, 'bar,restaurant');

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `trip`
--

CREATE TABLE `trip` (
  `id` int(11) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `budget_total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `trip`
--

INSERT INTO `trip` (`id`, `destination`, `date_start`, `date_end`, `budget_total`) VALUES
(1, 'Destination 1', '2025-12-12', '2025-12-14', 1205),
(2, 'Destination 2', '2025-12-13', '2025-12-15', 1766),
(3, 'Destination 3', '2025-12-14', '2025-12-16', 1264);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `inscription`
--
ALTER TABLE `inscription`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Index pour la table `place`
--
ALTER TABLE `place`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `trip`
--
ALTER TABLE `trip`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `inscription`
--
ALTER TABLE `inscription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `place`
--
ALTER TABLE `place`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `trip`
--
ALTER TABLE `trip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
