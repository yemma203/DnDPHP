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
(1,'facile','Qu\'est-ce qui a des dents mais ne peut pas manger ?','Une cle','Un livre','Un ordinateur','Un peigne'),
(2,'facile','Qu\'est-ce qui a un fond et des cotes mais n\'a pas de haut ?','Un verre','Un seau','Une boite','Un tiroir'),
(3,'moyen','Qu\'est-ce qui a des branches mais pas de feuilles ni de fruits ?','Une etagere','Un arbre','Un buisson','Une bibliotheque'),
(4,'moyen','Je suis pris avant de naître, et je suis libere quand je meurs. Que suis-je ?','Un souffle','Un secret','Un virus','Un nom'),
(5,'difficile','Je parle sans bouche et entends sans oreilles. Qui suis-je ?','Un rêve','Un fantôme','Un echo','Un telephone'),
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
  KEY `fk_id_personnage` (`id_personnage`)
) ENGINE=InnoDB AUTO_INCREMENT=133 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
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
(1,'facile','Gobelin Timide',30,13),
(2,'facile','Slime Glouton',25,11),
(3,'moyen','Basilic Sombre',60,18),
(4,'moyen','Gargouille Malfaisante',65,16),
(5,'difficile','Draconis Obscurum',90,23),
(6,'difficile','Cyclope Titanesque',110,19);
/*!40000 ALTER TABLE `monstre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `objet`
--

DROP TABLE IF EXISTS `objet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `objet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `degats` int(11) DEFAULT NULL,
  `pa` int(11) DEFAULT NULL,
  `pv` int(11) DEFAULT NULL,
  `prix` int(11) DEFAULT NULL,
  `objet_marchand` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `objet`
--

LOCK TABLES `objet` WRITE;
/*!40000 ALTER TABLE `objet` DISABLE KEYS */;
INSERT INTO `objet` VALUES
(1,'Epee tranchante',20,3,NULL,30,0),
(2,'Arc du chasseur',15,2,NULL,25,0),
(3,'Baton magique',18,4,NULL,25,0),
(4,'Dague empoisonnee',25,5,NULL,30,0),
(5,'Marteau de guerre',30,6,NULL,30,0),
(6,'Potion de soin',NULL,2,25,25,0),
(7,'Hache tranchante',22,4,NULL,40,0),
(8,'Fleuret agile',16,2,NULL,50,0),
(9,'Baguette ensorcelee',20,3,NULL,55,0),
(10,'Lame empoisonnée',28,5,NULL,60,0),
(11,'Marteau de guerre lourd',35,7,NULL,65,0),
(12,'Epee amelioree',25,3,0,50,1),
(13,'Arc superieur',20,2,0,40,1),
(14,'Baton enchante',22,4,0,45,1),
(15,'Dague veneneuse',30,5,0,60,1),
(16,'Marteau de guerre renforce',35,6,0,70,1),
(17,'Hache de guerre redoutable',40,7,0,80,1),
(18,'Lance percante',28,3,0,55,1),
(19,'Fleuret agile superieur',18,2,0,35,1),
(20,'Lame empoisonnee avancee',32,5,0,65,1),
(21,'Potion de soin amelioree',0,2,30,30,1);
/*!40000 ALTER TABLE `objet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personnage`
--

DROP TABLE IF EXISTS `personnage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personnage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `pv` int(11) DEFAULT NULL,
  `point_action` int(11) DEFAULT NULL,
  `point_defense` int(11) DEFAULT NULL,
  `experience` int(11) DEFAULT NULL,
  `niveau` int(11) DEFAULT NULL,
  `salle_actuelle` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salle`
--

LOCK TABLES `salle` WRITE;
/*!40000 ALTER TABLE `salle` DISABLE KEYS */;
INSERT INTO `salle` VALUES
(1,'facile','enigme'),
(2,'facile','monstre'),
(3,'moyen','enigme'),
(4,'moyen','monstre'),
(5,'moyen','enigme'),
(6,'difficile','monstre'),
(7,'difficile','enigme'),
(8,'difficile','monstre'),
(9,'difficile','enigme'),
(10,'difficile','monstre');
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

-- Dump completed on 2023-11-24 16:40:55
