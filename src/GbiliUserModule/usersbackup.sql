-- MySQL dump 10.13  Distrib 5.6.13, for osx10.7 (x86_64)
--
-- Host: localhost    Database: dog
-- ------------------------------------------------------
-- Server version	5.6.13

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `translated_category_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `locale` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `lft` int(11) NOT NULL,
  `lvl` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `root` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `uniqueslug` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3AF34668493588BF` (`translated_category_id`),
  KEY `IDX_3AF34668727ACA70` (`parent_id`),
  KEY `IDX_3AF34668A76ED395` (`user_id`),
  CONSTRAINT `FK_3AF34668493588BF` FOREIGN KEY (`translated_category_id`) REFERENCES `translated_categories` (`id`),
  CONSTRAINT `FK_3AF34668727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_3AF34668A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (2,1,NULL,'en','Uncategorized','uncategorized','',1,0,8,2,1,'uncategorized'),(3,1,NULL,'es','Sin CategorÃ­a','sin-categori    a','',1,0,8,3,1,'sin-categoria'),(4,1,NULL,'fr','Non CatÃ©gorisÃ©','non-categorise','',1,0,8,4,1,'non-categorise'),(5,1,NULL,'it','Senza Categoria','senza    -categoria','',1,0,2,5,1,'senza-categoria'),(6,1,NULL,'de','Keine Kategorie','keine-kategorie','',1,0,2,6,1,'keine-kategorie'),(7,2,2,'en','Symptom','symp    tom','Symptoms are what you see.',2,1,3,2,1,'symptom'),(8,3,2,'en','Cause','cause','Causes are what will enable you to find a solution. If you don\'t know     the cause of a symptom, then you have no clue to what should be done to avoid the symptom.',4,1,5,2,1,'cause'),(9,4,2,'en','Solution','solution','Solutio    ns will prevent the symptom. A solution can be found only if you know the cause of the symptom.',6,1,7,2,1,'solution'),(10,2,3,'es','SÃ­ntoma','sintoma','    Los sÃ­ntomas, son lo que puedes ver.',2,1,3,3,1,'sintoma'),(11,3,3,'es','Causa','causa','Las causas permiten encontrar la soluciÃ³n. Si no conoces la cau    sa de un sÃ­ntoma, no puedes encontrar una soluciÃ³n duradera.',4,1,5,3,1,'causa'),(12,4,3,'es','SoluciÃ³n','solucion','Las soluciones evitan los sÃ­ntoma    s. Solo puedes encontrar la soluciÃ³n si conoces la causa del sintoma.',6,1,7,3,1,'solucion'),(13,2,4,'fr','SymptÃ´me','symptome','Les symptÃ´mes sont ce     que l\'on peut voir.',2,1,3,4,1,'symptome'),(14,3,4,'fr','Cause','Cause','Les causes vous permettent de trouver une solution. Si vous ne connaÃ®ssez pas l    a cause du symptÃ´me, alors vous n\'avez aucune piste vers la solution.',4,1,5,4,1,'cause'),(15,4,4,'fr','Solution','solution','Les solutions prÃ©viennent     le symptÃ´me. La solution ne peut Ãªtre trouvÃ©e que si vous connaissez la cause du symptÃ´me.',6,1,7,4,1,'solution');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dogs`
--

DROP TABLE IF EXISTS `dogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `media_id` int(11) DEFAULT NULL,
  `locale` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `breed` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `color` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `weightkg` double DEFAULT NULL,
  `birthdate` datetime DEFAULT NULL,
  `whythisdog` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `IDX_353BEEB3EA9FDD75` (`media_id`),
  KEY `IDX_353BEEB3A76ED395` (`user_id`),
  CONSTRAINT `FK_353BEEB3A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_353BEEB3EA9FDD75` FOREIGN KEY (`media_id`) REFERENCES `medias` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dogs`
--

