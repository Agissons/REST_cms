-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           10.11.1-MariaDB - mariadb.org binary distribution
-- SE du serveur:                Win64
-- HeidiSQL Version:             11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour insecto
CREATE DATABASE IF NOT EXISTS `insecto` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `insecto`;

-- Listage de la structure de la table insecto. aliments
CREATE TABLE IF NOT EXISTS `aliments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `aliments_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table insecto.aliments : ~0 rows (environ)
/*!40000 ALTER TABLE `aliments` DISABLE KEYS */;
/*!40000 ALTER TABLE `aliments` ENABLE KEYS */;

-- Listage de la structure de la table insecto. boxes
CREATE TABLE IF NOT EXISTS `boxes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(10) NOT NULL,
  `weight` smallint(5) unsigned NOT NULL,
  `active` tinyint(1) NOT NULL,
  `sets_id` bigint(20) unsigned NOT NULL,
  `users_id` bigint(20) unsigned NOT NULL,
  `types_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sets_id` (`name`),
  KEY `boxes_sets_id_foreign` (`sets_id`),
  KEY `boxes_users_id_foreign` (`users_id`),
  KEY `boxes_types_id_foreign` (`types_id`),
  CONSTRAINT `boxes_sets_id_foreign` FOREIGN KEY (`sets_id`) REFERENCES `sets` (`id`),
  CONSTRAINT `boxes_types_id_foreign` FOREIGN KEY (`types_id`) REFERENCES `types` (`id`),
  CONSTRAINT `boxes_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table insecto.boxes : ~5 rows (environ)
/*!40000 ALTER TABLE `boxes` DISABLE KEYS */;
INSERT INTO `boxes` (`id`, `created_at`, `updated_at`, `name`, `weight`, `active`, `sets_id`, `users_id`, `types_id`) VALUES
	(1, '2023-11-06 01:46:56', '2023-11-06 01:47:05', 'adult1', 5000, 1, 1, 1, 1),
	(2, '2023-11-06 01:47:00', '2023-11-06 01:47:10', 'adult2', 4000, 1, 1, 1, 2),
	(3, '2023-11-06 01:47:01', '2023-11-06 01:47:19', 'Size2', 5000, 0, 2, 2, 6),
	(4, '2023-11-06 01:47:02', '2023-11-06 01:47:19', 'test', 3000, 1, 1, 1, 5),
	(5, '2023-11-06 01:47:03', '2023-11-06 01:47:24', 'adutw', 4000, 1, 2, 2, 5);
/*!40000 ALTER TABLE `boxes` ENABLE KEYS */;

-- Listage de la structure de la table insecto. failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table insecto.failed_jobs : ~0 rows (environ)
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;

-- Listage de la structure de la table insecto. guanos
CREATE TABLE IF NOT EXISTS `guanos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `weight` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `guanos_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table insecto.guanos : ~0 rows (environ)
/*!40000 ALTER TABLE `guanos` DISABLE KEYS */;
/*!40000 ALTER TABLE `guanos` ENABLE KEYS */;

