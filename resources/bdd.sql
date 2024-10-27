
DROP DATABASE IF EXISTS `laura_naturelle`;

CREATE DATABASE IF NOT EXISTS `laura_naturelle` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `laura_naturelle`;


CREATE TABLE `schedules` (
    `id_schedules` INT AUTO_INCREMENT,
    `week_day` VARCHAR(10)  NOT NULL,
    `open_day` TINYINT NOT NULL DEFAULT 0,
    `open_hour` TIME NOT NULL DEFAULT '00:00:00',
    `close_mid_hour` TIME NOT NULL DEFAULT '00:00:00',
    `open_mid_hour` TIME NOT NULL DEFAULT '00:00:00',
    `close_hour` TIME NOT NULL DEFAULT '00:00:00',
    `updated_at` DATETIME,
    PRIMARY KEY(`id_schedules`),
    UNIQUE(`week_day`)
) ENGINE=InnoDB;


INSERT INTO `schedules` (`week_day`) VALUES ('Lundi');
INSERT INTO `schedules` (`week_day`, `open_day`, `open_hour`, `close_hour`) VALUES ('Mardi', 1, '10:00:00', '18:00:00');
INSERT INTO `schedules` (`week_day`) VALUES ('Mercredi');
INSERT INTO `schedules` (`week_day`, `open_day`, `open_hour`, `close_hour`) VALUES ('Jeudi', 1, '10:00:00', '18:00:00');
INSERT INTO `schedules` (`week_day`, `open_day`, `open_hour`, `close_hour`) VALUES ('Vendredi', 1, '10:00:00', '18:00:00');
INSERT INTO `schedules` (`week_day`, `open_day`, `open_hour`, `close_hour`) VALUES ('Samedi', 1, '10:00:00', '18:00:00');
INSERT INTO `schedules` (`week_day`) VALUES ('Dimanche');



CREATE TABLE `users` (
    `id_user` INT AUTO_INCREMENT,
    `email` VARCHAR(150)  NOT NULL,
    `phone` CHAR(10)  NOT NULL,
    `address` VARCHAR(150)  NOT NULL,
    `zipcode` CHAR(5)  NOT NULL,
    `city` VARCHAR(150)  NOT NULL,
    `artisan` BOOLEAN NOT NULL DEFAULT 0,
    `admin` BOOLEAN NOT NULL DEFAULT 0,
    `password` VARCHAR(250)  NOT NULL,
    `updated_at` DATETIME,
    PRIMARY KEY(`id_user`),
    UNIQUE(`email`),
    UNIQUE(`phone`)
) ENGINE=InnoDB;


INSERT INTO `users` (`email`, `phone`, `address`, `zipcode`, `city`, `artisan`, `admin`, `password`) VALUES ('esthetique@gmail.com', '0767476837', '10 chemin de la Tombelle', '02100', 'Saint-Quentin', 1, 1, '$2y$10$/f330AD9Bk7o5x1HXHc3k.r7ALBV/FtGU5Op6OEI9wmfAFrHhu326');


CREATE TABLE `announcements` (
    `id_announcement` INT AUTO_INCREMENT,
    `content` VARCHAR(500)  NOT NULL,
    `start_date` DATE NOT NULL,
    `end_date` DATE NOT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME,
    `deactivated_at` DATETIME,
    PRIMARY KEY(`id_announcement`)
) ENGINE=InnoDB;


INSERT INTO `announcements` (`content`, `start_date`, `end_date`) VALUES ('Toutes les prestations gratuites !', '2022-07-25', '2022-07-30');
INSERT INTO `announcements` (`content`, `start_date`, `end_date`, `deactivated_at`) VALUES ('Le salon sera exceptionnellement fermé du <span>25/07</span> au <span>30/07</span>', '2022-07-25', '2022-07-30', '2022-07-27');
INSERT INTO `announcements` (`content`, `start_date`, `end_date`) VALUES ('<span>-15%</span> sur les maquillages du <span>25/07</span> au <span>30/07</span>', '2024-07-25', '2024-10-12');




CREATE TABLE `categories` (
    `id_category` INT AUTO_INCREMENT,
    `name` VARCHAR(50)  NOT NULL,
    `description` VARCHAR(500),
    `view` TINYINT NOT NULL,
    `darkmode` BOOLEAN NOT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `published_at` DATETIME,
    `updated_at` DATETIME,
    `deactivated_at` DATETIME,
    PRIMARY KEY(`id_category`)
) ENGINE=InnoDB;


