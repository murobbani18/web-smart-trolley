-- MySQL dump 10.13  Distrib 9.2.0, for macos14.7 (x86_64)
--
-- Host: 127.0.0.1    Database: db_smart_trolly
-- ------------------------------------------------------
-- Server version	8.4.5

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `item_rfids`
--

DROP TABLE IF EXISTS `item_rfids`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `item_rfids` (
  `id` int NOT NULL AUTO_INCREMENT,
  `item_id` int NOT NULL,
  `rfid_code` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `item_rfids_unique` (`rfid_code`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_rfids`
--

LOCK TABLES `item_rfids` WRITE;
/*!40000 ALTER TABLE `item_rfids` DISABLE KEYS */;
INSERT INTO `item_rfids` VALUES (1,7,'549AF603','2025-05-01 10:11:37'),(2,7,'549AF601','2025-05-01 10:11:37'),(3,2,'549AF602','2025-05-01 10:11:37'),(4,2,'549AF604','2025-05-01 10:11:37'),(18,21,'d324','2025-05-09 13:01:59'),(20,22,'j890','2025-05-09 13:09:06'),(23,22,'anjing','2025-05-09 13:23:28'),(24,22,'fatur pusing hahaaha','2025-05-09 13:24:13');
/*!40000 ALTER TABLE `item_rfids` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `stock` int NOT NULL,
  `rfid_code` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `rack_code` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `position_detail` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` VALUES (2,'Alexander the Great book\'s',200000,10,'549AF603','R-01','rak kedua','A catalog of books about Alexander the Great typically includes biographies, historical analyses, and explorations of the cultural impact of his life and conquests. These books delve into his military strategies, leadership, and the legacy he left behind, examining both his successes and failures. They also often explore the evolution of Alexander\'s image in literature, art, and popular culture.','1745918317_df1b3b29a75f22081655.jpg','2025-04-29 09:10:30','2025-05-09 09:54:52'),(7,'landscape poster',400000,10,'1826182','R-02','rak pertama','','1746784524_394c2dc5ca39fe57b6d5.png','2025-04-29 09:32:44','2025-05-09 09:55:24'),(21,'Ferso',12345,0,'[{\"value\":\"d324\"},{\"value\":\"s3234\"},{\"value\":\"d3456\"}]','d-01','rak kedua','ferso ferso','1746795719_a413ddfc9ee22edfd3d5.png','2025-05-09 13:01:59','2025-05-09 13:39:16'),(22,'verti',214,10,'[{\"value\":\"j890\"},{\"value\":\"anjing\"},{\"value\":\"fatur pusing hahaaha\"}]','e43','kiri atas','vwert','1746796146_88405162607cde4500fa.png','2025-05-09 13:09:06','2025-05-09 14:05:08');
/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_items`
--

DROP TABLE IF EXISTS `payment_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `payment_id` int NOT NULL,
  `item_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price_at_purchase` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_items`
--

LOCK TABLES `payment_items` WRITE;
/*!40000 ALTER TABLE `payment_items` DISABLE KEYS */;
INSERT INTO `payment_items` VALUES (21,14,7,1,400000),(22,14,2,1,200000),(23,14,7,1,400000),(24,14,2,1,200000),(25,15,2,1,200000),(26,16,22,1,214),(27,16,22,1,214),(28,16,21,1,12345),(29,17,22,1,214),(30,18,22,1,214);
/*!40000 ALTER TABLE `payment_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `total_amount` decimal(10,0) NOT NULL,
  `status` enum('pending','validated','cancelled') COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (14,2,1200000,'validated','2025-05-02 03:42:08','2025-05-02 03:12:52'),(15,2,200000,'validated','2025-05-09 13:41:33','2025-05-09 09:29:44'),(16,2,12773,'pending','2025-05-09 13:39:16','2025-05-09 13:39:16'),(17,2,214,'cancelled','2025-05-09 13:53:21','2025-05-09 13:52:49'),(18,2,214,'pending','2025-05-09 14:05:08','2025-05-09 14:05:08');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trolley_items`
--

DROP TABLE IF EXISTS `trolley_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `trolley_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `item_id` int NOT NULL,
  `quantity` int NOT NULL,
  `rfid_code` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trolley_items`
--

LOCK TABLES `trolley_items` WRITE;
/*!40000 ALTER TABLE `trolley_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `trolley_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('trolley','staff') COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'STAFF1','$2y$10$2icqh0qXL64ZFIz8qRILke/yXVsKQn9G8FcGGjbU58FvJbAdbTEce','staff','2025-04-28 19:42:10','2025-04-29 02:43:15'),(2,'TROLLEY','$2y$10$UOofhtZC6Ah4xyYXT/cFmu16nNUYq/ZeCkWsn1hrIf2H8wt4/CxDO','trolley','2025-04-29 08:05:27','2025-04-29 08:05:27');
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

-- Dump completed on 2025-05-09 21:18:38