-- Listage de la structure de la table insecto. handlings
CREATE TABLE IF NOT EXISTS `handlings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sets_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `handlings_sets_id_foreign` (`sets_id`),
  CONSTRAINT `handlings_sets_id_foreign` FOREIGN KEY (`sets_id`) REFERENCES `sets` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table insecto.handlings : ~0 rows (environ)
/*!40000 ALTER TABLE `handlings` DISABLE KEYS */;
/*!40000 ALTER TABLE `handlings` ENABLE KEYS */;

-- Listage de la structure de la table insecto. handlings_boxes
CREATE TABLE IF NOT EXISTS `handlings_boxes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `boxes_id` bigint(20) unsigned NOT NULL,
  `handlings_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `handlings_boxes_boxes_id_foreign` (`boxes_id`),
  KEY `handlings_boxes_handlings_id_foreign` (`handlings_id`),
  CONSTRAINT `handlings_boxes_boxes_id_foreign` FOREIGN KEY (`boxes_id`) REFERENCES `boxes` (`id`),
  CONSTRAINT `handlings_boxes_handlings_id_foreign` FOREIGN KEY (`handlings_id`) REFERENCES `handlings` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table insecto.handlings_boxes : ~0 rows (environ)
/*!40000 ALTER TABLE `handlings_boxes` DISABLE KEYS */;
/*!40000 ALTER TABLE `handlings_boxes` ENABLE KEYS */;

-- Listage de la structure de la table insecto. mealworms
CREATE TABLE IF NOT EXISTS `mealworms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `weight` smallint(5) unsigned NOT NULL,
  `code` varchar(10) NOT NULL,
  `sets_id` bigint(20) unsigned NOT NULL,
  `boxes_id` bigint(20) unsigned NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sets_id` (`code`),
  KEY `mealworms_sets_id_foreign` (`sets_id`),
  KEY `mealworms_boxes_id_foreign` (`boxes_id`),
  CONSTRAINT `mealworms_boxes_id_foreign` FOREIGN KEY (`boxes_id`) REFERENCES `boxes` (`id`),
  CONSTRAINT `mealworms_sets_id_foreign` FOREIGN KEY (`sets_id`) REFERENCES `sets` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table insecto.mealworms : ~4 rows (environ)
/*!40000 ALTER TABLE `mealworms` DISABLE KEYS */;
INSERT INTO `mealworms` (`id`, `created_at`, `updated_at`, `weight`, `code`, `sets_id`, `boxes_id`, `active`) VALUES
	(1, NULL, NULL, 800, 'Ab003', 1, 1, 1),
	(2, NULL, NULL, 500, 'Ab001', 1, 2, 0),
	(3, NULL, NULL, 300, 'Abee', 2, 2, 0),
	(4, NULL, NULL, 500, 'Ab002', 1, 1, 1);
/*!40000 ALTER TABLE `mealworms` ENABLE KEYS */;

-- Listage de la structure de la table insecto. migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table insecto.migrations : ~16 rows (environ)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2023_09_07_153921_create_mealworms_table', 1),
	(6, '2023_09_07_154140_create_guanos_table', 1),
	(7, '2023_09_07_154851_create_boxes_table', 1),
	(8, '2023_09_07_154913_create_aliments_table', 1),
	(9, '2023_09_07_200136_create_users_give_aliments_table', 1),
	(10, '2023_09_07_200519_create_sets_table', 1),
	(11, '2023_09_07_200713_create_users_work_sets_table', 1),
	(12, '2023_09_16_042849_create_handlings_table', 1),
	(13, '2023_09_16_042950_create_handlings_boxes_table', 1),
	(14, '2023_09_18_042402_create_users_does_handlings_table', 1),
	(15, '2023_09_18_042424_create_types_table', 1),
	(16, '2023_09_18_042428_alter_id', 1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Listage de la structure de la table insecto. password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table insecto.password_reset_tokens : ~0 rows (environ)
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;

-- Listage de la structure de la table insecto. personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table insecto.personal_access_tokens : ~0 rows (environ)
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;

-- Listage de la structure de la table insecto. sets
CREATE TABLE IF NOT EXISTS `sets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `weight` smallint(5) unsigned NOT NULL,
  `users_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sets_name_unique` (`name`),
  KEY `FK_sets_users` (`users_id`),
  CONSTRAINT `FK_sets_users` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table insecto.sets : ~3 rows (environ)
/*!40000 ALTER TABLE `sets` DISABLE KEYS */;
INSERT INTO `sets` (`id`, `name`, `created_at`, `updated_at`, `weight`, `users_id`) VALUES
	(1, 'Lulll', NULL, '2023-11-14 01:33:02', 1000, 1),
	(2, 'helo', NULL, '2023-11-14 01:29:41', 1100, 2),
	(3, 'test', '2023-11-14 00:58:58', '2023-11-14 03:23:47', 600, 1);
/*!40000 ALTER TABLE `sets` ENABLE KEYS */;

-- Listage de la structure de la vue insecto. setsview
-- Création d'une table temporaire pour palier aux erreurs de dépendances de VIEW
CREATE TABLE `setsview` (
	`id` BIGINT(20) UNSIGNED NOT NULL,
	`name` VARCHAR(20) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`weight` SMALLINT(5) UNSIGNED NOT NULL,
	`boxes` BIGINT(21) NOT NULL,
	`users` BIGINT(21) NOT NULL
) ENGINE=MyISAM;

-- Listage de la structure de la vue insecto. setsview2
-- Création d'une table temporaire pour palier aux erreurs de dépendances de VIEW
CREATE TABLE `setsview2` (
	`id` BIGINT(20) UNSIGNED NOT NULL,
	`production` DECIMAL(27,0) NOT NULL
) ENGINE=MyISAM;

-- Listage de la structure de la vue insecto. setsview3
-- Création d'une table temporaire pour palier aux erreurs de dépendances de VIEW
CREATE TABLE `setsview3` (
	`id` BIGINT(20) UNSIGNED NOT NULL,
	`name` VARCHAR(20) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`weight` SMALLINT(5) UNSIGNED NOT NULL,
	`boxes` BIGINT(21) NOT NULL,
	`users` BIGINT(21) NOT NULL,
	`production` DECIMAL(27,0) NULL
) ENGINE=MyISAM;

