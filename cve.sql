-- MySQL dump 10.16  Distrib 10.1.37-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: cve
-- ------------------------------------------------------
-- Server version	10.1.37-MariaDB

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
-- Table structure for table `baseImages`
--

DROP TABLE IF EXISTS `baseImages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `baseImages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `server_id` int(11) NOT NULL COMMENT '服务器id',
  `type` int(11) NOT NULL COMMENT '文件系统类型',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'create time',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT 'update time',
  `status` tinyint(4) NOT NULL COMMENT '镜像状态',
  `absPath` varchar(255) NOT NULL COMMENT '绝对路径',
  PRIMARY KEY (`id`),
  KEY `server_id` (`server_id`),
  KEY `id` (`id`),
  KEY `id_2` (`id`),
  KEY `server_id_2` (`server_id`),
  KEY `type` (`type`),
  KEY `server_id_3` (`server_id`),
  CONSTRAINT `baseImages_ibfk_1` FOREIGN KEY (`server_id`) REFERENCES `servers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='base images table';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cnvds`
--

DROP TABLE IF EXISTS `cnvds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cnvds` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cnvd_id` char(20) COLLATE utf8_unicode_ci NOT NULL,
  `cnvd_serverity` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `cnvd_title` text COLLATE utf8_unicode_ci NOT NULL,
  `cnvd_products` text COLLATE utf8_unicode_ci NOT NULL,
  `cnvd_formalWay` text COLLATE utf8_unicode_ci NOT NULL,
  `cnvd_description` text COLLATE utf8_unicode_ci NOT NULL,
  `cnvd_patch` text COLLATE utf8_unicode_ci NOT NULL,
  `cnvd_submitTime` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `cnvds_cnvd_id_index` (`cnvd_id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cves`
--

DROP TABLE IF EXISTS `cves`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cves` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cve_id` char(20) COLLATE utf8_unicode_ci NOT NULL,
  `cve_status` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `cve_description` text COLLATE utf8_unicode_ci NOT NULL,
  `cve_references` text COLLATE utf8_unicode_ci NOT NULL,
  `cve_phase` text COLLATE utf8_unicode_ci NOT NULL,
  `cve_votes` text COLLATE utf8_unicode_ci NOT NULL,
  `cve_comments` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `cves_cve_id_index` (`cve_id`)
) ENGINE=InnoDB AUTO_INCREMENT=145583 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dataBase`
--

DROP TABLE IF EXISTS `dataBase`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dataBase` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `fileRestore`
--

DROP TABLE IF EXISTS `fileRestore`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fileRestore` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fileId` int(11) NOT NULL COMMENT '文件id',
  `restoreStatus` int(1) NOT NULL COMMENT '还原状态',
  `restoreReason` int(1) NOT NULL COMMENT '还原原因',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `fileId` (`fileId`),
  CONSTRAINT `fileRestore_ibfk_1` FOREIGN KEY (`fileId`) REFERENCES `files` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `fileRestoreRecord`
--

DROP TABLE IF EXISTS `fileRestoreRecord`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fileRestoreRecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fileId` int(11) NOT NULL COMMENT '文件id',
  `restoreReason` int(1) NOT NULL COMMENT '还原原因',
  `restoreType` int(1) NOT NULL COMMENT '还原方式',
  `result` int(1) NOT NULL COMMENT '还原结果',
  `message` int(1) NOT NULL DEFAULT '0' COMMENT '还原信息是否查看',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `fileId` (`fileId`),
  CONSTRAINT `fileRestoreRecord_ibfk_1` FOREIGN KEY (`fileId`) REFERENCES `files` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `fileScanRecord`
--

DROP TABLE IF EXISTS `fileScanRecord`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fileScanRecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `overlayId` int(11) NOT NULL,
  `allFiles` int(11) NOT NULL,
  `overlayFiles` int(11) NOT NULL,
  `scanTime` int(5) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `overlayId` (`overlayId`),
  CONSTRAINT `fileScanRecord_ibfk_1` FOREIGN KEY (`overlayId`) REFERENCES `overlays` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `overlayId` int(11) NOT NULL,
  `absPath` varchar(255) NOT NULL,
  `inode` int(11) NOT NULL,
  `mode` int(11) NOT NULL COMMENT '文件类型',
  `size` int(11) NOT NULL,
  `firstAddFlag` tinyint(4) NOT NULL DEFAULT '0' COMMENT '首次监控标志',
  `hash` varchar(64) NOT NULL COMMENT '特征值',
  `isModified` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否被修改',
  `lost` int(1) NOT NULL DEFAULT '0' COMMENT '文件丢失',
  `restore` tinyint(1) NOT NULL COMMENT '还原状态',
  `createTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '文件创建时间',
  `accessTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modifyTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleteTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `inodePosition` tinyint(4) NOT NULL DEFAULT '0',
  `dataPosition` tinyint(4) NOT NULL DEFAULT '0',
  `baseHas` int(1) NOT NULL COMMENT '原始镜像中有此文件',
  `beforeInode` int(11) NOT NULL,
  `isdelete` tinyint(4) NOT NULL COMMENT '是否删除',
  `status` int(11) NOT NULL COMMENT '文件状态',
  `beforeSize` int(11) NOT NULL,
  `beforeCreateTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `beforeAccessTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `beforeModifyTime` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `overlayId` (`overlayId`),
  CONSTRAINT `files_ibfk_1` FOREIGN KEY (`overlayId`) REFERENCES `overlays` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='监控文件信息';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `filesystemType`
--

DROP TABLE IF EXISTS `filesystemType`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `filesystemType` (
  `name` varchar(10) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  CONSTRAINT `filesystemType_ibfk_1` FOREIGN KEY (`id`) REFERENCES `baseImages` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `overlays`
--

DROP TABLE IF EXISTS `overlays`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `overlays` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `baseImageId` int(11) NOT NULL,
  `name` varchar(255) NOT NULL COMMENT '镜像名称',
  `status` tinyint(4) NOT NULL COMMENT '镜像状态',
  `scan` int(1) NOT NULL DEFAULT '0',
  `backupPath` varchar(255) NOT NULL COMMENT '在主机中的备份文件夹',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'create time',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `absPath` varchar(255) NOT NULL COMMENT '绝对路径',
  PRIMARY KEY (`id`),
  KEY `base_image_index` (`baseImageId`),
  KEY `id` (`id`),
  KEY `baseImageId` (`baseImageId`),
  CONSTRAINT `overlays_ibfk_1` FOREIGN KEY (`baseImageId`) REFERENCES `baseImages` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='增量镜像表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `servers`
--

DROP TABLE IF EXISTS `servers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `servers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `serverNumber` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `IP` char(15) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `backupRoot` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '备份根目录',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `id_2` (`id`),
  KEY `serverNumber` (`serverNumber`),
  KEY `serverNumber_2` (`serverNumber`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(1) NOT NULL DEFAULT '1' COMMENT '用户类型',
  `status` smallint(1) NOT NULL COMMENT '状态',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `virus`
--

DROP TABLE IF EXISTS `virus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `virus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `code` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `virusKill`
--

DROP TABLE IF EXISTS `virusKill`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `virusKill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `overlayId` int(11) NOT NULL,
  `virusId` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `overlayId` (`overlayId`),
  KEY `virusId` (`virusId`),
  CONSTRAINT `virusKill_ibfk_1` FOREIGN KEY (`virusId`) REFERENCES `virus` (`id`),
  CONSTRAINT `virusKill_ibfk_2` FOREIGN KEY (`overlayId`) REFERENCES `overlays` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-02-15  8:36:32
