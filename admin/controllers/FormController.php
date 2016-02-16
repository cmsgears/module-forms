<?php
namespace cmsgears\forms\admin\controllers;

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\forms\common\config\FormsGlobal;

class FormController extends \cmsgears\core\admin\controllers\base\FormController {

	// Constructor and Initialisation ------------------------------

 	public function __construct( $id, $module, $config = [] ) {

        parent::__construct( $id, $module, $config );

		$this->sidebar 	= [ 'parent' => 'sidebar-form', 'child' => 'form' ];

		$this->type		= CoreGlobal::TYPE_SITE;
	}

	// Instance Methods --------------------------------------------

	// yii\base\Component ----------------

    public function behaviors() {
		
		$behaviors	= parent::behaviors();
		
		$behaviors[ 'rbac' ][ 'actions' ] = [
								                'index'  => [ 'permission' => FormsGlobal::PERM_FORM ],
								                'all'  => [ 'permission' => FormsGlobal::PERM_FORM ],
								                'create'  => [ 'permission' => FormsGlobal::PERM_FORM ],
								                'update'  => [ 'permission' => FormsGlobal::PERM_FORM ],
								                'delete'  => [ 'permission' => FormsGlobal::PERM_FORM ]
							                ];
		
		return $behaviors;
    }

	// RoleController --------------------

	public function actionAll() {

		// Remember return url for crud
		Url::remember( [ 'form/all' ], 'forms' );

		return parent::actionAll();
	}
}

?>