INSERT INTO `categories` (`id_category`, `name`, `description`, `view`, `darkmode`, `created_at`, `published_at`, `updated_at`, `deactivated_at`) VALUES
(1, 'Maquillages', '', 2, 1, '2023-10-17 15:46:55', '2023-12-09 15:24:52', NULL, NULL),
(2, 'Modelages', '', 2, 1, '2023-10-17 15:51:03', '2023-12-25 17:27:32', NULL, NULL),
(3, 'Soins du visage', '', 2, 0, '2023-10-17 15:51:49', '2023-12-25 20:13:34', '2023-12-25 19:59:44', NULL),
(4, 'Beauté des mains', '', 1, 1, '2023-10-17 15:51:56', '2023-12-25 20:12:15', '2023-12-25 17:29:06', NULL),
(5, 'Beauté des pieds', '', 1, 1, '2023-10-17 15:52:03', '2023-12-25 20:12:11', '2023-12-25 17:29:27', NULL),
(6, 'Soins du corps', '', 2, 1, '2023-10-17 15:52:22', '2023-12-25 20:12:59', '2023-12-25 20:10:58', NULL),
(7, 'Épilations', 'Optez pour une prestation d&#39;épilation, pour une peau douce et lisse, sans compromis.', 1, 1, '2023-10-26 18:52:42', NULL, NULL, NULL);


CREATE TABLE `discounts`(
    `id_discount` INT AUTO_INCREMENT,
    `start_date` DATE NOT NULL,
    `end_date` DATE NOT NULL,
    `advantage` TINYINT NOT NULL,
    `euro` BOOLEAN NOT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME,
    `deactivated_at` DATETIME,
    PRIMARY KEY(`id_discount`)
) ENGINE=InnoDB;


CREATE TABLE `services`(
    `id_service` INT AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL,
    `gender` TINYINT NOT NULL,
    `description` VARCHAR(250) ,
    `start_exclusive_date` DATE,
    `end_exclusive_date` DATE,
    `package` BOOLEAN NOT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `published_at` DATETIME,
    `updated_at` DATETIME,
    `deactivated_at` DATETIME,
    `id_discount` INT,
    `id_category` INT NOT NULL,
    PRIMARY KEY(`id_service`),
    CONSTRAINT `fk_discounts` FOREIGN KEY(`id_discount`) REFERENCES `discounts`(`id_discount`) ON DELETE SET NULL,
    CONSTRAINT `fk_categories` FOREIGN KEY(`id_category`) REFERENCES `categories`(`id_category`) ON DELETE CASCADE
) ENGINE=InnoDB;


CREATE TABLE `pricings`(
    `id_pricing` INT AUTO_INCREMENT,
    `duration` SMALLINT NOT NULL,
    `price` DECIMAL(5,2) NOT NULL,
    `id_service` INT NOT NULL,
    PRIMARY KEY(`id_pricing`),
    CONSTRAINT `fk_services` FOREIGN KEY(`id_service`) REFERENCES `services`(`id_service`) ON DELETE CASCADE
) ENGINE=InnoDB;



