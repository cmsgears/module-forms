<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\core\common\base\Migration;

use cmsgears\core\common\models\entities\Site;
use cmsgears\core\common\models\entities\User;
use cmsgears\core\common\models\entities\Role;
use cmsgears\core\common\models\entities\Permission;

use cmsgears\core\common\utilities\DateUtil;

/**
 * The form data migration inserts the base data required to run the application.
 *
 * @since 1.0.0
 */
class m160622_120639_form_data extends Migration {

	// Public Variables

	// Private Variables

	private $prefix;

	private $site;

	private $master;

	public function init() {

		// Table prefix
		$this->prefix	= Yii::$app->migration->cmgPrefix;

		$this->site		= Site::findBySlug( CoreGlobal::SITE_MAIN );
		$this->master	= User::findByUsername( Yii::$app->migration->getSiteMaster() );

		Yii::$app->core->setSite( $this->site );
	}

    public function up() {

		// Create RBAC and Site Members
		$this->insertRolePermission();

		// Create form permission groups and CRUD permissions
		$this->insertFormPermissions();
    }

	private function insertRolePermission() {

		// Roles

		$columns = [ 'createdBy', 'modifiedBy', 'name', 'slug', 'adminUrl', 'homeUrl', 'type', 'icon', 'description', 'createdAt', 'modifiedAt' ];

		$roles = [
			[ $this->master->id, $this->master->id, 'Form Admin', 'form-admin', 'dashboard', NULL, CoreGlobal::TYPE_SYSTEM, NULL, 'The role Form Admin is limited to manage forms from admin.', DateUtil::getDateTime(), DateUtil::getDateTime() ]
		];

		$this->batchInsert( $this->prefix . 'core_role', $columns, $roles );

		$superAdminRole		= Role::findBySlugType( 'super-admin', CoreGlobal::TYPE_SYSTEM );
		$adminRole			= Role::findBySlugType( 'admin', CoreGlobal::TYPE_SYSTEM );
		$formAdminRole		= Role::findBySlugType( 'form-admin', CoreGlobal::TYPE_SYSTEM );

		// Permissions

		$columns = [ 'createdBy', 'modifiedBy', 'name', 'slug', 'type', 'icon', 'description', 'createdAt', 'modifiedAt' ];

		$permissions = [
			[ $this->master->id, $this->master->id, 'Admin Forms', 'admin-forms', CoreGlobal::TYPE_SYSTEM, null, 'The permission admin forms is to manage forms from admin.', DateUtil::getDateTime(), DateUtil::getDateTime() ]
		];

		$this->batchInsert( $this->prefix . 'core_permission', $columns, $permissions );

		$adminPerm			= Permission::findBySlugType( 'admin', CoreGlobal::TYPE_SYSTEM );
		$userPerm			= Permission::findBySlugType( 'user', CoreGlobal::TYPE_SYSTEM );
		$formAdminPerm		= Permission::findBySlugType( 'admin-forms', CoreGlobal::TYPE_SYSTEM );

		// RBAC Mapping

		$columns = [ 'roleId', 'permissionId' ];

		$mappings = [
			[ $superAdminRole->id, $formAdminPerm->id ],
			[ $adminRole->id, $formAdminPerm->id ],
			[ $formAdminRole->id, $adminPerm->id ], [ $formAdminRole->id, $userPerm->id ], [ $formAdminRole->id, $formAdminPerm->id ]
		];

		$this->batchInsert( $this->prefix . 'core_role_permission', $columns, $mappings );
	}

