--
-- Dumping data for table `cmg_core_role`
--

INSERT INTO `cmg_core_role` VALUES 
	(1551,1,1,'Form Manager','form-manager','The role Form Manager is limited to manage forms from admin.','dashboard','system',NULL,'2014-10-11 14:22:54','2014-10-11 14:22:54');

--
-- Dumping data for table `cmg_core_permission`
--

INSERT INTO `cmg_core_permission` VALUES 
	(1551,1,1,'Form','form','The permission form is to manage forms from admin.','system',null,'2014-10-11 14:22:54','2014-10-11 14:22:54');

--
-- Dumping data for table `cmg_core_role_permission`
--

INSERT INTO `cmg_core_role_permission` VALUES 
	(1,1551),
	(2,1551),
	(1551,1551);

--
-- Dumping data for table `cmg_form`
--

INSERT INTO `cmg_form` VALUES 
	(1,NULL,1,1,'contact','contact form','Thanks for contacting us. We will contact you within next 48 hrs.',1,1,0,0,1,NULL,'2014-10-11 14:22:54','2014-10-11 14:22:54'),
	(2,NULL,1,1,'feedback','feedback form','Thanks for providing your valuable feedback.',0,1,1,0,1,NULL,'2014-10-11 14:22:54','2014-10-11 14:22:54');

--
-- Dumping data for table `cmg_form_field`
--

INSERT INTO `cmg_form_field` VALUES 
	(1,1,'name',1,NULL,NULL),(2,1,'email',1,NULL,NULL),(3,1,'subject',1,NULL,NULL),(4,1,'message',5,NULL,NULL),
	(5,2,'name',1,NULL,NULL),(6,2,'email',1,NULL,NULL),(7,2,'rating',25,NULL,NULL),(8,2,'message',5,NULL,NULL);