-- Listage de la structure de la table insecto. types
CREATE TABLE IF NOT EXISTS `types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table insecto.types : ~7 rows (environ)
/*!40000 ALTER TABLE `types` DISABLE KEYS */;
INSERT INTO `types` (`id`, `name`) VALUES
	(1, 'adult'),
	(2, 'puppa'),
	(3, 'size4'),
	(4, 'size3'),
	(5, 'size2'),
	(6, 'size1'),
	(7, 'newborn');
/*!40000 ALTER TABLE `types` ENABLE KEYS */;

-- Listage de la structure de la table insecto. users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(64) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table insecto.users : ~2 rows (environ)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `email`, `password`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Mabastiblo', 'zubietapablo9318@hotmail.com', '$2y$10$fe3Z40DrUmdXutmPy7rhR.poOERDuD0N2Z4N1YAsYzjgMNgWFbZFm', NULL, NULL, '2023-09-18 16:51:21', '2023-09-18 16:51:21'),
	(2, 'Bloo', 'Zub', '$10$fe3Z40DrUmdXutmPy7rhR.poOERDuD0N2Z4N1YAsYzjgMNgWFbZFm', NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Listage de la structure de la table insecto. users_does_handlings
CREATE TABLE IF NOT EXISTS `users_does_handlings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `users_id` bigint(20) unsigned NOT NULL,
  `handlings_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `users_does_handlings_users_id_foreign` (`users_id`),
  KEY `users_does_handlings_handlings_id_foreign` (`handlings_id`),
  CONSTRAINT `users_does_handlings_handlings_id_foreign` FOREIGN KEY (`handlings_id`) REFERENCES `handlings` (`id`),
  CONSTRAINT `users_does_handlings_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table insecto.users_does_handlings : ~0 rows (environ)
/*!40000 ALTER TABLE `users_does_handlings` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_does_handlings` ENABLE KEYS */;

-- Listage de la structure de la table insecto. users_give_aliments
CREATE TABLE IF NOT EXISTS `users_give_aliments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `weight` smallint(5) unsigned NOT NULL,
  `users_id` bigint(20) unsigned NOT NULL,
  `aliments_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `users_give_aliments_aliments_id_foreign` (`aliments_id`),
  KEY `users_id` (`users_id`),
  CONSTRAINT `users_give_aliments_aliments_id_foreign` FOREIGN KEY (`aliments_id`) REFERENCES `aliments` (`id`),
  CONSTRAINT `users_give_aliments_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table insecto.users_give_aliments : ~0 rows (environ)
/*!40000 ALTER TABLE `users_give_aliments` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_give_aliments` ENABLE KEYS */;

-- Listage de la structure de la table insecto. users_work_sets
CREATE TABLE IF NOT EXISTS `users_work_sets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sets_id` bigint(20) unsigned NOT NULL,
  `users_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sets_id_users_id` (`sets_id`,`users_id`),
  KEY `users_work_sets_users_id_foreign` (`users_id`),
  CONSTRAINT `users_work_sets_sets_id_foreign` FOREIGN KEY (`sets_id`) REFERENCES `sets` (`id`),
  CONSTRAINT `users_work_sets_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table insecto.users_work_sets : ~6 rows (environ)
/*!40000 ALTER TABLE `users_work_sets` DISABLE KEYS */;
INSERT INTO `users_work_sets` (`id`, `created_at`, `updated_at`, `sets_id`, `users_id`) VALUES
	(1, NULL, NULL, 1, 1),
	(2, NULL, NULL, 2, 2),
	(3, NULL, NULL, 2, 1),
	(4, '2023-11-14 00:58:58', '2023-11-14 00:58:58', 3, 1),
	(5, '2023-11-14 02:48:49', '2023-11-14 02:48:49', 1, 2),
	(6, '2023-11-14 02:49:12', '2023-11-14 02:49:12', 3, 2);
/*!40000 ALTER TABLE `users_work_sets` ENABLE KEYS */;

-- Listage de la structure de la vue insecto. setsview
-- Suppression de la table temporaire et création finale de la structure d'une vue
DROP TABLE IF EXISTS `setsview`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `setsview` AS select `sets`.`id` AS `id`,`sets`.`name` AS `name`,`sets`.`weight` AS `weight`,count(distinct `boxes`.`id`) AS `boxes`,count(distinct `users_work_sets`.`id`) AS `users` from ((`sets` left join `boxes` on(`boxes`.`sets_id` = `sets`.`id` and `boxes`.`active` = 1)) left join `users_work_sets` on(`users_work_sets`.`sets_id` = `sets`.`id`)) group by `sets`.`id`;

-- Listage de la structure de la vue insecto. setsview2
-- Suppression de la table temporaire et création finale de la structure d'une vue
DROP TABLE IF EXISTS `setsview2`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `setsview2` AS select `sets`.`id` AS `id`,ifnull(sum(`mealworms`.`weight`),0) AS `production` from (`sets` left join `mealworms` on(`mealworms`.`sets_id` = `sets`.`id` and `mealworms`.`active` = 1)) group by `sets`.`id`;

-- Listage de la structure de la vue insecto. setsview3
-- Suppression de la table temporaire et création finale de la structure d'une vue
DROP TABLE IF EXISTS `setsview3`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `setsview3` AS select `setsview`.`id` AS `id`,`setsview`.`name` AS `name`,`setsview`.`weight` AS `weight`,`setsview`.`boxes` AS `boxes`,`setsview`.`users` AS `users`,`setsview2`.`production` AS `production` from (`setsview` left join `setsview2` on(`setsview2`.`id` = `setsview`.`id`)) group by `setsview`.`id`;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
