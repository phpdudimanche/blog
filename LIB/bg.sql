-- phpMyAdmin SQL Dump
-- version 4.5.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

--
-- Base de données :  `bg`
--

-- --------------------------------------------------------

--
-- Structure de la table `bg_billet`
--

CREATE TABLE IF NOT EXISTS `bg_billet` (
  `bg_bi_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `bg_bi_libelle` varchar(45) DEFAULT NULL,
  `bg_bi_titre` mediumtext NOT NULL,
  `bg_bi_stitre` varchar(255) DEFAULT NULL,
  `bg_bi_texte` longtext,
  `bg_bi_url` mediumtext,
  `bg_bi_date` date DEFAULT NULL,
  `bg_bi_statut` enum('attente','actif','retrait') DEFAULT NULL,
  PRIMARY KEY (`bg_bi_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `bg_billet_famille`
--

CREATE TABLE IF NOT EXISTS `bg_billet_famille` (
  `bg_bf_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `bg_bi_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `bg_fa_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`bg_bf_id`,`bg_bi_id`,`bg_fa_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `bg_famille`
--

CREATE TABLE IF NOT EXISTS `bg_famille` (
  `bg_fa_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `bg_fa_libelle` varchar(20) NOT NULL,
  `bg_fa_titre` varchar(255) NOT NULL,
  `bg_fa_texte` longtext NOT NULL,
  `bg_fa_url` mediumtext,
  `bg_fa_mere_id` int(10) UNSIGNED NOT NULL,
  `bg_fa_ordre` int(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`bg_fa_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
