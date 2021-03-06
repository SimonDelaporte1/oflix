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
  `person_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D11BBA50217BBB47` (`person_id`),
  KEY `IDX_D11BBA508F93B6FC` (`movie_id`),
  CONSTRAINT `FK_D11BBA50217BBB47` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_D11BBA508F93B6FC` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `casting` (`id`, `role`, `credit_order`, `person_id`, `movie_id`) VALUES
(1,	'Le bon',	1,	6,	1),
(2,	'La personne mystere',	1,	1,	2),
(3,	'La personne mystere',	2,	8,	2),
(4,	'Le bon',	3,	5,	2),
(5,	'La personne mystere',	1,	5,	3),
(6,	'La personne mystere',	2,	3,	3),
(7,	'Figurant',	3,	2,	3),
(8,	'Figurant',	1,	4,	4),
(9,	'La personne mystere',	1,	1,	5),
(10,	'Figurant',	2,	8,	5),
(11,	'La personne mystere',	3,	6,	5),
(12,	'La personne mystere',	4,	2,	5),
(13,	'Le bon',	5,	5,	5),
(14,	'La personne mystere',	1,	2,	6),
(15,	'Figurant',	2,	4,	6),
(16,	'La personne mystere',	3,	8,	6),
(17,	'La personne mystere',	4,	3,	6),
(18,	'Figurant',	5,	6,	6),
(19,	'Le truant',	6,	7,	6),
(20,	'Le bon',	7,	1,	6),
(21,	'La personne mystere',	1,	6,	7),
(22,	'Figurant',	2,	4,	7),
(23,	'Le truant',	3,	1,	7),
(24,	'La personne mystere',	4,	8,	7),
(25,	'Le bon',	5,	5,	7),
(26,	'La personne mystere',	1,	1,	8),
(27,	'La personne mystere',	2,	8,	8),
(28,	'Figurant',	3,	2,	8);

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
('DoctrineMigrations\\Version20211214104123',	'2021-12-14 11:41:46',	193),
('DoctrineMigrations\\Version20211214110938',	'2021-12-14 12:09:52',	56),
('DoctrineMigrations\\Version20211214111218',	'2021-12-14 12:12:22',	58),
('DoctrineMigrations\\Version20211216110515',	'2021-12-16 12:05:43',	219),
('DoctrineMigrations\\Version20211216203840',	'2021-12-16 21:40:04',	74);

DROP TABLE IF EXISTS `genre`;
CREATE TABLE `genre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `genre` (`id`, `name`) VALUES
(1,	'Com??die'),
(2,	'Sci-fi'),
(3,	'Drame'),
(4,	'P??nible'),
(5,	'Sci-fi'),
(6,	'Sci-fi'),
(7,	'Epique');

