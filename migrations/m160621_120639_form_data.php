<?php
// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\core\common\models\entities\Site;
use cmsgears\core\common\models\entities\User;
use cmsgears\core\common\models\entities\Role;
use cmsgears\core\common\models\entities\Permission;
use cmsgears\core\common\models\resources\Form;
use cmsgears\core\common\models\resources\FormField;

use cmsgears\core\common\utilities\DateUtil;

class m160621_120639_form_data extends \yii\db\Migration {

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
			[ $this->master->id, $this->master->id, 'Form Manager', 'form-manager', 'dashboard', NULL, CoreGlobal::TYPE_SYSTEM, NULL, 'The role Form Manager is limited to manage forms from admin.', DateUtil::getDateTime(), DateUtil::getDateTime() ]
		];

		$this->batchInsert( $this->prefix . 'core_role', $columns, $roles );

		$superAdminRole		= Role::findBySlugType( 'super-admin', CoreGlobal::TYPE_SYSTEM );
		$adminRole			= Role::findBySlugType( 'admin', CoreGlobal::TYPE_SYSTEM );
		$formManagerRole	= Role::findBySlugType( 'form-manager', CoreGlobal::TYPE_SYSTEM );

		// Permissions

		$columns = [ 'createdBy', 'modifiedBy', 'name', 'slug', 'type', 'icon', 'description', 'createdAt', 'modifiedAt' ];

		$permissions = [
			[ $this->master->id, $this->master->id, 'Form', 'form', CoreGlobal::TYPE_SYSTEM, null, 'The permission form is to manage forms from admin.', DateUtil::getDateTime(), DateUtil::getDateTime() ]
		];

		$this->batchInsert( $this->prefix . 'core_permission', $columns, $permissions );

		$adminPerm			= Permission::findBySlugType( 'admin', CoreGlobal::TYPE_SYSTEM );
		$userPerm			= Permission::findBySlugType( 'user', CoreGlobal::TYPE_SYSTEM );
		$formPerm			= Permission::findBySlugType( 'form', CoreGlobal::TYPE_SYSTEM );

		// RBAC Mapping

		$columns = [ 'roleId', 'permissionId' ];

		$mappings = [
			[ $superAdminRole->id, $formPerm->id ],
			[ $adminRole->id, $formPerm->id ],
			[ $formManagerRole->id, $adminPerm->id ], [ $formManagerRole->id, $userPerm->id ], [ $formManagerRole->id, $formPerm->id ]
		];

		$this->batchInsert( $this->prefix . 'core_role_permission', $columns, $mappings );
	}

	private function insertFormPermissions() {

		// Permissions

		$columns = [ 'createdBy', 'modifiedBy', 'name', 'slug', 'type', 'icon', 'group', 'description', 'createdAt', 'modifiedAt' ];

		$permissions = [
			// Permission Groups
			[ $this->master->id, $this->master->id, 'Form Manager', 'form-manager', CoreGlobal::TYPE_SYSTEM, NULL, true, 'The permission Form Manager allows user to manage their forms from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],

			// System Permissions
			[ $this->master->id, $this->master->id, 'View Forms', 'view-forms', CoreGlobal::TYPE_SYSTEM, NULL, false, 'The permission view forms allows users to view their forms from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Add Form', 'add-form', CoreGlobal::TYPE_SYSTEM, NULL, false, 'The permission add form allows users to create form from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Update Form', 'update-form', CoreGlobal::TYPE_SYSTEM, NULL, false, 'The permission update form allows users to update form from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ],
			[ $this->master->id, $this->master->id, 'Delete Form', 'delete-form', CoreGlobal::TYPE_SYSTEM, NULL, false, 'The permission delete form allows users to delete form from website.', DateUtil::getDateTime(), DateUtil::getDateTime() ]
		];

		$this->batchInsert( $this->prefix . 'core_permission', $columns, $permissions );

		// Permission Groups
		$formManagerPerm	= Permission::findBySlugType( 'form-manager', CoreGlobal::TYPE_SYSTEM );

		// Permissions
		$viewPerm			= Permission::findBySlugType( 'view-forms', CoreGlobal::TYPE_SYSTEM );
		$addPerm			= Permission::findBySlugType( 'add-form', CoreGlobal::TYPE_SYSTEM );
		$updatePerm			= Permission::findBySlugType( 'update-form', CoreGlobal::TYPE_SYSTEM );
		$deletePerm			= Permission::findBySlugType( 'delete-form', CoreGlobal::TYPE_SYSTEM );

		//Hierarchy

		$columns = [ 'parentId', 'childId', 'rootId', 'parentType', 'lValue', 'rValue' ];

		$hierarchy = [
			// Org Admin Hierarchy
			[ null, null, $formManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 1, 10 ],
			[ $formManagerPerm->id, $viewPerm->id, $formManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 2, 9 ],
			[ $formManagerPerm->id, $addPerm->id, $formManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 3, 8 ],
			[ $formManagerPerm->id, $updatePerm->id, $formManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 4, 7 ],
			[ $formManagerPerm->id, $deletePerm->id, $formManagerPerm->id, CoreGlobal::TYPE_PERMISSION, 5, 6 ]
		];

		$this->batchInsert( $this->prefix . 'core_model_hierarchy', $columns, $hierarchy );
	}

    public function down() {

        echo "m160621_120639_form_data will be deleted with m160621_014408_core.\n";

        return true;
    }
}
