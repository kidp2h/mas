-- Adminer 4.8.1 MySQL 8.0.31 dump

SET NAMES utf8;
SET time_zone = '+07:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `photos`;
CREATE TABLE `photos` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `organizerId` bigint NOT NULL,
  `userId` bigint NOT NULL,
  `attendeeFileName` varchar(255) COLLATE utf8mb4_ja_0900_as_cs_ks NOT NULL,
  `attendeeName` varchar(255) COLLATE utf8mb4_ja_0900_as_cs_ks DEFAULT NULL,
  `attendeeComment` varchar(255) COLLATE utf8mb4_ja_0900_as_cs_ks DEFAULT NULL,
  `useFlag` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  KEY `organizerId` (`organizerId`),
  CONSTRAINT `photos_ibfk_2` FOREIGN KEY (`organizerId`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_ja_0900_as_cs_ks;


DROP TABLE IF EXISTS `reset`;
CREATE TABLE `reset` (
  `id` bigint NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_ja_0900_as_cs NOT NULL,
  `expire` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`),
  CONSTRAINT `reset_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_ja_0900_as_cs;


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_ja_0900_as_cs_ks;

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
) ENGINE=InnoDB AUTO_INCREMENT=352 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

