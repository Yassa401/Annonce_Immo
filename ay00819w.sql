-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 05 mai 2023 à 23:40
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ay00819w`
--

-- --------------------------------------------------------

--
-- Structure de la table `biens_achat`
--

CREATE TABLE `biens_achat` (
  `id_bien` bigint(20) UNSIGNED NOT NULL COMMENT 'clé primaire et étrangère de la table biens_immbiliers(id)',
  `prix` mediumint(8) UNSIGNED NOT NULL COMMENT 'prix d''achat du bien'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `biens_achat`
--

INSERT INTO `biens_achat` (`id_bien`, `prix`) VALUES
(2, 52000),
(191, 150000),
(192, 90000);

-- --------------------------------------------------------

--
-- Structure de la table `biens_immobiliers`
--

CREATE TABLE `biens_immobiliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Clé étrangère, clé primaire de la table users',
  `id_ville` int(10) UNSIGNED DEFAULT NULL COMMENT 'Clé étrangère, clé primaire de la table ville',
  `surface` smallint(5) UNSIGNED DEFAULT NULL COMMENT 'La surface du bien immobilier',
  `type` enum('appartement','maison','terrain','parking','autre') DEFAULT NULL,
  `description` text DEFAULT NULL COMMENT 'description du bien'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `biens_immobiliers`
--

INSERT INTO `biens_immobiliers` (`id`, `id_user`, `id_ville`, `surface`, `type`, `description`) VALUES
(1, 8, 1, 43, 'appartement', 'appartement situé à l\'hotel de ville avec vue magnifique'),
(2, 8, 1, 52, 'appartement', 'appartement situé à la métare'),
(4, 8, 1, 104, 'appartement', 'Situé à Hôpital Nord'),
(6, 8, 2, 101, 'maison', 'A 5 minutes de l&#39;axe autoroutier St Etienne Lyon, des écoles et des commerces, cette maison de 1998 en plain-pied, est composée d&#39;une cuisine indépendante aménagée et équipée, d&#39;un salon / salle à manger  de 43 m², avec accès terrasse, de 3 chambres (possibilité 4), d&#39;une salle d&#39;eau avec double vasque, d&#39;une buanderie et de nombreux rangements. Chauffage au gaz, poêle à bois, double vitrage, volets roulants électriques. Garage et jardin clos (piscinable). Travaux récents : Chaudière, salle d&#39;eau, cuisine, habillage de toit'),
(190, 9, 1, 50, 'appartement', 'Appartement T3 situé à Bellevue'),
(191, 8, 1, 101, 'maison', 'Maison situé sur hôtel de ville avec vue sur le centre ville'),
(192, 10, 5, 101, 'maison', 'Maison magnifique à Lyon '),
(193, 10, 5, 70, 'appartement', 'Appart T3 magnifique à Lyon '),
(195, 10, 5, 54, 'appartement', 'Appartement T2 à cours Fauriel à côté du lycée Fauriel');

-- --------------------------------------------------------

--
-- Structure de la table `biens_location`
--