INSERT INTO `services` (`id_service`, `name`, `gender`, `description`, `start_exclusive_date`, `end_exclusive_date`, `package`, `created_at`, `published_at`, `updated_at`, `deactivated_at`, `id_discount`, `id_category`) VALUES
(1, 'Californien', 2, 'Un modelage relaxant qui utilise des mouvements fluides et harmonieux pour détendre les muscles et apaiser l&#39;esprit. Idéal pour une relaxation totale.', NULL, NULL, 0, '2023-10-26 18:34:02', '2023-12-25 17:27:38', NULL, NULL, 2, 2),
(2, 'Californien', 1, 'Un modelage relaxant qui utilise des mouvements fluides et harmonieux pour détendre les muscles et apaiser l&#39;esprit. Idéal pour une relaxation totale.', NULL, NULL, 0, '2023-10-26 18:35:16', '2023-12-25 17:27:41', NULL, NULL, 2, 2),
(3, 'Thaï Traditionnel', 2, 'Un modelage énergisant et stimulant qui combine des étirements doux et des pressions le long des lignes d&#39;énergie du corps pour restaurer l&#39;équilibre énergétique.', NULL, NULL, 0, '2023-10-26 18:35:55', '2023-12-25 17:27:52', NULL, NULL, 2, 2),
(4, 'Shiatsu', 2, 'Une technique japonaise de modelage qui applique des pressions rythmiques sur les points d&#39;acupuncture pour soulager les tensions, améliorer la circulation et favoriser la détente.', NULL, NULL, 0, '2023-10-26 18:36:31', '2023-12-25 17:27:46', NULL, NULL, 2, 2),
(5, 'Balinais', 2, 'Un modelage inspiré de la tradition balinaise qui combine des mouvements de pétrissage, d&#39;étirement et de pression pour relâcher les tensions musculaires et stimuler la circulation.', NULL, NULL, 0, '2023-10-26 18:36:56', '2023-12-25 17:27:36', NULL, NULL, 2, 2),
(6, 'Pierres Chaudes', 2, 'Un modelage relaxant qui utilise des pierres volcaniques chaudes pour détendre les muscles, favoriser la circulation sanguine et créer une expérience apaisante.', NULL, NULL, 0, '2023-10-26 18:37:18', '2023-12-25 17:27:43', NULL, NULL, 2, 2),
(7, 'Évasion Zen', 2, 'Modelage aux pierres chaudes et massage du cuir chevelu.', NULL, NULL, 1, '2023-10-26 18:37:48', '2023-12-25 17:27:57', NULL, NULL, NULL, 2),
(8, 'Énergie Vitale', 2, 'Modelage suédois tonifiant, soin des mains et des pieds.', NULL, NULL, 1, '2023-10-26 18:38:12', '2023-12-25 17:27:55', NULL, NULL, NULL, 2),
(9, 'Évasion Intense', 2, 'Plongez dans un voyage sensoriel avec ce modelage relaxant.', '2023-10-27', '2024-10-26', 0, '2023-10-26 18:39:20', NULL, NULL, NULL, NULL, 2),
(10, 'Harmonie Holistique', 2, 'Modelage harmonisant associant tradition et énergie pour une relaxation totale.', '2023-10-27', '2024-10-26', 0, '2023-10-26 18:40:50', NULL, NULL, NULL, NULL, 2),
(11, 'Douceur Printanière', 2, 'Épilation complète des jambes, des aisselles et maillot classique.', NULL, NULL, 1, '2023-10-26 18:53:38', NULL, NULL, NULL, NULL, 7),
(12, 'Sourcils', 2, '', NULL, NULL, 0, '2023-10-26 18:54:30', NULL, NULL, NULL, NULL, 7),
(13, 'Aisselles', 2, '', NULL, NULL, 0, '2023-10-26 18:55:29', NULL, NULL, NULL, NULL, 7),
(14, 'Demi-jambes', 2, '', NULL, NULL, 0, '2023-10-26 18:57:07', NULL, NULL, NULL, NULL, 7),
(15, 'Liberté sans Soucis', 2, 'Épilation des demi-jambes, des bras et des aisselles.', NULL, NULL, 1, '2023-10-26 18:57:33', NULL, NULL, NULL, NULL, 7),
(16, 'Dos', 2, '', NULL, NULL, 0, '2023-10-26 18:58:05', NULL, NULL, NULL, NULL, 7),
(17, 'Bras', 2, '', NULL, NULL, 0, '2023-10-26 18:58:22', NULL, NULL, NULL, NULL, 7),
(18, 'Maquillage de Jour', 2, 'Un maquillage léger et naturel, parfait pour une journée décontractée ou professionnelle.', NULL, NULL, 0, '2023-11-26 17:27:26', '2023-11-26 17:32:12', NULL, NULL, NULL, 1),
(20, 'Maquillage de Mariée', 2, 'Un maquillage élégant et longue tenue spécialement conçu pour le jour du mariage, mettant en valeur la beauté naturelle de la mariée.', NULL, NULL, 0, '2023-11-26 17:28:28', '2023-11-26 17:32:14', NULL, NULL, NULL, 1),
(21, 'Maquillage Artistique', 2, 'Un maquillage créatif et artistique adapté à un thème spécifique, idéal pour des événements artistiques ou des fêtes à thème.', NULL, NULL, 0, '2023-11-26 17:29:09', '2023-11-26 17:32:10', NULL, '2023-12-09 15:22:25', NULL, 1),
(22, 'Cours de Maquillage', 2, 'Une séance personnalisée où un professionnel enseigne à la cliente les techniques de base et les astuces pour un maquillage réussi.', '2023-11-27', '2023-12-10', 0, '2023-11-26 17:31:03', '2023-11-26 17:31:03', NULL, NULL, NULL, 1),
(23, 'Soin du Visage Classique', 2, 'Un soin de base comprenant le nettoyage en profondeur, l\'exfoliation, l\'extraction des comédons, un masque hydratant et une crème adaptée.', NULL, NULL, 0, '2023-11-26 17:38:00', '2023-11-26 17:40:43', NULL, NULL, NULL, 3),
(24, 'Soin du Visage Hydratant Intense', 2, 'Un traitement focalisé sur l\'hydratation, utilisant des produits riches en ingrédients hydratants pour restaurer l\'éclat de la peau.', NULL, NULL, 1, '2023-11-26 17:38:32', NULL, NULL, NULL, NULL, 3),
(25, 'Soin du Visage Anti-Âge', 2, 'Un soin spécialement conçu pour réduire les signes du vieillissement, comprenant des ingrédients anti-âge et des techniques stimulantes.', NULL, NULL, 0, '2023-11-26 17:38:58', '2023-11-26 17:40:36', NULL, NULL, NULL, 3),
(26, 'Soin du Visage Éclat Instantané', 2, 'Un traitement rapide pour redonner de l\'éclat à la peau, idéal avant un événement spécial.', NULL, NULL, 0, '2023-11-26 17:39:20', '2023-12-09 15:27:51', NULL, NULL, NULL, 3),
(27, 'Soin du Visage aux Vitamines', 2, 'Un soin revitalisant riche en vitamines pour nourrir la peau en profondeur et lui donner un aspect frais et énergisé.', NULL, NULL, 0, '2023-11-26 17:40:23', '2023-11-26 17:40:38', NULL, NULL, NULL, 3),
(28, 'Soin des mains aux gants chauffant', 2, 'Soin réparateur hydratant bio.', NULL, NULL, 0, '2023-12-25 19:29:20', '2023-12-25 20:11:49', NULL, NULL, NULL, 4),
(31, 'Pédicure Classique', 2, 'Un soin complet comprenant trempage, gommage, coupe et limage des ongles, soin des cuticules, massage relaxant et application de vernis (si désiré).', NULL, NULL, 0, '2023-12-25 19:39:50', '2023-12-25 20:12:28', '2023-12-25 19:49:46', NULL, NULL, 5),
(32, 'Traitement Anti-Callosités', 2, 'Ciblant les zones rugueuses et les callosités, ce traitement comprend un trempage spécial, un gommage intensif, un limage en profondeur, et une hydratation intense.', NULL, NULL, 0, '2023-12-25 19:41:04', '2023-12-25 20:12:34', NULL, NULL, NULL, 5),
(33, 'Beauté des Pieds Express', 2, 'Un soin rapide pour les personnes pressées, comprenant un trempage, une coupe et une mise en forme des ongles, et une hydratation légère.', NULL, NULL, 0, '2023-12-25 19:41:36', '2023-12-25 20:12:24', NULL, NULL, NULL, 5),
(34, 'Détente Totale', 2, 'Combinez une pédicure spa avec un massage des pieds prolongé pour une relaxation ultime.', NULL, NULL, 1, '2023-12-25 19:42:19', '2023-12-25 20:12:39', NULL, NULL, NULL, 5),
(35, 'Élégance Brillante', 2, 'Pédicure classique suivie d\'une pose de vernis semi-permanent pour une beauté durable.', NULL, NULL, 1, '2023-12-25 19:42:45', '2023-12-25 20:12:43', NULL, NULL, NULL, 5),
(36, 'Soin Intensif', 2, 'Traitement anti-callosités suivi d\'une pédicure classique pour des pieds lisses et soignés.', NULL, NULL, 1, '2023-12-25 19:43:14', '2023-12-25 20:12:51', NULL, NULL, NULL, 5),
(37, 'Manucure Classique', 2, 'Un soin complet comprenant trempage, gommage, coupe et limage des ongles, soin des cuticules, massage des mains et application de vernis (si désiré).', NULL, NULL, 0, '2023-12-25 19:44:46', '2023-12-25 20:11:46', '2023-12-25 19:49:29', NULL, NULL, 4),
(38, 'Traitement Anti-Âge', 2, 'Ciblant les signes de vieillissement, ce traitement inclut un gommage doux, un masque raffermissant, une hydratation intense et une finition parfaite des ongles.', NULL, NULL, 0, '2023-12-25 19:45:14', '2023-12-25 20:11:53', NULL, NULL, NULL, 4),
(39, 'Beauté des Mains Express', 2, 'Un soin rapide pour les personnes pressées, comprenant un trempage, une coupe et une mise en forme des ongles, et une hydratation légère.', NULL, NULL, 0, '2023-12-25 19:45:48', '2023-12-25 20:11:42', NULL, NULL, NULL, 4),
(40, 'Élégance Brillante', 2, 'Manucure classique suivie d\'une pose de vernis semi-permanent pour des ongles élégants qui durent.', NULL, NULL, 1, '2023-12-25 19:46:29', '2023-12-25 20:12:03', NULL, NULL, NULL, 4),
(41, 'Soin Intensif Anti-Âge', 2, 'Traitement anti-âge des mains suivi d\'une manucure spa pour des mains douces et jeunes.', NULL, NULL, 1, '2023-12-25 19:46:50', '2023-12-25 20:12:07', NULL, NULL, NULL, 4),
(42, 'Détente Suprême', 2, 'Combinez une manucure spa avec un massage prolongé des mains pour une relaxation totale.', NULL, NULL, 1, '2023-12-25 19:47:27', '2023-12-25 20:11:58', NULL, NULL, NULL, 4),
(43, 'Balinais', 1, 'Un modelage inspiré de la tradition balinaise qui combine des mouvements de pétrissage, d\'étirement et de pression pour relâcher les tensions musculaires et stimuler la circulation.', NULL, NULL, 0, '2023-12-25 19:53:22', '2023-12-25 19:53:28', '2023-12-25 19:53:50', NULL, 2, 2),
(44, 'Soin du Corps Relaxant', 1, 'Un soin complet du corps incluant un gommage, un enveloppement hydratant, suivi d\'un massage relaxant.', NULL, NULL, 0, '2023-12-25 20:02:27', '2023-12-25 20:13:03', NULL, NULL, NULL, 6),
(45, 'Traitement Détoxifiant', 1, 'Un traitement détoxifiant qui utilise des produits spéciaux pour éliminer les impuretés de la peau et stimuler la circulation.', NULL, NULL, 0, '2023-12-25 20:03:51', '2023-12-25 20:13:06', NULL, NULL, NULL, 6),
(46, 'Évasion Totale', 1, 'Combinez un massage du dos, un soin du corps relaxant et un traitement détoxifiant pour une évasion complète.', NULL, NULL, 1, '2023-12-25 20:05:11', '2023-12-25 20:13:13', NULL, NULL, NULL, 6),
(47, 'Renaissance Énergétique', 1, 'Massage du dos suivi d\'un traitement détoxifiant pour revigorer le corps et l\'esprit.', NULL, NULL, 1, '2023-12-25 20:05:56', '2023-12-25 20:13:17', NULL, NULL, NULL, 6);

