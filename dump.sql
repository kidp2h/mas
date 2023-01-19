-- Adminer 4.8.1 MySQL 8.0.32 dump
SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';
SET NAMES utf8mb4;
DROP DATABASE IF EXISTS `mas`;
CREATE DATABASE `mas`
/*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */
/*!80016 DEFAULT ENCRYPTION='N' */
;
USE `mas`;
DELIMITER;
;
CREATE EVENT `clean_events` ON SCHEDULE EVERY 3 MINUTE STARTS '2023-01-06 15:47:41' ON COMPLETION PRESERVE ENABLE DO
DELETE FROM events
WHERE created_at + INTERVAL 30 SECOND < NOW()
  and name != "use-remote";
;
CREATE EVENT `clear_remote` ON SCHEDULE EVERY 5 SECOND STARTS '2023-01-17 14:33:41' ON COMPLETION NOT PRESERVE ENABLE COMMENT 'clear_remote' DO
DELETE FROM events
WHERE updated_at + INTERVAL 30 SECOND < NOW()
  and name = "use-remote"
  and name = "use-remote";
;
DELIMITER;
DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `room` bigint NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `room` (`room`),
  CONSTRAINT `events_ibfk_1` FOREIGN KEY (`room`) REFERENCES `users` (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 355 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
DROP TABLE IF EXISTS `photos`;
CREATE TABLE `photos` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `organizerId` bigint NOT NULL,
  `userId` bigint NOT NULL,
  `attendeeFileName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_ja_0900_as_cs_ks NOT NULL,
  `attendeeName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_ja_0900_as_cs_ks DEFAULT NULL,
  `attendeeComment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_ja_0900_as_cs_ks DEFAULT NULL,
  `likeCount` bigint DEFAULT '0',
  `useFlag` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  KEY `organizerId` (`organizerId`),
  CONSTRAINT `photos_ibfk_2` FOREIGN KEY (`organizerId`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 75 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_ja_0900_as_cs_ks;
DROP TABLE IF EXISTS `reset`;
CREATE TABLE `reset` (
  `id` bigint NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_ja_0900_as_cs NOT NULL,
  `expire` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`),
  CONSTRAINT `reset_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_ja_0900_as_cs;
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_ja_0900_as_cs_ks NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_ja_0900_as_cs_ks NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_ja_0900_as_cs_ks NOT NULL,
  `eventTitle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_ja_0900_as_cs_ks DEFAULT '思い出アルバム',
  `welcomeMessage` text CHARACTER SET utf8mb4 COLLATE utf8mb4_ja_0900_as_cs_ks,
  `welcomeImageFilename` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_ja_0900_as_cs_ks DEFAULT NULL,
  `actionFlag` tinyint NOT NULL DEFAULT '1',
  `QRCodeFlag` tinyint NOT NULL DEFAULT '1',
  `memo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_ja_0900_as_cs_ks,
  `useFlag` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE = InnoDB AUTO_INCREMENT = 11 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_ja_0900_as_cs_ks;
-- 2023-01-19 03:41:14