LOCK TABLES `dogs` WRITE;
/*!40000 ALTER TABLE `dogs` DISABLE KEYS */;
INSERT INTO `dogs` VALUES (1,1,4,'en','Nana','Chihuahua','db8e30','f',1,'2013-10-16 00:00:00','She is portable'),(2,1,4,'es','Llum','Guardiana del Container','8f8f8f','f',6,'2012-06-01 00:00:00','Por que me la encontrÃ© en un container.');
/*!40000 ALTER TABLE `dogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `basename` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `dirpath` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `size` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `files`
--

LOCK TABLES `files` WRITE;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
INSERT INTO `files` VALUES (8,'default-thumbnail.jpg','default-thumbnail.jpg','/Users/g/Documents/workspace/dog/public/img','image/jpeg',6482,'2014-02-23 22:03:12'),(10,'profile-thumbnail.jpg','profile-thumbnail.jpg','/Users/g/Documents/workspace/dog/public/img','image/jpeg',3136,'2014-02-23 22:53:10'),(16,'66b.jpg','66b.jpg','/Users/g/Documents/workspace/dog/public/img','image/jpeg',52470,'2014-03-06 19:13:10');
/*!40000 ALTER TABLE `files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media_metadatas`
--

DROP TABLE IF EXISTS `media_metadatas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `media_metadatas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `media_id` int(11) DEFAULT NULL,
  `locale` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `alt` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_24FBBCCCEA9FDD75` (`media_id`),
  CONSTRAINT `FK_24FBBCCCEA9FDD75` FOREIGN KEY (`media_id`) REFERENCES `medias` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media_metadatas`
--

LOCK TABLES `media_metadatas` WRITE;
/*!40000 ALTER TABLE `media_metadatas` DISABLE KEYS */;
INSERT INTO `media_metadatas` VALUES (1,NULL,'en','box-ebeniste-15.jpg',NULL),(2,4,'en','ebeniste-20.jpg',NULL),(3,4,'en','ebeniste-21.jpg',NULL),(4,4,'es','default-thumbnail.jpg',NULL),(5,4,'es','default-thumbnail-1.jpg',NULL),(6,4,'en','profile-thumbnail.jpg',NULL),(8,4,'es','66b.jpg',NULL);
/*!40000 ALTER TABLE `media_metadatas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medias`
--

DROP TABLE IF EXISTS `medias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `file_id` int(11) DEFAULT NULL,
  `publicdir` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `csspercent` int(11) DEFAULT NULL,
  `date` datetime NOT NULL,
  `slug` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_12D2AF81A76ED395` (`user_id`),
  KEY `IDX_12D2AF8193CB796C` (`file_id`),
  CONSTRAINT `FK_12D2AF8193CB796C` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_12D2AF81A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medias`
--

LOCK TABLES `medias` WRITE;
/*!40000 ALTER TABLE `medias` DISABLE KEYS */;
INSERT INTO `medias` VALUES (4,1,8,'/img',NULL,NULL,NULL,'2014-02-23 22:03:12','default-thumbnail.jpg');
/*!40000 ALTER TABLE `medias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_datas`
--

DROP TABLE IF EXISTS `post_datas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post_datas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `translated_postdata_id` int(11) DEFAULT NULL,
  `media_id` int(11) DEFAULT NULL,
  `locale` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_580380F5A597B787` (`translated_postdata_id`),
  KEY `IDX_580380F5EA9FDD75` (`media_id`),
  CONSTRAINT `FK_580380F5A597B787` FOREIGN KEY (`translated_postdata_id`) REFERENCES `translated_post_datas` (`id`),
  CONSTRAINT `FK_580380F5EA9FDD75` FOREIGN KEY (`media_id`) REFERENCES `medias` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_datas`
--

LOCK TABLES `post_datas` WRITE;
/*!40000 ALTER TABLE `post_datas` DISABLE KEYS */;
INSERT INTO `post_datas` VALUES (12,NULL,NULL,'es','asdf Ã©asdfÃ©Ã pÃ  ^  Â¨Â¨eÃ©Ã‰!','asdfasdfasdfadsfsafsafd','2014-03-07 09:29:10'),(17,NULL,NULL,'de','asdf','asdf','2014-03-08 17:19:43'),(18,NULL,NULL,'de','asdf','asdf','2014-03-08 17:23:56'),(19,NULL,4,'de','asdf','asdf','2014-03-08 17:24:33');
/*!40000 ALTER TABLE `post_datas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `translatedpost_id` int(11) DEFAULT NULL,
  `data_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `slug` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `lft` int(11) NOT NULL,
  `lvl` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `root` int(11) DEFAULT NULL,
  `uniqueslug` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_885DBAFAEA3821F8` (`translatedpost_id`),
  KEY `IDX_885DBAFA37F5A13C` (`data_id`),
  KEY `IDX_885DBAFA12469DE2` (`category_id`),
  KEY `IDX_885DBAFAA76ED395` (`user_id`),
  KEY `IDX_885DBAFA727ACA70` (`parent_id`),
  CONSTRAINT `FK_885DBAFA12469DE2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `FK_885DBAFA37F5A13C` FOREIGN KEY (`data_id`) REFERENCES `post_datas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_885DBAFA727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `posts` (`id`),
  CONSTRAINT `FK_885DBAFAA76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_885DBAFAEA3821F8` FOREIGN KEY (`translatedpost_id`) REFERENCES `translated_posts` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (9,NULL,19,NULL,4,NULL,'asdf','de',1,0,2,9,'asdf');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profiles`
--

DROP TABLE IF EXISTS `profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `media_id` int(11) DEFAULT NULL,
  `firstname` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8B308530EA9FDD75` (`media_id`),
  CONSTRAINT `FK_8B308530EA9FDD75` FOREIGN KEY (`media_id`) REFERENCES `medias` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profiles`
--

LOCK TABLES `profiles` WRITE;
/*!40000 ALTER TABLE `profiles` DISABLE KEYS */;
INSERT INTO `profiles` VALUES (1,4,'Guillermo','Pages','2014-02-23 15:04:51'),(2,4,'Marcus','Garvey','2014-02-24 15:40:07'),(3,4,'Johnny','De Vito','2014-03-07 12:45:32'),(4,4,'Julian','Pulido Pages','2014-03-08 15:19:40');
/*!40000 ALTER TABLE `profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `translated_categories`
--

DROP TABLE IF EXISTS `translated_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `translated_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `translated_categories`
--

LOCK TABLES `translated_categories` WRITE;
/*!40000 ALTER TABLE `translated_categories` DISABLE KEYS */;
INSERT INTO `translated_categories` VALUES (1),(2),(3),(4),(5),(6);
/*!40000 ALTER TABLE `translated_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `translated_post_datas`
--

DROP TABLE IF EXISTS `translated_post_datas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `translated_post_datas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `translated_post_datas`
--

LOCK TABLES `translated_post_datas` WRITE;
/*!40000 ALTER TABLE `translated_post_datas` DISABLE KEYS */;
/*!40000 ALTER TABLE `translated_post_datas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `translated_posts`
--

DROP TABLE IF EXISTS `translated_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `translated_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `translated_posts`
--

LOCK TABLES `translated_posts` WRITE;
/*!40000 ALTER TABLE `translated_posts` DISABLE KEYS */;
/*!40000 ALTER TABLE `translated_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_id` int(11) DEFAULT NULL,
  `uniquename` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1483A5E997AAD9C6` (`uniquename`),
  UNIQUE KEY `UNIQ_1483A5E9E7927C74` (`email`),
  UNIQUE KEY `UNIQ_1483A5E9CCFA12B8` (`profile_id`),
  CONSTRAINT `FK_1483A5E9CCFA12B8` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,1,'gbili','developer.guillermo@gmail.com','$2y$14$qUMZ2W31/fculZ5.9jNV3uiiMtroo8ZDqNlRxshFk7bMctRjrJxnW','admin'),(2,2,'Marcus_Garvey','daboom@boom.com','$2y$14$tVOSwH3Cf8alFt4Y9kSx1efDO0WQtk4kluRLLbxINJgulr8LKocEC','user'),(3,3,'Johny.de_Vito-21','mailing.guillermo@gmail.com','$2y$14$UXres55p5x/bDojeZazdOO8klZj0cQt4lgNPZilnI.MsGrNBfi8Wy','user'),(4,4,'Dios','pulidopages@gmail.com','$2y$14$37IM23OAe21jhIuZ8KtBW.f4ZEYh4kW6iiiQQAcsiHjoOcXrz3EsK','user');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-03-10  9:18:31
