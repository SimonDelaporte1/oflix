-- Adminer 4.7.6 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `casting`;
CREATE TABLE `casting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `credit_order` int(11) DEFAULT NULL,
  `person_id` int(11) DEFAULT NULL,
  `movie_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D11BBA50217BBB47` (`person_id`),
  KEY `IDX_D11BBA508F93B6FC` (`movie_id`),
  CONSTRAINT `FK_D11BBA50217BBB47` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`),
  CONSTRAINT `FK_D11BBA508F93B6FC` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20211209132619',	'2021-12-09 14:29:22',	62),
('DoctrineMigrations\\Version20211210130836',	'2021-12-10 14:10:16',	70),
('DoctrineMigrations\\Version20211214103213',	'2021-12-14 11:32:41',	102),
('DoctrineMigrations\\Version20211214104123',	'2021-12-14 11:41:46',	193);

DROP TABLE IF EXISTS `genre`;
CREATE TABLE `genre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `movie`;
CREATE TABLE `movie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `release_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `movie` (`id`, `title`, `type`, `release_date`) VALUES
(1,	'Avatar',	'Film',	'2009-12-24'),
(3,	'Avatar',	'Film',	'2012-12-24');

DROP TABLE IF EXISTS `movie_genre`;
CREATE TABLE `movie_genre` (
  `movie_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL,
  PRIMARY KEY (`movie_id`,`genre_id`),
  KEY `IDX_FD1229648F93B6FC` (`movie_id`),
  KEY `IDX_FD1229644296D31F` (`genre_id`),
  CONSTRAINT `FK_FD1229644296D31F` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_FD1229648F93B6FC` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `person`;
CREATE TABLE `person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `season`;
CREATE TABLE `season` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `movie_id` int(11) NOT NULL,
  `number` smallint(6) NOT NULL,
  `episodes_number` smallint(6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F0E45BA98F93B6FC` (`movie_id`),
  CONSTRAINT `FK_F0E45BA98F93B6FC` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `season` (`id`, `movie_id`, `number`, `episodes_number`) VALUES
(1,	1,	1,	24),
(2,	1,	2,	22),
(3,	1,	3,	15);

-- 2021-12-14 10:47:51