DROP TABLE IF EXISTS `movie`;
CREATE TABLE `movie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `release_date` date DEFAULT NULL,
  `summary` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `synopsis` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poster` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` double DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `movie` (`id`, `title`, `type`, `release_date`, `summary`, `synopsis`, `poster`, `rating`, `duration`) VALUES
(1,	'Narcos',	'S??rie',	'2011-05-26',	'Eius ut consequuntur qui nihil unde. Sint esse praesentium eius ratione eos quia.',	'Et tour ?? tour de bras un flacon d\'eau de Cologne. Comme elle se permit tout haut quelque doute sur leur ??me avec des voix qui crie: ??Le voil??!?? Vous sentez le besoin de se blesser par terre. F??licit?? avait eu pareil d??ploiement de pompe! Plusieurs bourgeois, d??s la porte, des brodequins ?? clous luisants ??taient rang??s sous la Restauration, le Marquis, cherchant ?? cacheter la lettre, l\'ouvrit, et, comme elle rouvrait les yeux autour d\'elle, lentement, comme quelqu\'un qui se croyait contraint.',	'https://picsum.photos/id/23/200/300',	4.2,	117),
(2,	'Jack Reacher',	'Film',	'1995-11-21',	'Adipisci enim quod ex dolorem quas expedita cupiditate. Fugit a praesentium quam rerum quia quibusdam et.',	'Elle allait donc poss??der enfin ces joies de l\'amour, cette fi??vre du bonheur m??me qu\'elle lui avait command?? tous ces corps tass??s, on voyait se lever tout ?? fait. Elle aurait voulu ??tre cet homme. L\'autre continuait ?? marcher ?? demi pench?? sur elle, en lui passant la main et la femme du pharmacien donnant des conseils ?? son visage p??lissait le lasting de sa m??re, elle porterait comme elle, dans l\'??t??, de grands coups de motte de terre ?? c??t??; mais toute cette portion nouvelle est presque.',	'https://picsum.photos/id/33/200/300',	1.1,	134),
(3,	'Suicide squad',	'Film',	'1996-04-11',	'Quos ipsam aut eum cumque possimus. Qui illum dolores quidem iusto non. Totam ab commodi nihil placeat sunt minima.',	'Bovary, pendant ce temps-l??, pour moi, je ne sais pas tout? dit le pr??tre. -- Eh! non, d\'ailleurs, vous ne croiriez pas. Eh bien, moi, je suis ?? toi!?? Mais Emma s\'embarrassait d\'avance aux difficult??s de l\'entreprise, et ses pauvres mains se tra??naient au loin, qui allait se perdant, quoi qu\'elle f??t, sous les arbres se courbaient en berceaux, dans les salons, que l\'on traitait ?? Paris. Pour peu qu\'ils aient quelque talent d\'agr??ment, on les re??oit dans les cours. Il se tut par convenance, ??.',	'https://picsum.photos/id/3/200/300',	1.1,	70),
(4,	'Game of throne',	'S??rie',	'2017-06-11',	'Qui exercitationem porro sunt excepturi placeat est eaque. Ut porro amet voluptatem sint ut et corporis.',	'Puisque vous en faut une existence inutile? Si nos douleurs pouvaient servir ?? quelqu\'un, on se moquerait de toi, reste ?? ravauder des chaussettes. Et on l\'estimait davantage pour cet homme qu\'il avait promis d\'an??antir cette procuration... -- Comment? -- Ah! c\'est vous! merci! vous ??tes un impie! vous n\'avez pas de sit??t, ce serait m??me une ??pingle rest??e dans une cage d\'osier: c\'??tait le bruit d\'un cheval anglais, et conduit par un temps de domestique. L\'apothicaire se montra plus docile, et.',	'https://picsum.photos/id/72/200/300',	4.3,	92),
(5,	'Suicide squad',	'Film',	'1973-09-29',	'Cupiditate quidem et rerum eveniet quasi sequi quis nam. Deserunt blanditiis optio quae facere veniam et quae. Consequuntur earum autem earum odio possimus error.',	'Mais une charrette passait pr??s d\'elle, en claquant de la cuisine, o?? flambait un grand lit ?? faire des phrases, trouvant l\'astre m??lancolique et plein de po??sie; m??me elle souriait int??rieurement d\'une piti?? d??daigneuse, quand au fond d\'un golfe, au bord de la ferme, la mare bourbeuse, son p??re serait sourd, et il ouvrit la fen??tre, et, quand L??on eut remont?? sa garde-robe, fait rembourrer ses trois fauteuils, achet?? une provision de papier bleu, de la table, pr??sentaient, dessin??s sur leur.',	'https://picsum.photos/id/57/200/300',	4.2,	85),
(6,	'Suicide squad',	'Film',	'1972-11-24',	'Ipsa nesciunt iste repudiandae quam velit. Molestiae et iure quisquam laborum in. Totam omnis repudiandae sint aut.',	'Cependant le fiacre du Conseiller s\'??leva d\'un ton paternel: -- Approchez, v??n??rable Catherine-Nicaise-??lisabeth Leroux! dit M. Lheureux s\'en m??l??t. -- ??coutez donc! il me semble que, jusqu\'?? pr??sent, ne m\'a jamais exprim?? des sentiments sous la r??pulsion du mari. Plus elle se relevait, les membres fatigu??s, avec le lard de ses deux grosses l??vres tremblotaient, ce qui la soulagerait dans sa cave; aussi la poudre humide ne s\'enflammait gu??re, et le monde peut-??tre ne comprendrait pas; il se.',	'https://picsum.photos/id/71/200/300',	4.3,	104),
(7,	'L???Attaque de la Moussaka g??ante',	'Film',	'2007-06-11',	'Ullam maiores unde dolorum sed quibusdam. Repudiandae itaque error aliquam autem. Amet in et dolore quis alias placeat temporibus.',	'Tuvache, et il n\'en a pas pour rire d??daigneusement lorsqu\'il d??couvrit cette jambe gangren??e jusqu\'au genou. Puis, ayant d??clar?? net qu\'il la fallait amputer, il s\'en revenait de chez la nourrice. Pourquoi vient-elle ici? Elle y gardait un pupitre o?? ??taient peints sur la grande pyramide d\'??gypte. Elle est toute en fonte, elle... L??on fuyait; car il en versa les trois coupons du n?? 14. La servante l\'avait ??t?? chercher un fiacre! L\'enfant partit comme une bouff??e d\'air frais. -- Laissez-moi.',	'https://picsum.photos/id/89/200/300',	2.3,	177),
(8,	'Un flic',	'Film',	'1990-05-09',	'Dignissimos quo eos voluptatibus officiis eaque. Ex laboriosam at inventore sit. Aspernatur quisquam et non ratione.',	'Il faut remettre le panier ?? elle-m??me, en mains propres... Va, et prends garde! Girard passa sa blouse neuve, noua son mouchoir autour des bouchons, et tous mes r??ves!?? Le rideau se baissa. Homais fut plus qu\'un assemblage de mensonges, o?? elle l\'avait aim?? avec mille servilit??s qui l\'avaient d??tach?? d\'elle encore davantage. Enjou??e jadis, expansive et tout le bonheur d\'??tre avec vous... Emma rougit. Il n\'acheva point sa passion pour un autre; il ne sait pas s\'il doit se r??jouir des d??c??s ou.',	'https://picsum.photos/id/32/200/300',	1.1,	190);

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

INSERT INTO `movie_genre` (`movie_id`, `genre_id`) VALUES
(1,	7),
(2,	1),
(2,	2),
(2,	3),
(2,	4),
(2,	5),
(2,	6),
(2,	7),
(3,	5),
(4,	3),
(4,	5),
(5,	4),
(6,	1),
(6,	2),
(6,	3),
(6,	4),
(6,	5),
(6,	6),
(6,	7),
(7,	2),
(7,	4),
(7,	5),
(8,	4);

DROP TABLE IF EXISTS `person`;
CREATE TABLE `person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `person` (`id`, `firstname`, `lastname`) VALUES
(1,	'Laetitia',	'Charles Lagarde'),
(2,	'Virginie',	'Henri Blanchard'),
(3,	'Nathalie',	'??dith Benoit'),
(4,	'Madeleine',	'Diane Weber'),
(5,	'Nathalie',	'Gr??goire de Deschamps'),
(6,	'Hortense',	'Aim?? Bertin'),
(7,	'Brigitte',	'Th??odore Parent'),
(8,	'Ana??s',	'Fran??oise Gomes');

DROP TABLE IF EXISTS `review`;
CREATE TABLE `review` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `movie_id` int(11) DEFAULT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` double NOT NULL,
  `reactions` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `watched_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_794381C68F93B6FC` (`movie_id`),
  CONSTRAINT `FK_794381C68F93B6FC` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`id`)
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
(1,	1,	1,	4),
(2,	1,	2,	7),
(3,	1,	3,	8),
(4,	4,	1,	5),
(5,	4,	2,	8),
(6,	4,	3,	2),
(7,	4,	4,	3),
(8,	4,	5,	10),
(9,	4,	6,	3);

-- 2021-12-18 20:39:04
