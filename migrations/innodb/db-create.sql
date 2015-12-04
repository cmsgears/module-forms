--
-- Table structure for table `cmg_form_submit`
--

DROP TABLE IF EXISTS `cmg_form_submit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmg_form_submit` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `formId` bigint(20) NOT NULL,
  `submittedBy` bigint(20) DEFAULT NULL,
  `submittedAt` datetime DEFAULT NULL,
  `data` mediumtext COLLATE utf8_unicode_ci,
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
  `formSubmitId` bigint(20) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  KEY `fk_form_submit_field_1` (`formSubmitId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;


SET FOREIGN_KEY_CHECKS=0;

--
-- Constraints for table `cmg_form_submit`
--
ALTER TABLE `cmg_form_submit`
  	ADD CONSTRAINT `fk_form_submit_1` FOREIGN KEY (`formId`) REFERENCES `cmg_core_form` (`id`),
  	ADD CONSTRAINT `fk_form_submit_2` FOREIGN KEY (`submittedBy`) REFERENCES `cmg_core_user` (`id`);

--
-- Constraints for table `cmg_form_submit_field`
--
ALTER TABLE `cmg_form_submit_field`
  	ADD CONSTRAINT `fk_form_submit_field_1` FOREIGN KEY (`formSubmitId`) REFERENCES `cmg_form_submit` (`id`);

SET FOREIGN_KEY_CHECKS=1;