--
-- Table structure for table `cmg_form`
--

DROP TABLE IF EXISTS `cmg_form`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_form` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `templateId` bigint(20) DEFAULT NULL,
  `createdBy` bigint(20) NOT NULL,
  `modifiedBy` bigint(20) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `successMessage` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jsonStorage` tinyint(1) DEFAULT 0,
  `captcha` tinyint(1) DEFAULT 0,
  `visibility` tinyint(1) DEFAULT 0,
  `userMail` tinyint(1) DEFAULT 0,
  `adminMail` tinyint(1) DEFAULT 0,
  `options` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `createdAt` datetime NOT NULL,
  `modifiedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_form_1` (`templateId`),
  KEY `fk_form_2` (`createdBy`),
  KEY `fk_form_3` (`modifiedBy`)
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
  `formId` bigint(20) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` smallint(6) DEFAULT NULL,
  `options` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_form_field_1` (`formId`)
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
  `formId` bigint(20) NOT NULL,
  `jsonStorage` tinyint(1) DEFAULT 0,
  `submittedBy` bigint(20) DEFAULT NULL,
  `submittedAt` datetime DEFAULT NULL,
  `data` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_form_submit_1` (`formId`),
  KEY `fk_form_submit_2` (`submittedBy`)
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
  KEY `fk_form_submit_field_1` (`parentId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;


SET FOREIGN_KEY_CHECKS=0;

--
-- Constraints for table `cmg_form`
--
ALTER TABLE `cmg_form`
	ADD CONSTRAINT `fk_form_1` FOREIGN KEY (`templateId`) REFERENCES `cmg_core_template` (`id`),
	ADD CONSTRAINT `fk_form_2` FOREIGN KEY (`createdBy`) REFERENCES `cmg_core_user` (`id`),
  	ADD CONSTRAINT `fk_form_3` FOREIGN KEY (`modifiedBy`) REFERENCES `cmg_core_user` (`id`);

--
-- Constraints for table `cmg_form_field`
--
ALTER TABLE `cmg_form_field`
	ADD CONSTRAINT `fk_form_field_1` FOREIGN KEY (`formId`) REFERENCES `cmg_form` (`id`);

--
-- Constraints for table `cmg_form_submit`
--
ALTER TABLE `cmg_form_submit`
  	ADD CONSTRAINT `fk_form_submit_1` FOREIGN KEY (`formId`) REFERENCES `cmg_form` (`id`),
  	ADD CONSTRAINT `fk_form_submit_2` FOREIGN KEY (`submittedBy`) REFERENCES `cmg_core_user` (`id`);

--
-- Constraints for table `cmg_form_submit_field`
--
ALTER TABLE `cmg_form_submit_field`
  	ADD CONSTRAINT `fk_form_submit_field_1` FOREIGN KEY (`parentId`) REFERENCES `cmg_form_submit` (`id`);

SET FOREIGN_KEY_CHECKS=1;