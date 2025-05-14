CREATE DATABASE  IF NOT EXISTS `capa` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `capa`;
-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: localhost    Database: capa
-- ------------------------------------------------------
-- Server version	8.0.39

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `carrito`
--

DROP TABLE IF EXISTS `carrito`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carrito` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ID_USUARIO` int NOT NULL,
  `ID_PRODUCTO` int NOT NULL,
  `CANTIDAD` int NOT NULL,
  `ELIMINADO` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `ID_USUARIO` (`ID_USUARIO`),
  KEY `ID_PRODUCTO` (`ID_PRODUCTO`),
  CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`ID_USUARIO`) REFERENCES `usuario` (`ID`),
  CONSTRAINT `carrito_ibfk_2` FOREIGN KEY (`ID_PRODUCTO`) REFERENCES `producto` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carrito`
--

LOCK TABLES `carrito` WRITE;
/*!40000 ALTER TABLE `carrito` DISABLE KEYS */;
/*!40000 ALTER TABLE `carrito` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categoria` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `TITULO` varchar(50) NOT NULL,
  `DESCRIPCION` varchar(255) DEFAULT NULL,
  `ID_CREADOR` int NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_CREADOR` (`ID_CREADOR`),
  CONSTRAINT `categoria_ibfk_1` FOREIGN KEY (`ID_CREADOR`) REFERENCES `usuario` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (1,'fut',NULL,9),(2,'basketball',NULL,9),(3,'golf',NULL,9);
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chat`
--

DROP TABLE IF EXISTS `chat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chat` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ID_COMPRADOR` int NOT NULL,
  `ID_VENDEDOR` int NOT NULL,
  `FECHA_CREACION` datetime DEFAULT CURRENT_TIMESTAMP,
  `ESTADO` enum('abierto','cerrado') DEFAULT 'abierto',
  PRIMARY KEY (`ID`),
  KEY `ID_COMPRADOR` (`ID_COMPRADOR`),
  KEY `ID_VENDEDOR` (`ID_VENDEDOR`),
  CONSTRAINT `chat_ibfk_1` FOREIGN KEY (`ID_COMPRADOR`) REFERENCES `usuario` (`ID`),
  CONSTRAINT `chat_ibfk_2` FOREIGN KEY (`ID_VENDEDOR`) REFERENCES `usuario` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat`
--

