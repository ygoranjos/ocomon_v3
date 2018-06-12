-- MySQL dump 10.13  Distrib 5.7.17, for macos10.12 (x86_64)
--
-- Host: localhost    Database: simple_login
-- ------------------------------------------------------
-- Server version	5.6.38

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
-- Table structure for table `activity_log`
--

DROP TABLE IF EXISTS `activity_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_user_id` int(11) NOT NULL,
  `activity` text,
  `module` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`),
  UNIQUE KEY `log_id` (`log_id`),
  KEY `FK_activity_log_user_user_id` (`fk_user_id`),
  CONSTRAINT `FK_activity_log_user_user_id` FOREIGN KEY (`fk_user_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=5461;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_log`
--

LOCK TABLES `activity_log` WRITE;
/*!40000 ALTER TABLE `activity_log` DISABLE KEYS */;
INSERT INTO `activity_log` VALUES (1,1,'add new user user@gmail.com','User Management','2017-01-12 06:14:54'),(2,1,'update user user@gmail.com`s details (user@gmail.com to user@gmail.com, User 1 to User One,user to user)','User Management','2017-01-12 06:21:55');
/*!40000 ALTER TABLE `activity_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `areas`
--

DROP TABLE IF EXISTS `areas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `areas` (
  `id_area` int(11) NOT NULL AUTO_INCREMENT,
  `nome_area` varchar(45) NOT NULL,
  PRIMARY KEY (`id_area`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `areas`
--

LOCK TABLES `areas` WRITE;
/*!40000 ALTER TABLE `areas` DISABLE KEYS */;
INSERT INTO `areas` VALUES (1,'Suporte'),(2,'Infra');
/*!40000 ALTER TABLE `areas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chamados`
--

DROP TABLE IF EXISTS `chamados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chamados` (
  `id_chamado` int(11) NOT NULL AUTO_INCREMENT,
  `id_problema` int(11) NOT NULL DEFAULT '0',
  `descricao` text NOT NULL,
  `equipamento` int(6) DEFAULT NULL,
  `id_user` varchar(100) NOT NULL DEFAULT '',
  `contato` varchar(100) NOT NULL DEFAULT '',
  `telefone` varchar(40) DEFAULT NULL,
  `id_empresa` int(11) NOT NULL DEFAULT '0',
  `id_filial` int(11) NOT NULL DEFAULT '0',
  `id_departamento` int(11) NOT NULL DEFAULT '0',
  `id_user_operador` int(4) DEFAULT NULL,
  `data_abertura` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_fechamento` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `data_atendimento` datetime DEFAULT NULL,
  `id_area_atendimento` int(11) NOT NULL,
  PRIMARY KEY (`id_chamado`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chamados`
--

LOCK TABLES `chamados` WRITE;
/*!40000 ALTER TABLE `chamados` DISABLE KEYS */;
INSERT INTO `chamados` VALUES (1,1,'teste',2343,'1','Ygor','rwer',1,1,1,1,'2018-05-17 16:38:52',NULL,1,NULL,0);
/*!40000 ALTER TABLE `chamados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departamentos`
--

DROP TABLE IF EXISTS `departamentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departamentos` (
  `id_departamento` int(11) NOT NULL AUTO_INCREMENT,
  `id_filial` int(11) NOT NULL,
  `nome_departamento` varchar(100) NOT NULL,
  PRIMARY KEY (`id_departamento`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departamentos`
--

LOCK TABLES `departamentos` WRITE;
/*!40000 ALTER TABLE `departamentos` DISABLE KEYS */;
INSERT INTO `departamentos` VALUES (1,1,'Desenvolvimento');
/*!40000 ALTER TABLE `departamentos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empresas`
--

DROP TABLE IF EXISTS `empresas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `empresas` (
  `id_empresa` int(11) NOT NULL AUTO_INCREMENT,
  `nome_empresa` varchar(100) NOT NULL,
  PRIMARY KEY (`id_empresa`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empresas`
--

LOCK TABLES `empresas` WRITE;
/*!40000 ALTER TABLE `empresas` DISABLE KEYS */;
INSERT INTO `empresas` VALUES (1,'Ygor Anjos');
/*!40000 ALTER TABLE `empresas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `filiais`
--

DROP TABLE IF EXISTS `filiais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `filiais` (
  `id_filial` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` int(11) NOT NULL,
  `nome_filial` varchar(100) NOT NULL,
  PRIMARY KEY (`id_filial`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `filiais`
--

LOCK TABLES `filiais` WRITE;
/*!40000 ALTER TABLE `filiais` DISABLE KEYS */;
INSERT INTO `filiais` VALUES (1,1,'ygor Filial');
/*!40000 ALTER TABLE `filiais` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perfil`
--

DROP TABLE IF EXISTS `perfil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `perfil` (
  `id_perfil` int(11) NOT NULL AUTO_INCREMENT,
  `nome_perfil` varchar(45) NOT NULL,
  `permissao_empresas` varchar(100) NOT NULL DEFAULT 'all',
  `permissao_areas` varchar(100) NOT NULL DEFAULT 'all',
  PRIMARY KEY (`id_perfil`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perfil`
--

LOCK TABLES `perfil` WRITE;
/*!40000 ALTER TABLE `perfil` DISABLE KEYS */;
INSERT INTO `perfil` VALUES (1,'Padrão','all','all');
/*!40000 ALTER TABLE `perfil` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `problemas`
--

DROP TABLE IF EXISTS `problemas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `problemas` (
  `id_problema` int(11) NOT NULL AUTO_INCREMENT,
  `id_area` int(11) NOT NULL,
  `nome_problema` varchar(45) NOT NULL,
  PRIMARY KEY (`id_problema`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `problemas`
--

LOCK TABLES `problemas` WRITE;
/*!40000 ALTER TABLE `problemas` DISABLE KEYS */;
INSERT INTO `problemas` VALUES (1,1,'teste');
/*!40000 ALTER TABLE `problemas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status_chamado`
--

DROP TABLE IF EXISTS `status_chamado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status_chamado` (
  `id_status_chamado` int(11) NOT NULL AUTO_INCREMENT,
  `nome_status_chamado` varchar(100) NOT NULL,
  PRIMARY KEY (`id_status_chamado`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status_chamado`
--

LOCK TABLES `status_chamado` WRITE;
/*!40000 ALTER TABLE `status_chamado` DISABLE KEYS */;
INSERT INTO `status_chamado` VALUES (1,'Aberto'),(2,'Fechado'),(3,'Em Atendimento');
/*!40000 ALTER TABLE `status_chamado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sub_problemas`
--

DROP TABLE IF EXISTS `sub_problemas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sub_problemas` (
  `id_sub_problema` int(11) NOT NULL AUTO_INCREMENT,
  `id_problema` int(11) DEFAULT NULL,
  `nome_sub_problema` varchar(45) NOT NULL,
  PRIMARY KEY (`id_sub_problema`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sub_problemas`
--

LOCK TABLES `sub_problemas` WRITE;
/*!40000 ALTER TABLE `sub_problemas` DISABLE KEYS */;
INSERT INTO `sub_problemas` VALUES (1,1,'teste sub');
/*!40000 ALTER TABLE `sub_problemas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `role` varchar(25) NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `id_perfil` int(11) NOT NULL DEFAULT '1',
  `telefone` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=8192;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin@admin.com','f6fdffe48c908deb0f4c3bd36c032e72','Admin','admin',1,'2017-01-12 12:07:57','2018-05-17 22:02:27',1,'65465465'),(2,'user@gmail.com','f6fdffe48c908deb0f4c3bd36c032e72','User One','user',1,'2017-01-12 04:14:51','2017-01-12 06:23:26',1,NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-05-18  9:15:12
