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
  `ID_PRODUCTO` int DEFAULT NULL,
  `ID_USUARIO` int DEFAULT NULL,
  `CANTIDAD` int DEFAULT NULL,
  `ELIMINADO` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `ID_PRODUCTO` (`ID_PRODUCTO`),
  KEY `ID_USUARIO` (`ID_USUARIO`),
  CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`ID_PRODUCTO`) REFERENCES `productos` (`ID`) ON DELETE CASCADE,
  CONSTRAINT `carrito_ibfk_2` FOREIGN KEY (`ID_USUARIO`) REFERENCES `usuario` (`ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorias` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `TITULO` varchar(50) NOT NULL,
  `DESCRIPCION` text,
  `CREADOR` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `chat`
--

DROP TABLE IF EXISTS `chat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chat` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ID_COMPRADOR` int DEFAULT NULL,
  `ID_VENDEDOR` int DEFAULT NULL,
  `FECHA_CREACION` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  KEY `ID_COMPRADOR` (`ID_COMPRADOR`),
  KEY `ID_VENDEDOR` (`ID_VENDEDOR`),
  CONSTRAINT `chat_ibfk_1` FOREIGN KEY (`ID_COMPRADOR`) REFERENCES `usuario` (`ID`) ON DELETE CASCADE,
  CONSTRAINT `chat_ibfk_2` FOREIGN KEY (`ID_VENDEDOR`) REFERENCES `usuario` (`ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `chat_detalle`
--

DROP TABLE IF EXISTS `chat_detalle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chat_detalle` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `MENSAJE` text,
  `FECHA_CREACION` datetime DEFAULT CURRENT_TIMESTAMP,
  `ID_USUARIO` int DEFAULT NULL,
  `ID_CHAT` int DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_USUARIO` (`ID_USUARIO`),
  KEY `ID_CHAT` (`ID_CHAT`),
  CONSTRAINT `chat_detalle_ibfk_1` FOREIGN KEY (`ID_USUARIO`) REFERENCES `usuario` (`ID`) ON DELETE CASCADE,
  CONSTRAINT `chat_detalle_ibfk_2` FOREIGN KEY (`ID_CHAT`) REFERENCES `chat` (`ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `comentarios`
--

DROP TABLE IF EXISTS `comentarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comentarios` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` text,
  `ID_USUARIO` int DEFAULT NULL,
  `ID_PRODUCTO` int DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_USUARIO` (`ID_USUARIO`),
  KEY `ID_PRODUCTO` (`ID_PRODUCTO`),
  CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`ID_USUARIO`) REFERENCES `usuario` (`ID`) ON DELETE CASCADE,
  CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`ID_PRODUCTO`) REFERENCES `productos` (`ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `multimedia`
--

DROP TABLE IF EXISTS `multimedia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `multimedia` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `RUTA_IMAGEN` varchar(255) DEFAULT NULL,
  `RUTA_VIDEO` varchar(255) DEFAULT NULL,
  `ID_PRODUCTO` int DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_PRODUCTO` (`ID_PRODUCTO`),
  CONSTRAINT `multimedia_ibfk_1` FOREIGN KEY (`ID_PRODUCTO`) REFERENCES `productos` (`ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(50) NOT NULL,
  `DESCRIPCION` text,
  `ID_CATEGORIA` int DEFAULT NULL,
  `COTIZAR_VENDER` tinyint(1) DEFAULT NULL,
  `PRECIO` decimal(10,2) DEFAULT NULL,
  `STOCK` int DEFAULT NULL,
  `AUTORIZADO` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_CATEGORIA` (`ID_CATEGORIA`),
  CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`ID_CATEGORIA`) REFERENCES `categorias` (`ID`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  `SEXO` tinyint(1) DEFAULT NULL,
  `CORREO` varchar(80) NOT NULL,
  `USERNAME` varchar(50) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `TIPO_USUARIO` tinyint DEFAULT NULL,
  `IMAGEN` varchar(255) DEFAULT NULL,
  `FECHA_NACIMIENTO` date DEFAULT NULL,
  `FECHA_REGISTRO` datetime DEFAULT CURRENT_TIMESTAMP,
  `PRIVACIDAD` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `CORREO` (`CORREO`),
  UNIQUE KEY `USERNAME` (`USERNAME`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `valoracion`
--

DROP TABLE IF EXISTS `valoracion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `valoracion` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ID_USUARIO` int DEFAULT NULL,
  `PUNTUACION` decimal(3,2) DEFAULT NULL,
  `ID_PRODUCTO` int DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_USUARIO` (`ID_USUARIO`),
  KEY `ID_PRODUCTO` (`ID_PRODUCTO`),
  CONSTRAINT `valoracion_ibfk_1` FOREIGN KEY (`ID_USUARIO`) REFERENCES `usuario` (`ID`) ON DELETE CASCADE,
  CONSTRAINT `valoracion_ibfk_2` FOREIGN KEY (`ID_PRODUCTO`) REFERENCES `productos` (`ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `venta`
--

DROP TABLE IF EXISTS `venta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `venta` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ID_USUARIO` int DEFAULT NULL,
  `TOTAL` decimal(10,2) DEFAULT NULL,
  `FECHA_VENTA` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `SUBTOTAL` decimal(10,2) DEFAULT NULL,
  `IVA` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_USUARIO` (`ID_USUARIO`),
  CONSTRAINT `venta_ibfk_1` FOREIGN KEY (`ID_USUARIO`) REFERENCES `usuario` (`ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `venta_detalle`
--

DROP TABLE IF EXISTS `venta_detalle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `venta_detalle` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ID_VENTA` int DEFAULT NULL,
  `ID_PRODUCTO` int DEFAULT NULL,
  `CANTIDAD` int DEFAULT NULL,
  `IMPORTE` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_VENTA` (`ID_VENTA`),
  KEY `ID_PRODUCTO` (`ID_PRODUCTO`),
  CONSTRAINT `venta_detalle_ibfk_1` FOREIGN KEY (`ID_VENTA`) REFERENCES `venta` (`ID`) ON DELETE CASCADE,
  CONSTRAINT `venta_detalle_ibfk_2` FOREIGN KEY (`ID_PRODUCTO`) REFERENCES `productos` (`ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wishlist`
--

DROP TABLE IF EXISTS `wishlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wishlist` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(50) DEFAULT NULL,
  `DESCRIPCION` text,
  `ID_USUARIO` int DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_USUARIO` (`ID_USUARIO`),
  CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`ID_USUARIO`) REFERENCES `usuario` (`ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wishlist_detalle`
--

DROP TABLE IF EXISTS `wishlist_detalle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wishlist_detalle` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `ID_ARTICULO` int DEFAULT NULL,
  `ID_WISHLIST` int DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID_WISHLIST` (`ID_WISHLIST`),
  CONSTRAINT `wishlist_detalle_ibfk_1` FOREIGN KEY (`ID_WISHLIST`) REFERENCES `wishlist` (`ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping routines for database 'capa'
--
/*!50003 DROP PROCEDURE IF EXISTS `ManageUser` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`Emiliano`@`%` PROCEDURE `ManageUser`(
    IN p_option VARCHAR(10),
    IN p_id INT,
    IN p_nombre VARCHAR(50),
    IN p_apellido_p VARCHAR(50),
    IN p_apellido_m VARCHAR(50),
    IN p_sexo BOOLEAN,
    IN p_correo VARCHAR(80),
    IN p_username VARCHAR(50),
    IN p_password VARCHAR(255),
    IN p_tipo_usuario TINYINT,
    IN p_imagen VARCHAR(255),
    IN p_fecha_nacimiento DATE,
    IN p_privacidad BOOLEAN
)
BEGIN
    IF p_option = 'REGISTRAR' THEN
        INSERT INTO USUARIO (NOMBRE, APELLIDO_P, APELLIDO_M, SEXO, CORREO, USERNAME, PASSWORD, TIPO_USUARIO, IMAGEN, FECHA_NACIMIENTO, FECHA_REGISTRO, PRIVACIDAD)
        VALUES (p_nombre, p_apellido_p, p_apellido_m, p_sexo, p_correo, p_username, p_password, p_tipo_usuario, p_imagen, p_fecha_nacimiento, NOW(), p_privacidad);
    
    ELSEIF p_option = 'MODIFICAR' THEN
        UPDATE USUARIO 
        SET NOMBRE = p_nombre, APELLIDO_P = p_apellido_p, APELLIDO_M = p_apellido_m,
            SEXO = p_sexo, CORREO = p_correo, USERNAME = p_username, PASSWORD = p_password, 
            TIPO_USUARIO = p_tipo_usuario, IMAGEN = p_imagen, FECHA_NACIMIENTO = p_fecha_nacimiento,
            PRIVACIDAD = p_privacidad
        WHERE ID = p_id;
    
    ELSEIF p_option = 'ELIMINAR' THEN
        DELETE FROM USUARIO WHERE ID = p_id;
    
    ELSEIF p_option = 'LOGIN' THEN
        SELECT ID, NOMBRE, USERNAME, CORREO, TIPO_USUARIO 
        FROM USUARIO 
        WHERE (USERNAME = p_username OR CORREO = p_correo) AND PASSWORD = p_password;
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-02 14:48:34
