-- Initialisation de la base de données
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Création des tables dans l'ordre des dépendances

-- Table `animal_breed`
CREATE TABLE IF NOT EXISTS `animal_breed` (
  `id` int NOT NULL AUTO_INCREMENT,
  `breed` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table `habitat`
CREATE TABLE IF NOT EXISTS `habitat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table `user`
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creation_date` datetime NOT NULL,
  `last_connexion` datetime DEFAULT NULL,
  `roles` json NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table `animal`
CREATE TABLE IF NOT EXISTS `animal` (
  `id` int NOT NULL AUTO_INCREMENT,
  `breed_id` int DEFAULT NULL,
  `habitat_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `IDX_6AAB231FA8B4A30F` (`breed_id`),
  KEY `IDX_6AAB231FAFFE2D26` (`habitat_id`),
  CONSTRAINT `FK_6AAB231FA8B4A30F` FOREIGN KEY (`breed_id`) REFERENCES `animal_breed` (`id`) ON DELETE SET NULL,
  CONSTRAINT `FK_6AAB231FAFFE2D26` FOREIGN KEY (`habitat_id`) REFERENCES `habitat` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table `image_animal`
CREATE TABLE IF NOT EXISTS `image_animal` (
  `id` int NOT NULL AUTO_INCREMENT,
  `animal_id` int NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C5B67DD78E962C16` (`animal_id`),
  CONSTRAINT `FK_C5B67DD78E962C16` FOREIGN KEY (`animal_id`) REFERENCES `animal` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table `image_habitat`
CREATE TABLE IF NOT EXISTS `image_habitat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `habitat_id` int NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_AE27E534AFFE2D26` (`habitat_id`),
  CONSTRAINT `FK_AE27E534AFFE2D26` FOREIGN KEY (`habitat_id`) REFERENCES `habitat` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table `info_animal`
CREATE TABLE IF NOT EXISTS `info_animal` (
  `id` int NOT NULL AUTO_INCREMENT,
  `veterinary_id` int NOT NULL,
  `animal_id` int NOT NULL,
  `status` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `food` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `weight` decimal(10,2) NOT NULL,
  `date_passage` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_A7767C498E962C16` (`animal_id`),
  KEY `IDX_A7767C49D954EB99` (`veterinary_id`),
  CONSTRAINT `FK_A7767C498E962C16` FOREIGN KEY (`animal_id`) REFERENCES `animal` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_A7767C49D954EB99` FOREIGN KEY (`veterinary_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertion des données initiales

-- Insertion dans animal_breed
INSERT INTO `animal_breed` (`id`, `breed`) VALUES
(1, 'Lion'),
(2, 'Éléphant'),
(3, 'Ours Polaire'),
(4, 'Guépard'),
(5, 'Crocodile'),
(6, 'Chèvre des montagnes'),
(7, 'Tortue géante');

-- Insertion dans habitat
INSERT INTO `habitat` (`id`, `name`, `description`, `creation_date`) VALUES
(1, 'Savane Africaine', 'Habitat pour les animaux d''Afrique', '2025-02-11 10:52:06'),
(2, 'Forêt Tropicale', 'Habitat humide pour les animaux exotiques', '2025-02-11 10:52:06'),
(3, 'Zone Arctique', 'Environnement froid pour les espèces polaires', '2025-02-11 10:52:06'),
(4, 'Désert', 'Habitat sec et aride pour les espèces désertiques', '2025-02-11 10:52:06'),
(5, 'Marais', 'Zone humide abritant diverses espèces aquatiques', '2025-02-11 10:52:06'),
(6, 'Montagnes Rocheuses', 'Environnement froid et escarpé pour les espèces alpines', '2025-02-11 10:52:06');

-- Insertion dans user (avec des mots de passe hashés)
INSERT INTO `user` (`id`, `email`, `password`, `firstname`, `lastname`, `creation_date`, `roles`) VALUES
(3, 'charlie.lemoine@exemple.com', '$2y$13$j.o7jIRPNIyo3.23WYbVGusEOPpId5/lCY8.7GLPqe06LYpkXqt3S', 'charlie', 'lemoine', '2025-02-13 08:34:01', '["ROLE_VETERINARY"]'),
(4, 'moha.bou@exemple.com', '$2y$13$XJdvQ9W.AIZMsbe8drpJFOXLE/Vs6q6nM5b.zb4VB7k2NDBx9o1gy', 'mohamed', 'bou', '2025-02-13 08:36:51', '["ROLE_VETERINARY"]'),
(5, 'sou.hola@exemple.com', '$2y$13$bRxl0dLgVlY9azhFKPvbG.q4akIGypFUkln7mWMP.J7kkVvo2hbM6', 'souhail', 'fr', '2025-02-13 10:10:30', '["ROLE_ADMIN"]');

-- Insertion dans animal
INSERT INTO `animal` (`id`, `breed_id`, `habitat_id`, `name`, `creation_date`) VALUES
(1, 1, 1, 'lion', '2025-02-13 09:32:00'),
(2, 2, 1, 'Éléphant', '2025-02-14 09:32:00'),
(3, 3, 3, 'ours', '2025-02-14 09:33:00'),
(4, 4, 1, 'Guépard', '2025-02-14 09:36:00'),
(5, 5, 5, 'Crocodile', '2025-02-14 09:36:00'),
(6, 6, 6, 'Chèvre des montagnes', '2025-02-14 09:38:00'),
(7, 7, 2, 'Tortue', '2025-02-14 09:39:00');

-- Insertion dans image_animal
INSERT INTO `image_animal` (`id`, `animal_id`, `label`, `url`) VALUES
(19, 1, 'lion', 'https://cdn.pixabay.com/photo/2019/10/27/13/49/lion-4581841_1280.jpg'),
(21, 2, 'Éléphant', 'https://cdn.pixabay.com/photo/2015/12/14/12/36/elephant-1092508_1280.jpg'),
(22, 3, 'Ours Polaire', 'https://cdn.pixabay.com/photo/2020/05/09/02/43/polar-bear-5147947_1280.jpg'),
(23, 4, 'Guépard', 'https://cdn.pixabay.com/photo/2020/09/02/06/08/cheetah-5537416_1280.jpg'),
(24, 5, 'Crocodile', 'https://cdn.pixabay.com/photo/2015/09/18/09/55/nile-crocodile-945304_1280.jpg'),
(25, 6, 'Chévre de Montagne', 'https://cdn.pixabay.com/photo/2024/08/22/18/08/mountain-goats-8989911_1280.jpg'),
(26, 7, 'Tortue géante', 'https://cdn.pixabay.com/photo/2018/07/22/19/39/turtle-3555358_1280.jpg');

-- Insertion dans image_habitat
INSERT INTO `image_habitat` (`id`, `habitat_id`, `label`, `url`) VALUES
(1, 1, 'Savane Africaine', 'https://cdn.pixabay.com/photo/2014/08/25/14/08/elephant-427138_1280.jpg'),
(2, 2, 'Forêt Tropicale', 'https://cdn.pixabay.com/photo/2022/09/16/23/09/mountains-7459822_1280.jpg'),
(3, 3, 'Zone Arctique', 'https://cdn.pixabay.com/photo/2020/09/10/04/43/expedition-5559244_1280.jpg'),
(4, 4, 'Désert', 'https://cdn.pixabay.com/photo/2020/01/19/21/51/mesquite-flats-4779079_1280.jpg'),
(5, 5, 'Marais', 'https://cdn.pixabay.com/photo/2021/10/07/10/08/swamp-6688060_1280.jpg'),
(6, 6, 'Montagnes Rocheuses', 'https://cdn.pixabay.com/photo/2019/04/22/01/51/nature-4145438_960_720.jpg');

-- Insertion dans info_animal
INSERT INTO `info_animal` (`id`, `veterinary_id`, `animal_id`, `status`, `food`, `weight`, `date_passage`) VALUES
(1, 3, 1, 'Bonne santé', 'Viande', 190.50, '2025-02-13'); 