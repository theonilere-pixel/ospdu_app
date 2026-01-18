-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : sam. 17 jan. 2026 à 21:28
-- Version du serveur : 10.11.15-MariaDB-cll-lve
-- Version de PHP : 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ospduorg_ospd11`
--

-- --------------------------------------------------------

--
-- Structure de la table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `status` enum('new','read','replied') DEFAULT 'new',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title_fr` varchar(255) NOT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `title_sw` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `description_fr` text DEFAULT NULL,
  `description_en` text DEFAULT NULL,
  `description_sw` text DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `event_time` time DEFAULT NULL,
  `location_fr` varchar(255) DEFAULT NULL,
  `location_en` varchar(255) DEFAULT NULL,
  `location_sw` varchar(255) DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `status` enum('upcoming','ongoing','completed') DEFAULT 'upcoming',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `title_fr` varchar(255) NOT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `title_sw` varchar(255) DEFAULT NULL,
  `description_fr` text DEFAULT NULL,
  `description_en` text DEFAULT NULL,
  `description_sw` text DEFAULT NULL,
  `image_path` varchar(255) NOT NULL,
  `category` enum('photos','videos','documents') DEFAULT 'photos',
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `intervention_domains`
--

CREATE TABLE `intervention_domains` (
  `id` int(11) NOT NULL,
  `name_fr` varchar(255) NOT NULL,
  `name_en` varchar(255) DEFAULT NULL,
  `name_sw` varchar(255) DEFAULT NULL,
  `description_fr` text DEFAULT NULL,
  `description_en` text DEFAULT NULL,
  `description_sw` text DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `intervention_domains`
--

INSERT INTO `intervention_domains` (`id`, `name_fr`, `name_en`, `name_sw`, `description_fr`, `description_en`, `description_sw`, `icon`, `featured_image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Éducation & Formation', 'Education & Training', 'Elimu na Mafunzo', 'Promotion de l\'éducation pour tous, particulièrement les filles', 'Promoting education for all, especially girls', 'Kukuza elimu kwa wote, hasa wasichana', 'academic-cap', NULL, 'active', '2026-01-07 02:38:38', '2026-01-07 02:38:38'),
(2, 'Santé', 'Health', 'Afya', 'Amélioration de l\'accès aux soins de santé de qualité', 'Improving access to quality healthcare', 'Kuboresha upatikanaji wa huduma za afya za ubora', 'heart', NULL, 'active', '2026-01-07 02:38:38', '2026-01-07 02:38:38'),
(3, 'Sécurité Alimentaire & Nutrition', 'Food Security & Nutrition', 'Usalama wa Chakula na Lishe', 'Lutte contre la malnutrition et promotion de la sécurité alimentaire', 'Fighting malnutrition and promoting food security', 'Kupambana na utapiamlo na kukuza usalama wa chakula', 'cake', NULL, 'active', '2026-01-07 02:38:38', '2026-01-07 02:38:38'),
(4, 'Violence Basée sur le Genre', 'Gender-Based Violence', 'Unyanyasaji wa Kijinsia', 'Prévention et prise en charge des violences faites aux femmes et filles', 'Prevention and care for violence against women and girls', 'Kuzuia na kushughulikia unyanyasaji dhidi ya wanawake na wasichana', 'shield-check', NULL, 'active', '2026-01-07 02:38:38', '2026-01-07 02:38:38'),
(5, 'Protection de l\'Enfant', 'Child Protection', 'Ulinzi wa Watoto', 'Protection des droits et du bien-être des enfants', 'Protecting children\'s rights and welfare', 'Kulinda haki na ustawi wa watoto', 'user-group', NULL, 'active', '2026-01-07 02:38:38', '2026-01-07 02:38:38'),
(6, 'Environnement et Climat', 'Environment & Climate', 'Mazingira na Tabianchi', 'Protection de l\'environnement et adaptation au changement climatique', 'Environmental protection and climate change adaptation', 'Ulinzi wa mazingira na kukabiliana na mabadiliko ya tabianchi', 'globe-alt', NULL, 'active', '2026-01-07 02:38:38', '2026-01-07 02:38:38'),
(7, 'Eau, Hygiène et Assainissement', 'Water, Hygiene & Sanitation', 'Maji, Usafi na Mazingira', 'Amélioration de l\'accès à l\'eau potable et à l\'assainissement', 'Improving access to clean water and sanitation', 'Kuboresha upatikanaji wa maji safi na mazingira safi', 'beaker', NULL, 'active', '2026-01-07 02:38:38', '2026-01-07 02:38:38'),
(8, 'Gestion des Crises', 'Crisis Management', 'Usimamizi wa Migogoro', 'Réponse aux urgences et gestion des crises humanitaires', 'Emergency response and humanitarian crisis management', 'Majibu ya dharura na usimamizi wa migogoro ya kibinadamu', 'exclamation-triangle', NULL, 'active', '2026-01-07 02:38:38', '2026-01-07 02:38:38');

-- --------------------------------------------------------

--
-- Structure de la table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title_fr` varchar(255) NOT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `title_sw` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `excerpt_fr` text DEFAULT NULL,
  `excerpt_en` text DEFAULT NULL,
  `excerpt_sw` text DEFAULT NULL,
  `content_fr` text DEFAULT NULL,
  `content_en` text DEFAULT NULL,
  `content_sw` text DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `status` enum('published','draft') DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `title_fr` varchar(255) NOT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `title_sw` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `content_fr` text DEFAULT NULL,
  `content_en` text DEFAULT NULL,
  `content_sw` text DEFAULT NULL,
  `meta_description_fr` text DEFAULT NULL,
  `meta_description_en` text DEFAULT NULL,
  `meta_description_sw` text DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `title_fr` varchar(255) NOT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `title_sw` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `description_fr` text DEFAULT NULL,
  `description_en` text DEFAULT NULL,
  `description_sw` text DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `status` enum('active','completed','planned') DEFAULT 'active',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `setting_type` enum('text','textarea','image','boolean') DEFAULT 'text',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `site_settings`
--

INSERT INTO `site_settings` (`id`, `setting_key`, `setting_value`, `setting_type`, `created_at`, `updated_at`) VALUES
(1, 'site_title', 'OSPDU - Organe Solidaire pour la Protection Sociale et le Développement Durable', 'text', '2026-01-07 02:38:38', '2026-01-07 02:38:38'),
(2, 'site_slogan', 'Engagé pour un monde équitable', 'text', '2026-01-07 02:38:38', '2026-01-07 02:38:38'),
(3, 'site_description', 'Organisation humanitaire dédiée à la protection sociale et au développement durable', 'textarea', '2026-01-07 02:38:38', '2026-01-07 02:38:38'),
(4, 'contact_email', 'contact@ospdu.org', 'text', '2026-01-07 02:38:38', '2026-01-07 02:38:38'),
(5, 'contact_phone', '+243 XXX XXX XXX', 'text', '2026-01-07 02:38:38', '2026-01-07 02:38:38'),
(6, 'contact_address', 'Kiwanja, Territoire de Rutshuru, Nord-Kivu, RDC', 'text', '2026-01-07 02:38:38', '2026-01-07 02:38:38'),
(7, 'dark_mode', '0', 'boolean', '2026-01-07 02:38:38', '2026-01-07 02:38:38'),
(8, 'site_logo', 'uploads/logo.png', 'image', '2026-01-07 02:38:38', '2026-01-07 02:38:38'),
(9, 'site_favicon', 'uploads/favicon.ico', 'image', '2026-01-07 02:38:38', '2026-01-07 02:38:38');

-- --------------------------------------------------------

--
-- Structure de la table `sliders`
--

CREATE TABLE `sliders` (
  `id` int(11) NOT NULL,
  `title_fr` varchar(255) DEFAULT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `title_sw` varchar(255) DEFAULT NULL,
  `subtitle_fr` text DEFAULT NULL,
  `subtitle_en` text DEFAULT NULL,
  `subtitle_sw` text DEFAULT NULL,
  `image_path` varchar(255) NOT NULL,
  `link_url` varchar(255) DEFAULT NULL,
  `button_text_fr` varchar(100) DEFAULT NULL,
  `button_text_en` varchar(100) DEFAULT NULL,
  `button_text_sw` varchar(100) DEFAULT NULL,
  `order_position` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','editor') DEFAULT 'editor',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@ospdu.org', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', '2026-01-07 02:38:38', '2026-01-07 02:38:38');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Index pour la table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `intervention_domains`
--
ALTER TABLE `intervention_domains`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Index pour la table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Index pour la table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Index pour la table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Index pour la table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `intervention_domains`
--
ALTER TABLE `intervention_domains`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;