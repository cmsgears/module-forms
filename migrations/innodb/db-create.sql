SET FOREIGN_KEY_CHECKS=0;

--
-- Table structure for table `cmg_form`
--

DROP TABLE IF EXISTS `cmg_form`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_form` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `successMessage` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmg_form_field`
--

DROP TABLE IF EXISTS `cmg_form_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_form_field` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `parentId` bigint(20) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` smallint(6) DEFAULT NULL,
  `meta` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_form_field_1` (`parentId`),
  CONSTRAINT `fk_form_field_1` FOREIGN KEY (`parentId`) REFERENCES `cmg_form` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmg_form_submit`
--

DROP TABLE IF EXISTS `cmg_form_submit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_form_submit` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `parentId` bigint(20) NOT NULL,
  `submittedBy` bigint(20) DEFAULT NULL,
  `submittedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_form_submit_1` (`parentId`),
  KEY `fk_form_submit_2` (`submittedBy`),
  CONSTRAINT `fk_form_submit_1` FOREIGN KEY (`parentId`) REFERENCES `cmg_form` (`id`),
  CONSTRAINT `fk_form_submit_2` FOREIGN KEY (`submittedBy`) REFERENCES `cmg_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmg_form_submit_field`
--

DROP TABLE IF EXISTS `cmg_form_submit_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_form_submit_field` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `parentId` bigint(20) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_form_submit_field_1` (`parentId`),
  CONSTRAINT `fk_form_submit_field_1` FOREIGN KEY (`parentId`) REFERENCES `cmg_form_submit` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;


SET FOREIGN_KEY_CHECKS=1;