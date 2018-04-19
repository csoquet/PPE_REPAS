-- --------------------------------------------------------
-- Hôte :                        172.17.0.2
-- Version du serveur:           5.5.49-0+deb8u1 - (Debian)
-- SE du serveur:                debian-linux-gnu
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Export de la structure de la base pour slimTDBDD
CREATE DATABASE IF NOT EXISTS `slimTDBDD` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `slimTDBDD`;

-- Export de la structure de la table slimTDBDD. chien
CREATE TABLE IF NOT EXISTS `chien` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `race` varchar(50) DEFAULT NULL,
  `idUser` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_chien_user` (`idUser`),
  CONSTRAINT `FK_chien_user` FOREIGN KEY (`idUser`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Export de données de la table slimTDBDD.chien : ~3 rows (environ)
/*!40000 ALTER TABLE `chien` DISABLE KEYS */;
INSERT INTO `chien` (`id`, `nom`, `race`, `idUser`) VALUES
	(1, 'test', 'test', 1),
	(2, 'test2', 'test2', 2),
	(3, 'toto', 'teckel', 2);
/*!40000 ALTER TABLE `chien` ENABLE KEYS */;

-- Export de la structure de la table slimTDBDD. user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tel` varchar(50) DEFAULT '0',
  `nom` varchar(50) DEFAULT '0',
  `prenom` varchar(50) DEFAULT '0',
  `mail` varchar(100) DEFAULT '0',
  `mdp` varchar(100) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Export de données de la table slimTDBDD.user : ~2 rows (environ)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `tel`, `nom`, `prenom`, `mail`, `mdp`) VALUES
	(1, '053543', 'soquet', 'chloe', 'chloe.soquet@hotmail.com', 'toto'),
	(2, '066464', 'Lacour', 'Emilien', 'emilien.lacour@gmail.fr', 'test');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
