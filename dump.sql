-- MySQL dump 10.13  Distrib 8.2.0, for Linux (x86_64)
--
-- Host: localhost    Database: restaurant_registration
-- ------------------------------------------------------
-- Server version	8.2.0

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
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customers` (
  `id_customer` int NOT NULL AUTO_INCREMENT,
  `name` varchar(65) NOT NULL,
  `birth_date` varchar(10) NOT NULL,
  `CPF` varchar(14) NOT NULL,
  PRIMARY KEY (`id_customer`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,'Lucas Felipe','2006-08-02','999.999.999-23'),(3,'Lucas De almeida','2023-11-22','111.111.111-11'),(4,'Lucas Ritzke','2009-06-08','123.456.789-10'),(5,'Lucas Mendoncino','2002-02-08','111.111.111-28'),(6,'Agauberto rooter','2006-02-08','123.123.123-12');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `drinks`
--

DROP TABLE IF EXISTS `drinks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `drinks` (
  `id_drink` int NOT NULL AUTO_INCREMENT,
  `name` varchar(34) NOT NULL,
  `price` double(5,2) NOT NULL,
  `amount` int NOT NULL,
  PRIMARY KEY (`id_drink`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `drinks`
--

LOCK TABLES `drinks` WRITE;
/*!40000 ALTER TABLE `drinks` DISABLE KEYS */;
INSERT INTO `drinks` VALUES (1,'Coca-Cola',2.50,43),(2,'Pepsi',2.00,34),(3,'Root Beer',3.00,4),(4,'Mountain Dew',2.75,9),(5,'Dr. Pepper',2.90,28),(6,'Sprite',2.25,111),(7,'Iced Tea',2.50,39),(8,'Schweppes',4.00,60),(10,'Fanta Cherry',4.95,93),(11,'Max laranjinha',9.00,60);
/*!40000 ALTER TABLE `drinks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pizza_buffet`
--

DROP TABLE IF EXISTS `pizza_buffet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pizza_buffet` (
  `name_buffet` varchar(45) DEFAULT NULL,
  `price` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pizza_buffet`
--

LOCK TABLES `pizza_buffet` WRITE;
/*!40000 ALTER TABLE `pizza_buffet` DISABLE KEYS */;
INSERT INTO `pizza_buffet` VALUES ('pizza buffet',69.99),('pizza buffet(half ticket)',39.99);
/*!40000 ALTER TABLE `pizza_buffet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prices`
--

DROP TABLE IF EXISTS `prices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prices` (
  `names` varchar(45) DEFAULT NULL,
  `price` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prices`
--

LOCK TABLES `prices` WRITE;
/*!40000 ALTER TABLE `prices` DISABLE KEYS */;
INSERT INTO `prices` VALUES ('Coca-Cola',2.5),('Pepsi',2),('Root Beer',3),('Mountain Dew',2.75),('Dr. Pepper',2.9),('Sprite',2.25),('Iced Tea',2.5),('pizza buffet',69.99),('pizza buffet(half ticket)',39.99);
/*!40000 ALTER TABLE `prices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reserved_tables`
--

DROP TABLE IF EXISTS `reserved_tables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reserved_tables` (
  `number_table` int DEFAULT NULL,
  `customer_name` varchar(35) DEFAULT NULL,
  `DAY` varchar(10) DEFAULT NULL,
  `time` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reserved_tables`
--

LOCK TABLES `reserved_tables` WRITE;
/*!40000 ALTER TABLE `reserved_tables` DISABLE KEYS */;
INSERT INTO `reserved_tables` VALUES (4,'Lucas Eduardo','2023-11-27','2:00'),(4,'Lucas Andre','2023-11-28','2:00'),(4,'Lucas Andre','2023-11-29','3:00'),(4,'Lucas Felipe','2023-11-28','1:00'),(4,'Lucas Andre','2023-11-29','3:00'),(4,'Lucas Felipe','2023-11-26','3:00'),(4,'Lucas Felipe','2023-11-26','3:00'),(5,'Joacir da Silva','2023-11-28','1:00'),(5,'Luciano','2023-11-28','1:00'),(5,'Lucas Felipe','2023-11-28','3:00'),(5,'Joacir da Silva','2023-11-29','1:00'),(5,'Joacir da Silva','2023-11-27','2:00');
/*!40000 ALTER TABLE `reserved_tables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_reservations`
--

DROP TABLE IF EXISTS `system_reservations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_reservations` (
  `id_reservation` int NOT NULL AUTO_INCREMENT,
  `customer` varchar(40) NOT NULL,
  `day` varchar(10) NOT NULL,
  `table_number` int NOT NULL,
  `enter_time` varchar(5) NOT NULL,
  `leave_time` varchar(5) NOT NULL,
  `reservation` int NOT NULL,
  `total_tables` int DEFAULT '12',
  PRIMARY KEY (`id_reservation`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_reservations`
--

LOCK TABLES `system_reservations` WRITE;
/*!40000 ALTER TABLE `system_reservations` DISABLE KEYS */;
INSERT INTO `system_reservations` VALUES (47,'Luciano','2023-11-11',6,'21:00','21:30',1,12),(48,'Luciano','2023-11-13',5,'20:00','21:00',1,12),(49,'Luciano','2023-11-13',3,'21:02','22:30',1,12),(50,'Luciano','2023-11-13',2,'21:00','22:00',1,12),(51,'Luciano','2023-11-15',4,'22:00','23:00',1,12),(52,'Joacir da Silva','2023-11-15',3,'16:00','17:00',1,12),(53,'Joacir da Silva','2023-11-15',1,'16:00','22:00',1,12),(62,'Joacir da Silva','2023-11-16',1,'16:00','19:00',1,12),(63,'Joacir da Silva','2023-11-16',4,'16:00','19:00',1,12),(64,'Lucas Andre','2023-11-16',3,'16:00','19:00',1,12),(65,'Luciano','2023-11-16',12,'19:20','23:08',1,12),(66,'Joacir da Silva','2023-11-16',9,'19:00','23:00',1,12),(67,'Lucas Andre','2023-11-16',10,'16:00','19:00',1,12),(68,'Luciano','2023-11-16',6,'16:00','20:00',1,12),(69,'Lucas Andre','2023-11-16',2,'16:00','19:00',1,12),(70,'Joacir da Silva','2023-11-16',10,'20:00','23:00',1,12),(71,'Joacir da Silva','2023-11-16',2,'20:00','23:00',1,12),(78,'Joacir da Silva','2023-11-19',4,'19:00','23:00',1,12),(86,'Lucas Eduardo','2023-11-27',4,'16:00','18:00',1,12),(88,'Lucas Andre','2023-11-29',4,'16:00','19:00',1,12),(90,'Lucas Andre','2023-11-29',4,'20:00','23:00',1,12),(91,'Joacir da Silva','2023-11-28',5,'16:00','17:00',1,12),(92,'Luciano','2023-11-28',5,'17:01','19:00',1,12),(93,'Lucas Felipe','2023-11-28',5,'20:00','23:00',1,12),(94,'Joacir da Silva','2023-11-29',5,'19:00','20:00',1,12);
/*!40000 ALTER TABLE `system_reservations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tables`
--

DROP TABLE IF EXISTS `tables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tables` (
  `id_table` int NOT NULL AUTO_INCREMENT,
  `number_table` int NOT NULL,
  PRIMARY KEY (`id_table`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tables`
--

LOCK TABLES `tables` WRITE;
/*!40000 ALTER TABLE `tables` DISABLE KEYS */;
INSERT INTO `tables` VALUES (1,1),(2,2),(3,3),(4,4),(5,5),(6,6),(7,7),(8,8),(9,9),(10,10),(11,11),(12,12);
/*!40000 ALTER TABLE `tables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `total_profits`
--

DROP TABLE IF EXISTS `total_profits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `total_profits` (
  `id_profit` int NOT NULL AUTO_INCREMENT,
  `which_profit` varchar(255) NOT NULL,
  `profit_type` varchar(255) DEFAULT NULL,
  `amount` int DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `DAY` date DEFAULT NULL,
  PRIMARY KEY (`id_profit`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `total_profits`
--

LOCK TABLES `total_profits` WRITE;
/*!40000 ALTER TABLE `total_profits` DISABLE KEYS */;
INSERT INTO `total_profits` VALUES (1,'pizza buffet','buffet',6,419.94,'2023-11-23'),(2,'pizza buffet(half ticket)','buffet',6,239.94,'2023-11-23'),(3,'Coca-Cola','drinks',6,15.00,'2023-11-23'),(4,'Pepsi','drinks',6,12.00,'2023-11-23'),(5,'Root Beer','drinks',6,18.00,'2023-11-23'),(6,'Mountain Dew','drinks',6,16.50,'2023-11-23'),(7,'Dr. Pepper','drinks',6,17.40,'2023-11-23'),(8,'Sprite','drinks',6,13.50,'2023-11-23'),(9,'Iced Tea','drinks',6,15.00,'2023-11-23'),(10,'Coca-Cola','drinks',7,186.60,'2023-11-24'),(11,'Coca-Cola','drinks',7,600.60,'2023-11-25'),(12,'pizza buffet','buffet',7,600.60,'2023-11-25'),(13,'pizza buffet','buffet',7,600.60,'2023-11-24'),(14,'pizza buffet','buffet',3,209.97,'2023-11-23'),(15,'pizza buffet(half ticket)','buffet',3,119.97,'2023-11-23'),(16,'Coca-Cola','drinks',3,7.50,'2023-11-23'),(17,'Pepsi','drinks',3,6.00,'2023-11-23'),(18,'Root Beer','drinks',3,9.00,'2023-11-23'),(19,'Mountain Dew','drinks',3,8.25,'2023-11-23'),(20,'Dr. Pepper','drinks',3,8.70,'2023-11-23'),(21,'Sprite','drinks',3,6.75,'2023-11-23'),(22,'Iced Tea','drinks',3,7.50,'2023-11-23'),(23,'pizza buffet','buffet',3,209.97,'2023-11-23'),(24,'pizza buffet(half ticket)','buffet',3,119.97,'2023-11-23'),(25,'Coca-Cola','drinks',3,7.50,'2023-11-23'),(26,'Pepsi','drinks',3,6.00,'2023-11-23'),(27,'Root Beer','drinks',3,9.00,'2023-11-23'),(28,'Mountain Dew','drinks',3,8.25,'2023-11-23'),(29,'Dr. Pepper','drinks',3,8.70,'2023-11-23'),(30,'Sprite','drinks',3,6.75,'2023-11-23'),(31,'Iced Tea','drinks',3,7.50,'2023-11-23'),(32,'pizza buffet','buffet',155,6000.00,'2023-11-27');
/*!40000 ALTER TABLE `total_profits` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-11-29 11:49:58
