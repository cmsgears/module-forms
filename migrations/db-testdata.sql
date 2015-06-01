--
-- Dumping data for table `cmg_form`
--

INSERT INTO `cmg_form` VALUES 
	(1,'contact','contact form','contact form'),
	(2,'feedback','feedback form','feedback form');
	
--
-- Dumping data for table `cmg_form_field`
--

INSERT INTO `cmg_form_field` VALUES 
	(1,1,'name',1,NULL),(2,1,'email',1,NULL),(3,1,'subject',1,NULL),(4,1,'message',2,NULL),
	(5,2,'name',1,NULL),(6,2,'email',1,NULL),(7,2,'rating',1,NULL),(8,2,'message',2,NULL);