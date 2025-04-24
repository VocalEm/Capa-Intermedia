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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
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
-- Table structure for table `imagenes_producto`
--

DROP TABLE IF EXISTS `imagenes_producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `imagenes_producto` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `RUTA_IMAGEN` varchar(255) NOT NULL,
  `ID_PRODUCTO` int NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_PRODUCTO` (`ID_PRODUCTO`),
  CONSTRAINT `imagenes_producto_ibfk_1` FOREIGN KEY (`ID_PRODUCTO`) REFERENCES `producto` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imagenes_producto`
--

LOCK TABLES `imagenes_producto` WRITE;
/*!40000 ALTER TABLE `imagenes_producto` DISABLE KEYS */;
/*!40000 ALTER TABLE `imagenes_producto` ENABLE KEYS */;
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
  PRIMARY KEY (`ID`),
  KEY `ID_VENDEDOR` (`ID_VENDEDOR`),
  KEY `ID_ADMIN_AUTORIZADOR` (`ID_ADMIN_AUTORIZADOR`),
  CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`ID_VENDEDOR`) REFERENCES `usuario` (`ID`),
  CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`ID_ADMIN_AUTORIZADOR`) REFERENCES `usuario` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto`
--

LOCK TABLES `producto` WRITE;
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto_categoria`
--

LOCK TABLES `producto_categoria` WRITE;
/*!40000 ALTER TABLE `producto_categoria` DISABLE KEYS */;
/*!40000 ALTER TABLE `producto_categoria` ENABLE KEYS */;
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
  `PRIVACIDAD` tinyint(1) DEFAULT '1', /* 1 es publico y 0 privado*/
  `ES_SUPERADMIN` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `CORREO` (`CORREO`),
  UNIQUE KEY `USERNAME` (`USERNAME`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
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
-- Table structure for table `wishlist`
--

DROP TABLE IF EXISTS `wishlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wishlist` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(100) NOT NULL,
  `DESCRIPCION` text,
  `PRIVADA` tinyint(1) DEFAULT '0',
  `ID_USUARIO` int NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_USUARIO` (`ID_USUARIO`),
  CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`ID_USUARIO`) REFERENCES `usuario` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wishlist`
--

LOCK TABLES `wishlist` WRITE;
/*!40000 ALTER TABLE `wishlist` DISABLE KEYS */;
/*!40000 ALTER TABLE `wishlist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wishlist_producto`
--

DROP TABLE IF EXISTS `wishlist_producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wishlist_producto` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ID_WISHLIST` int NOT NULL,
  `ID_PRODUCTO` int NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_WISHLIST` (`ID_WISHLIST`),
  KEY `ID_PRODUCTO` (`ID_PRODUCTO`),
  CONSTRAINT `wishlist_producto_ibfk_1` FOREIGN KEY (`ID_WISHLIST`) REFERENCES `wishlist` (`ID`),
  CONSTRAINT `wishlist_producto_ibfk_2` FOREIGN KEY (`ID_PRODUCTO`) REFERENCES `producto` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wishlist_producto`
--

LOCK TABLES `wishlist_producto` WRITE;
/*!40000 ALTER TABLE `wishlist_producto` DISABLE KEYS */;
/*!40000 ALTER TABLE `wishlist_producto` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-24 12:29:58
