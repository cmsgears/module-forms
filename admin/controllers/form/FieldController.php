<?php
namespace cmsgears\forms\admin\controllers\form;

// Yii Imports
use \Yii;
use yii\helpers\Url;

// CMG Imports
use cmsgears\forms\common\config\FormsGlobal;

class FieldController extends \cmsgears\core\admin\controllers\base\form\FieldController {

	// Constructor and Initialisation ------------------------------

 	public function __construct( $id, $module, $config = [] ) {

        parent::__construct( $id, $module, $config );
		
		$this->sidebar 	= [ 'parent' => 'sidebar-form', 'child' => 'form' ];
	}

	// Instance Methods --------------------------------------------

	// yii\base\Component ----------------

    public function behaviors() {
		
		$behaviors	= parent::behaviors();
		
		$behaviors[ 'rbac' ][ 'actions' ] = [
								                'all'  => [ 'permission' => FormsGlobal::PERM_FORM ],
								                'create'  => [ 'permission' => FormsGlobal::PERM_FORM ],
								                'update'  => [ 'permission' => FormsGlobal::PERM_FORM ],
								                'delete'  => [ 'permission' => FormsGlobal::PERM_FORM ],
							                ];

		return $behaviors;
    }

	// CategoryController --------------------

	public function actionAll( $formid ) {
		
		Url::remember( [ "form/field/all?formid=$formid" ], 'fields' );

		return parent::actionAll( $formid );
	}
}

?>