INSERT INTO `pricings` (`id_pricing`, `duration`, `price`, `id_service`) VALUES
(1, 60, '65.00', 1),
(2, 30, '35.00', 1),
(3, 60, '80.00', 2),
(4, 30, '50.00', 2),
(5, 90, '80.00', 3),
(6, 45, '55.00', 4),
(7, 75, '70.00', 5),
(8, 60, '75.00', 6),
(9, 90, '80.00', 7),
(10, 105, '70.00', 8),
(11, 90, '120.00', 9),
(12, 60, '80.00', 9),
(13, 120, '150.00', 10),
(14, 90, '60.00', 11),
(15, 15, '15.00', 12),
(16, 20, '20.00', 13),
(17, 30, '30.00', 14),
(18, 75, '45.00', 15),
(19, 45, '40.00', 16),
(20, 25, '25.00', 17),
(21, 30, '40.00', 18),
(23, 90, '80.00', 20),
(24, 60, '70.00', 21),
(25, 90, '50.00', 22),
(26, 60, '70.00', 23),
(27, 75, '80.00', 24),
(28, 90, '95.00', 25),
(29, 45, '60.00', 26),
(30, 90, '95.00', 27),
(31, 30, '29.00', 28),
(34, 45, '60.00', 31),
(35, 30, '40.00', 32),
(36, 30, '30.00', 33),
(37, 90, '100.00', 34),
(38, 75, '90.00', 35),
(39, 75, '80.00', 36),
(40, 45, '60.00', 37),
(41, 45, '70.00', 38),
(42, 30, '35.00', 39),
(43, 75, '85.00', 40),
(44, 75, '90.00', 41),
(45, 90, '110.00', 42),
(46, 75, '80.00', 43),
(47, 90, '120.00', 44),
(48, 60, '90.00', 45),
(49, 120, '150.00', 46),
(50, 90, '120.00', 47);


INSERT INTO `discounts` (`id_discount`, `start_date`, `end_date`, `advantage`, `euro`, `created_at`, `updated_at`, `deactivated_at`) VALUES
(2, '2023-12-30', '2024-01-30', 15, 0, '2023-12-30 15:53:49', NULL, NULL);