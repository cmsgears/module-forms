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

	public $prefix;

	private $site;

	private $master;

	public function init() {

		$this->prefix		= 'cmg_';

		$this->site		= Site::findBySlug( CoreGlobal::SITE_MAIN );
		$this->master	= User::findByUsername( 'demomaster' );
	}

    public function up() {

		// Create RBAC and Site Members
		$this->insertRolePermission();
    }

	private function insertRolePermission() {

		// Roles

		$columns = [ 'createdBy', 'modifiedBy', 'name', 'slug', 'homeUrl', 'type', 'icon', 'description', 'createdAt', 'modifiedAt' ];

		$roles = [
			[ $this->master->id, $this->master->id, 'Form Manager', 'form-manager', 'dashboard', CoreGlobal::TYPE_SYSTEM, null, 'The role Form Manager is limited to manage forms from admin.', DateUtil::getDateTime(), DateUtil::getDateTime() ]
		];

		$this->batchInsert( $this->prefix . 'core_role', $columns, $roles );

		$superAdminRole		= Role::findBySlug( 'super-admin' );
		$adminRole			= Role::findBySlug( 'admin' );
		$formManagerRole	= Role::findBySlug( 'form-manager' );

		// Permissions

		$columns = [ 'createdBy', 'modifiedBy', 'name', 'slug', 'type', 'icon', 'description', 'createdAt', 'modifiedAt' ];

		$permissions = [
			[ $this->master->id, $this->master->id, 'Form', 'form', CoreGlobal::TYPE_SYSTEM, null, 'The permission form is to manage forms from admin.', DateUtil::getDateTime(), DateUtil::getDateTime() ]
		];

		$this->batchInsert( $this->prefix . 'core_permission', $columns, $permissions );

		$adminPerm			= Permission::findBySlug( 'admin' );
		$userPerm			= Permission::findBySlug( 'user' );
		$formPerm			= Permission::findBySlug( 'form' );

		// RBAC Mapping

		$columns = [ 'roleId', 'permissionId' ];

		$mappings = [
			[ $superAdminRole->id, $formPerm->id ],
			[ $adminRole->id, $formPerm->id ],
			[ $formManagerRole->id, $adminPerm->id ], [ $formManagerRole->id, $userPerm->id ], [ $formManagerRole->id, $formPerm->id ]
		];

		$this->batchInsert( $this->prefix . 'core_role_permission', $columns, $mappings );
	}

    public function down() {

        echo "m160621_120639_form_data will be deleted with m160621_014408_core.\n";

        return true;
    }
}