CREATE TABLE `biens_location` (
  `id_bien` bigint(20) UNSIGNED NOT NULL COMMENT 'id_bien est une clé primaire et étrangère de biens_immobiliers(id)',
  `prix` smallint(6) DEFAULT NULL COMMENT 'correspond au prix de location du bien',
  `depot_garantie` int(11) DEFAULT NULL COMMENT 'depot de garantie du bien en location'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `biens_location`
--

INSERT INTO `biens_location` (`id_bien`, `prix`, `depot_garantie`) VALUES
(1, 430, 500),
(190, 650, 500),
(193, 670, 500),
(195, 540, 343);

-- --------------------------------------------------------

--
-- Structure de la table `images_biens_immobiliers`
--

CREATE TABLE `images_biens_immobiliers` (
  `id_bien` bigint(20) UNSIGNED NOT NULL COMMENT 'identifiant du bien correspondant à l''image',
  `nom_image` varchar(255) NOT NULL COMMENT 'nom de l''image dans la base d''images (dossier)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `images_biens_immobiliers`
--

INSERT INTO `images_biens_immobiliers` (`id_bien`, `nom_image`) VALUES
(1, 'img3.jpg'),
(2, 'img2.jpg'),
(190, 'appart_T3.jpg'),
(191, '22635-2.jpg'),
(192, '3bd52a73f57c91e7371659d39da075c5-p_h.jpg'),
(193, 'facb3a952ff62b34af11e6d5f6198d9b.jpeg'),
(195, 'image_T2.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `number` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `user_name`, `password`, `date`, `nom`, `prenom`, `number`) VALUES
(7, 'yassa123', '$2y$10$8YSjdRumEDFJVg8P7/J6DumTO/BCFqrhk5BJFeY06sdr42sS8Bk9G', '2023-04-16 00:16:34', NULL, NULL, NULL),
(8, 'yassu', '$2y$10$SHK/jTllh27wCeGz7Kya4uAF6Lpa.7xG1F9qrXRnji2mi1PfVrJqy', '2023-04-20 12:46:18', NULL, NULL, NULL),
(9, 'Inis', '$2y$10$.uzr606oznWX/Ibtcz.GP.vZ/5B43iDZ4fgP8JX8/OENFCWwGXxai', '2023-04-28 10:02:43', NULL, NULL, NULL),
(10, 'yassa', '$2y$10$fmPfPtCnlcgo7eha2U0k3OONrOhQHNUmGRRxQBaL3TbYXj3FyqLVy', '2023-05-05 11:44:14', 'assal', 'yasser', '0612345678');

-- --------------------------------------------------------

--
-- Structure de la table `ville`
--

CREATE TABLE `ville` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `nom_ville` varchar(255) NOT NULL,
  `code_postal` mediumint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ville`
--

INSERT INTO `ville` (`id`, `nom_ville`, `code_postal`) VALUES
(5, 'Lyon', 69000),
(2, 'Saint-étienne', 42000),
(1, 'Saint-étienne', 42100);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `biens_achat`
--
ALTER TABLE `biens_achat`
  ADD PRIMARY KEY (`id_bien`);

--
-- Index pour la table `biens_immobiliers`
--
ALTER TABLE `biens_immobiliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bien_immo_id_user_user_id` (`id_user`);

--
-- Index pour la table `biens_location`
--
ALTER TABLE `biens_location`
  ADD PRIMARY KEY (`id_bien`);

--
-- Index pour la table `images_biens_immobiliers`
--
ALTER TABLE `images_biens_immobiliers`
  ADD PRIMARY KEY (`id_bien`,`nom_image`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date` (`date`),
  ADD KEY `user_name` (`user_name`);

--
-- Index pour la table `ville`
--
ALTER TABLE `ville`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unq_ville_nom_ville_code_postal` (`nom_ville`,`code_postal`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `biens_immobiliers`
--
ALTER TABLE `biens_immobiliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=196;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `ville`
--
ALTER TABLE `ville`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `biens_achat`
--
ALTER TABLE `biens_achat`
  ADD CONSTRAINT `fk_biens_achat_biens_immobiliers_id` FOREIGN KEY (`id_bien`) REFERENCES `biens_immobiliers` (`id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `biens_immobiliers`
--
ALTER TABLE `biens_immobiliers`
  ADD CONSTRAINT `fk_bien_immo_id_user_user_id` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `biens_location`
--
ALTER TABLE `biens_location`
  ADD CONSTRAINT `fk_biens_location_biens_immobiliers_id` FOREIGN KEY (`id_bien`) REFERENCES `biens_immobiliers` (`id`);

--
-- Contraintes pour la table `images_biens_immobiliers`
--
ALTER TABLE `images_biens_immobiliers`
  ADD CONSTRAINT `fk_images_bien_immo_id_bien_immo` FOREIGN KEY (`id_bien`) REFERENCES `biens_immobiliers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