LOCK TABLES `chat` WRITE;
/*!40000 ALTER TABLE `chat` DISABLE KEYS */;
/*!40000 ALTER TABLE `chat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chat_mensaje`
--

DROP TABLE IF EXISTS `chat_mensaje`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chat_mensaje` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ID_CHAT` int NOT NULL,
  `ID_USUARIO` int NOT NULL,
  `MENSAJE` text NOT NULL,
  `FECHA_CREACION` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  KEY `ID_CHAT` (`ID_CHAT`),
  KEY `ID_USUARIO` (`ID_USUARIO`),
  CONSTRAINT `chat_mensaje_ibfk_1` FOREIGN KEY (`ID_CHAT`) REFERENCES `chat` (`ID`),
  CONSTRAINT `chat_mensaje_ibfk_2` FOREIGN KEY (`ID_USUARIO`) REFERENCES `usuario` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat_mensaje`
--

LOCK TABLES `chat_mensaje` WRITE;
/*!40000 ALTER TABLE `chat_mensaje` DISABLE KEYS */;
/*!40000 ALTER TABLE `chat_mensaje` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comentario`
--

DROP TABLE IF EXISTS `comentario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comentario` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ID_USUARIO` int NOT NULL,
  `ID_PRODUCTO` int NOT NULL,
  `DESCRIPCION` text NOT NULL,
  `FECHA` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  KEY `ID_USUARIO` (`ID_USUARIO`),
  KEY `ID_PRODUCTO` (`ID_PRODUCTO`),
  CONSTRAINT `comentario_ibfk_1` FOREIGN KEY (`ID_USUARIO`) REFERENCES `usuario` (`ID`),
  CONSTRAINT `comentario_ibfk_2` FOREIGN KEY (`ID_PRODUCTO`) REFERENCES `producto` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comentario`
--

LOCK TABLES `comentario` WRITE;
/*!40000 ALTER TABLE `comentario` DISABLE KEYS */;
/*!40000 ALTER TABLE `comentario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `listas`
--

DROP TABLE IF EXISTS `listas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `listas` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(100) NOT NULL,
  `DESCRIPCION` text,
  `IMAGEN` varchar(255) DEFAULT NULL,
  `PRIVACIDAD` tinyint(1) NOT NULL DEFAULT '0',
  `ID_USUARIO` int NOT NULL,
  `FECHA_CREACION` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  KEY `ID_USUARIO` (`ID_USUARIO`),
  CONSTRAINT `listas_ibfk_1` FOREIGN KEY (`ID_USUARIO`) REFERENCES `usuario` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `listas`
--

LOCK TABLES `listas` WRITE;
/*!40000 ALTER TABLE `listas` DISABLE KEYS */;
INSERT INTO `listas` VALUES (2,'Senderismo','Esta lista es una guia para compras de senderismo','681e4d09f24f8_bosquePortada.jpeg',0,8,'2025-05-09 12:44:26'),(3,'Esto es una tercera Lista','Listaaaaa','681e63fab6702_bosquePortada.jpeg',0,8,'2025-05-09 14:22:18'),(4,'Esto es una lista publica','Esto es una lista publicaaaaa','681f7e8f2a819_bosquePortada.jpeg',1,8,'2025-05-10 10:27:59'),(5,'esta es una lista privada en un perfil privado','esta es una lista privada en un perfil privado','6824fd65778ca_bosquePortada.jpeg',0,10,'2025-05-14 14:30:29'),(6,'esta es una lista publica en un perfil privado','esta es una lista publica en un perfil privado','6824fd767c2cc_bosquePortada.jpeg',1,10,'2025-05-14 14:30:46');
/*!40000 ALTER TABLE `listas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `listas_productos`
--

DROP TABLE IF EXISTS `listas_productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `listas_productos` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ID_LISTA` int NOT NULL,
  `ID_PRODUCTO` int NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_WISHLIST` (`ID_LISTA`),
  KEY `ID_PRODUCTO` (`ID_PRODUCTO`),
  CONSTRAINT `fk_lista_producto_lista` FOREIGN KEY (`ID_LISTA`) REFERENCES `listas` (`ID`) ON DELETE CASCADE,
  CONSTRAINT `fk_lista_producto_producto` FOREIGN KEY (`ID_PRODUCTO`) REFERENCES `producto` (`ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `listas_productos`
--

LOCK TABLES `listas_productos` WRITE;
/*!40000 ALTER TABLE `listas_productos` DISABLE KEYS */;
/*!40000 ALTER TABLE `listas_productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orden`
--

DROP TABLE IF EXISTS `orden`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orden` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ID_USUARIO` int NOT NULL,
  `TOTAL` decimal(10,2) NOT NULL,
  `FECHA_HORA` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  KEY `ID_USUARIO` (`ID_USUARIO`),
  CONSTRAINT `orden_ibfk_1` FOREIGN KEY (`ID_USUARIO`) REFERENCES `usuario` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orden`
--

LOCK TABLES `orden` WRITE;
/*!40000 ALTER TABLE `orden` DISABLE KEYS */;
/*!40000 ALTER TABLE `orden` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orden_detalle`
--

DROP TABLE IF EXISTS `orden_detalle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orden_detalle` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ID_ORDEN` int NOT NULL,
  `ID_PRODUCTO` int NOT NULL,
  `CANTIDAD` int NOT NULL,
  `PRECIO_UNITARIO` decimal(10,2) NOT NULL,
  `IMPORTE` decimal(10,2) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_ORDEN` (`ID_ORDEN`),
  KEY `ID_PRODUCTO` (`ID_PRODUCTO`),
  CONSTRAINT `orden_detalle_ibfk_1` FOREIGN KEY (`ID_ORDEN`) REFERENCES `orden` (`ID`),
  CONSTRAINT `orden_detalle_ibfk_2` FOREIGN KEY (`ID_PRODUCTO`) REFERENCES `producto` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orden_detalle`
--

LOCK TABLES `orden_detalle` WRITE;
/*!40000 ALTER TABLE `orden_detalle` DISABLE KEYS */;
/*!40000 ALTER TABLE `orden_detalle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto`
--

DROP TABLE IF EXISTS `producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `producto` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(100) NOT NULL,
  `DESCRIPCION` text,
  `PRECIO` decimal(10,2) DEFAULT NULL,
  `STOCK` int DEFAULT '0',
  `TIPO_PUBLICACION` enum('venta','cotizacion') NOT NULL,
  `AUTORIZADO` tinyint(1) DEFAULT '0',
  `DISPONIBLE` tinyint(1) DEFAULT '1',
  `ID_VENDEDOR` int NOT NULL,
  `ID_ADMIN_AUTORIZADOR` int DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto`
--

LOCK TABLES `producto` WRITE;
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
INSERT INTO `producto` VALUES (1,'tenis','esto son unos tenis',NULL,100,'venta',0,1,9,NULL),(2,'tenis 2','esto es un tenis',NULL,22,'cotizacion',0,1,9,NULL),(3,'tenis 3','estos es un tercer tenis',NULL,2,'venta',0,1,9,NULL),(4,'producto 4','producto 4',200.00,200,'venta',0,1,9,NULL),(5,'aaaa','aaaa',399.00,222,'venta',0,1,9,NULL),(6,'aaa','aaa',NULL,2,'cotizacion',0,1,9,NULL),(7,'aaa','aaa',NULL,2,'cotizacion',0,1,9,NULL);
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto_categoria`
--

DROP TABLE IF EXISTS `producto_categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `producto_categoria` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ID_PRODUCTO` int NOT NULL,
  `ID_CATEGORIA` int NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_PRODUCTO` (`ID_PRODUCTO`),
  KEY `ID_CATEGORIA` (`ID_CATEGORIA`),
  CONSTRAINT `producto_categoria_ibfk_1` FOREIGN KEY (`ID_PRODUCTO`) REFERENCES `producto` (`ID`),
  CONSTRAINT `producto_categoria_ibfk_2` FOREIGN KEY (`ID_CATEGORIA`) REFERENCES `categoria` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto_categoria`
--

LOCK TABLES `producto_categoria` WRITE;
/*!40000 ALTER TABLE `producto_categoria` DISABLE KEYS */;
INSERT INTO `producto_categoria` VALUES (1,1,1),(2,2,2),(3,2,3),(4,3,3),(5,4,1),(6,4,2),(7,4,3),(8,5,2),(9,6,2),(10,7,2);
/*!40000 ALTER TABLE `producto_categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto_multimedia`
--

DROP TABLE IF EXISTS `producto_multimedia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `producto_multimedia` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `RUTA_MULTIMEDIA` varchar(255) NOT NULL,
  `ID_PRODUCTO` int NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_PRODUCTO` (`ID_PRODUCTO`),
  CONSTRAINT `imagenes_producto_ibfk_1` FOREIGN KEY (`ID_PRODUCTO`) REFERENCES `producto` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto_multimedia`
--

LOCK TABLES `producto_multimedia` WRITE;
/*!40000 ALTER TABLE `producto_multimedia` DISABLE KEYS */;
INSERT INTO `producto_multimedia` VALUES (1,'682524be15e0f_Perfil1.jpg',2),(2,'682524be16143_Perfil3.jpg',2),(3,'682524be163ba_Perfil2.jpg',2),(4,'682524be20470_video1.mp4',2),(5,'6825252e3c5a2_video1.mp4',3),(6,'6825256cadc66_bosquePortada.jpeg',4),(7,'6825256cadf2e_Perfil3.jpg',4),(8,'6825256cae762_Perfil2.jpg',4),(9,'6825256caec2c_Perfil1.jpg',4),(10,'6825256cb4ce4_video2.mp4',4),(11,'68252613e2803_Perfil3.jpg',5),(12,'68252613e2ac9_Perfil1.jpg',5),(13,'68252613e2d42_Perfil2.jpg',5),(14,'68252613e81da_video1.mp4',5),(15,'68252711ec906_bosquePortada.jpeg',6),(16,'68252711ecc3f_Perfil1.jpg',6),(17,'68252711ed83d_Perfil2.jpg',6),(18,'68252711f2c9c_video1.mp4',6),(19,'6825276d9e055_Perfil1.jpg',7),(20,'6825276d9e555_Perfil2.jpg',7),(21,'6825276d9eade_bosquePortada.jpeg',7),(22,'6825276da3a4a_video1.mp4',7);
/*!40000 ALTER TABLE `producto_multimedia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(50) NOT NULL,
  `APELLIDO_P` varchar(50) DEFAULT NULL,
  `APELLIDO_M` varchar(50) DEFAULT NULL,
  `SEXO` enum('M','F') NOT NULL,
  `CORREO` varchar(80) NOT NULL,
  `USERNAME` varchar(50) NOT NULL,
  `PASSW` varchar(255) NOT NULL,
  `ROL` enum('comprador','vendedor','administrador','superadmin') NOT NULL,
  `IMAGEN` varchar(255) DEFAULT NULL,
  `FECHA_NACIMIENTO` date DEFAULT NULL,
  `FECHA_REGISTRO` datetime DEFAULT CURRENT_TIMESTAMP,
  `PRIVACIDAD` tinyint(1) DEFAULT '1',
  `ES_SUPERADMIN` tinyint(1) DEFAULT '0',
  `TOKEN` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `CORREO` (`CORREO`),
  UNIQUE KEY `USERNAME` (`USERNAME`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (8,'Jose Emiliano','Frias','Felix','M','emilianofriasfelix@outlook.com','VocalEm','$2y$10$nAYkJ9SmexGuZvxLw4Wx/O53.yjKdmlqTxGZhbwsehUWVtMrazvg2','comprador','681cf3d59b711_Perfil1.jpg','2003-11-11','2025-05-08 12:11:33',1,0,'7868f44b0d26d8f48fb398c4a3f46476560ebd61f4d6e9b31888427a69e7c6af'),(9,'Diego','Medellin','Melendez','M','diego@gmail.com','Diego333','$2y$10$zhXLWs/RtdCXNN4XRIWKTeA/nehnXCpAKdU7hR73wtfe79npPb7R.','vendedor','681cf47ca8a6d_Perfil3.jpg','2003-12-12','2025-05-08 12:14:20',1,0,NULL),(10,'Monserrat','Carranza ','Chimal','F','monse@gmail.com','mon33','$2y$10$1uHSZouXwRpU1wb7Sn2mM.7Kij8Kn4Sol3sO12TBq.k6EkW7jxK2i','comprador','6824fd26f368d_emi3.jpg','2003-11-11','2025-05-14 14:29:26',0,0,NULL);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `valoracion`
--

DROP TABLE IF EXISTS `valoracion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `valoracion` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ID_USUARIO` int NOT NULL,
  `ID_PRODUCTO` int NOT NULL,
  `PUNTUACION` int NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_USUARIO` (`ID_USUARIO`),
  KEY `ID_PRODUCTO` (`ID_PRODUCTO`),
  CONSTRAINT `valoracion_ibfk_1` FOREIGN KEY (`ID_USUARIO`) REFERENCES `usuario` (`ID`),
  CONSTRAINT `valoracion_ibfk_2` FOREIGN KEY (`ID_PRODUCTO`) REFERENCES `producto` (`ID`),
  CONSTRAINT `valoracion_chk_1` CHECK ((`PUNTUACION` between 1 and 5))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `valoracion`
--

LOCK TABLES `valoracion` WRITE;
/*!40000 ALTER TABLE `valoracion` DISABLE KEYS */;
/*!40000 ALTER TABLE `valoracion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `videos_producto`
--

DROP TABLE IF EXISTS `videos_producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `videos_producto` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `RUTA_VIDEO` varchar(255) NOT NULL,
  `ID_PRODUCTO` int NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_PRODUCTO` (`ID_PRODUCTO`),
  CONSTRAINT `videos_producto_ibfk_1` FOREIGN KEY (`ID_PRODUCTO`) REFERENCES `producto` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `videos_producto`
--

LOCK TABLES `videos_producto` WRITE;
/*!40000 ALTER TABLE `videos_producto` DISABLE KEYS */;
/*!40000 ALTER TABLE `videos_producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'capa'
--

--
-- Dumping routines for database 'capa'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-14 17:42:01
