-- MariaDB dump 10.19-11.1.2-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: dj_et_drag
-- ------------------------------------------------------
-- Server version	11.1.2-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `enigme`
--

DROP TABLE IF EXISTS `enigme`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enigme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `difficulte` varchar(255) DEFAULT NULL,
  `enonce` varchar(255) DEFAULT NULL,
  `mauvaise_reponse1` varchar(255) DEFAULT NULL,
  `mauvaise_reponse2` varchar(255) DEFAULT NULL,
  `mauvaise_reponse3` varchar(255) DEFAULT NULL,
  `bonne_reponse` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enigme`
--

LOCK TABLES `enigme` WRITE;
/*!40000 ALTER TABLE `enigme` DISABLE KEYS */;
INSERT INTO `enigme` VALUES
(1,'facile','Qu\'est-ce qui a des dents mais ne peut pas manger ?','Une clé','Un livre','Un ordinateur','Un peigne'),
(2,'facile','Qu\'est-ce qui a un fond et des côtés mais n\'a pas de haut ?','Un verre','Un seau','Une boîte','Un tiroir'),
(3,'moyen','Qu\'est-ce qui a des branches mais pas de feuilles ni de fruits ?','Une étagère','Un arbre','Un buisson','Une bibliothèque'),
(4,'moyen','Je suis pris avant de naître, et je suis libéré quand je meurs. Que suis-je ?','Un souffle','Un secret','Un virus','Un nom'),
(5,'difficile','Je parle sans bouche et entends sans oreilles. Qui suis-je ?','Un rêve','Un fantôme','Un écho','Un téléphone'),
(6,'difficile','Plus vous en prenez, plus vous en laissez derrière. Que suis-je ?','Le temps','L\'ombre','La chaleur','Les empreintes digitales');
/*!40000 ALTER TABLE `enigme` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventaire`
--

DROP TABLE IF EXISTS `inventaire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_objet` int(11) DEFAULT NULL,
  `id_personnage` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_objet` (`id_objet`),
  KEY `fk_id_personnage` (`id_personnage`),
  CONSTRAINT `fk_id_personnage` FOREIGN KEY (`id_personnage`) REFERENCES `personnage` (`id`),
  CONSTRAINT `inventaire_ibfk_1` FOREIGN KEY (`id_objet`) REFERENCES `objet` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventaire`
--

LOCK TABLES `inventaire` WRITE;
/*!40000 ALTER TABLE `inventaire` DISABLE KEYS */;
/*!40000 ALTER TABLE `inventaire` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `monstre`
--

DROP TABLE IF EXISTS `monstre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `monstre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `difficulte` varchar(255) DEFAULT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `pv` int(11) DEFAULT NULL,
  `puissance` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `monstre`
--

LOCK TABLES `monstre` WRITE;
/*!40000 ALTER TABLE `monstre` DISABLE KEYS */;
INSERT INTO `monstre` VALUES
(1,'facile','Gobelin Timide',50,10),
(2,'facile','Slime Glouton',45,8),
(3,'moyen','Basilic Sombre',80,15),
(4,'moyen','Gargouille Malfaisante',75,12),
(5,'difficile','Draconis Obscurum',120,20),
(6,'difficile','Cyclope Titanesque',110,18);
/*!40000 ALTER TABLE `monstre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `objet`
--

DROP TABLE IF EXISTS `objet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `objet` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `degats` int(11) DEFAULT NULL,
  `pa` int(11) DEFAULT NULL,
  `pv` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `objet`
--

LOCK TABLES `objet` WRITE;
/*!40000 ALTER TABLE `objet` DISABLE KEYS */;
/*!40000 ALTER TABLE `objet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personnage`
--

DROP TABLE IF EXISTS `personnage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personnage` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `pv` int(11) DEFAULT NULL,
  `point_action` int(11) DEFAULT NULL,
  `point_defense` int(11) DEFAULT NULL,
  `experience` int(11) DEFAULT NULL,
  `niveau` int(11) DEFAULT NULL,
  `salle_actuelle` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personnage`
--

LOCK TABLES `personnage` WRITE;
/*!40000 ALTER TABLE `personnage` DISABLE KEYS */;
/*!40000 ALTER TABLE `personnage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `salle`
--

DROP TABLE IF EXISTS `salle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `salle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `difficulte` varchar(255) DEFAULT NULL,
  `type_salle` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salle`
--

LOCK TABLES `salle` WRITE;
/*!40000 ALTER TABLE `salle` DISABLE KEYS */;
/*!40000 ALTER TABLE `salle` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-11-23 11:39:51