	private function insertFormPermissions() {

		// Permissions
		$columns = [ 'createdBy', 'modifiedBy', 'name', 'slug', 'type', 'icon', 'group', 'description', 'createdAt', 'modifiedAt' ];

		$permissions = [
			// Permission Groups - Default - Website - Individual, Organization
			[ $this->master->id, $this->master->id, 'Manage Forms', 'manage-forms', CoreGlobal::TYPE_SYSTEM, NULL, true, 'The permission manage forms allows user to manage forms from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Form Author', 'form-author', CoreGlobal::TYPE_SYSTEM, NULL, true, 'The permission form author allows user to perform crud operations of form belonging to respective author from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],

			// Form Permissions - Hard Coded - Website - Individual, Organization
			[ $this->master->id, $this->master->id, 'View Forms', 'view-forms', CoreGlobal::TYPE_SYSTEM, NULL, false, 'The permission view forms allows users to view their forms from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Add Form', 'add-form', CoreGlobal::TYPE_SYSTEM, NULL, false, 'The permission add form allows users to create form from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Update Form', 'update-form', CoreGlobal::TYPE_SYSTEM, NULL, false, 'The permission update form allows users to update form from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Delete Form', 'delete-form', CoreGlobal::TYPE_SYSTEM, NULL, false, 'The permission delete form allows users to delete form from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Approve Form', 'approve-form', CoreGlobal::TYPE_SYSTEM, NULL, false, 'The permission approve form allows user to approve, freeze or block form from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Print Form', 'print-form', CoreGlobal::TYPE_SYSTEM, NULL, false, 'The permission print form allows user to print form from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Import Forms', 'import-forms', CoreGlobal::TYPE_SYSTEM, NULL, false, 'The permission import forms allows user to import forms from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Export Forms', 'export-forms', CoreGlobal::TYPE_SYSTEM, NULL, false, 'The permission export forms allows user to export forms from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ]
		];

		$this->batchInsert( $this->prefix . 'core_permission', $columns, $permissions );

		// Permission Groups
		$formManagerPerm	= Permission::findBySlugType( 'manage-forms', CoreGlobal::TYPE_SYSTEM );
		$formAuthorPerm		= Permission::findBySlugType( 'form-author', CoreGlobal::TYPE_SYSTEM );

		// Permissions
		$vFormsPerm		= Permission::findBySlugType( 'view-forms', CoreGlobal::TYPE_SYSTEM );
		$aFormPerm		= Permission::findBySlugType( 'add-form', CoreGlobal::TYPE_SYSTEM );
		$uFormPerm		= Permission::findBySlugType( 'update-form', CoreGlobal::TYPE_SYSTEM );
		$dFormPerm		= Permission::findBySlugType( 'delete-form', CoreGlobal::TYPE_SYSTEM );
		$apFormPerm		= Permission::findBySlugType( 'approve-form', CoreGlobal::TYPE_SYSTEM );
		$pFormPerm		= Permission::findBySlugType( 'print-form', CoreGlobal::TYPE_SYSTEM );
		$iFormsPerm		= Permission::findBySlugType( 'import-forms', CoreGlobal::TYPE_SYSTEM );
		$eFormsPerm		= Permission::findBySlugType( 'export-forms', CoreGlobal::TYPE_SYSTEM );

		//Hierarchy

		$columns = [ 'parentId', 'childId', 'rootId', 'parentType', 'lValue', 'rValue' ];

		$hierarchy = [
			// Form Manager - Organization, Approver
			[ null, null, $formManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 1, 18 ],
			[ $formManagerPerm->id, $vFormsPerm->id, $formManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 2, 3 ],
			[ $formManagerPerm->id, $aFormPerm->id, $formManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 4, 5 ],
			[ $formManagerPerm->id, $uFormPerm->id, $formManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 6, 7 ],
			[ $formManagerPerm->id, $dFormPerm->id, $formManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 8, 9 ],
			[ $formManagerPerm->id, $apFormPerm->id, $formManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 10, 11 ],
			[ $formManagerPerm->id, $pFormPerm->id, $formManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 12, 13 ],
			[ $formManagerPerm->id, $iFormsPerm->id, $formManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 14, 15 ],
			[ $formManagerPerm->id, $eFormsPerm->id, $formManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 16, 17 ],

			// Form Author- Individual
			[ null, null, $formAuthorPerm->id, CoreGlobal::TYPE_PERMISSION, 1, 16 ],
			[ $formAuthorPerm->id, $vFormsPerm->id, $formAuthorPerm->id, CoreGlobal::TYPE_PERMISSION, 2, 3 ],
			[ $formAuthorPerm->id, $aFormPerm->id, $formAuthorPerm->id, CoreGlobal::TYPE_PERMISSION, 4, 5 ],
			[ $formAuthorPerm->id, $uFormPerm->id, $formAuthorPerm->id, CoreGlobal::TYPE_PERMISSION, 6, 7 ],
			[ $formAuthorPerm->id, $dFormPerm->id, $formAuthorPerm->id, CoreGlobal::TYPE_PERMISSION, 8, 9 ],
			[ $formAuthorPerm->id, $pFormPerm->id, $formAuthorPerm->id, CoreGlobal::TYPE_PERMISSION, 10, 11 ],
			[ $formAuthorPerm->id, $iFormsPerm->id, $formAuthorPerm->id, CoreGlobal::TYPE_PERMISSION, 12, 13 ],
			[ $formAuthorPerm->id, $eFormsPerm->id, $formAuthorPerm->id, CoreGlobal::TYPE_PERMISSION, 14, 15 ]
		];

		$this->batchInsert( $this->prefix . 'core_model_hierarchy', $columns, $hierarchy );
	}

    public function down() {

        echo "m160622_120639_form_data will be deleted with m160622_014408_core.\n";

        return true;
    }

}
