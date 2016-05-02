--
-- Form module roles and permissions
--

INSERT INTO `cmg_core_role` (`createdBy`,`modifiedBy`,`name`,`slug`,`homeUrl`,`type`,`description`,`icon`,`createdAt`,`modifiedAt`) VALUES 
	(1,1,'Form Manager','form-manager','dashboard','system','The role Form Manager is limited to manage forms from admin.',NULL,'2014-10-11 14:22:54','2014-10-11 14:22:54');

SELECT @rolesadmin := `id` FROM cmg_core_role WHERE slug = 'super-admin';
SELECT @roleadmin := `id` FROM cmg_core_role WHERE slug = 'admin';
SELECT @roleform := `id` FROM cmg_core_role WHERE slug = 'form-manager';

INSERT INTO `cmg_core_permission` (`createdBy`,`modifiedBy`,`name`,`slug`,`type`,`description`,`icon`,`createdAt`,`modifiedAt`) VALUES 
	(1,1,'Form','form','system','The permission form is to manage forms from admin.',NULL,'2014-10-11 14:22:54','2014-10-11 14:22:54');

SELECT @permadmin := `id` FROM cmg_core_permission WHERE slug = 'admin';
SELECT @permuser := `id` FROM cmg_core_permission WHERE slug = 'user';
SELECT @permform := `id` FROM cmg_core_permission WHERE slug = 'form';

INSERT INTO `cmg_core_role_permission` VALUES 
	(@rolesadmin,@permform),
	(@roleadmin,@permform),
	(@roleform,@permadmin),(@roleform,@permuser),(@roleform,@permform);