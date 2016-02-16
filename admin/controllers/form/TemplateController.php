<?php
namespace cmsgears\forms\admin\controllers\form;

// Yii Imports
use \Yii;
use yii\helpers\Url;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\forms\common\config\FormsGlobal;

class TemplateController extends \cmsgears\core\admin\controllers\base\TemplateController {

	// Constructor and Initialisation ------------------------------

 	public function __construct( $id, $module, $config = [] ) {

        parent::__construct( $id, $module, $config );
		
		$this->sidebar 	= [ 'parent' => 'sidebar-form', 'child' => 'form-template' ];
		
		$this->type		= CoreGlobal::TYPE_FORM;
	}

	// Instance Methods ------------------

	// yii\base\Component ----------------

    public function behaviors() {
		
		$behaviors	= parent::behaviors();
		
		$behaviors[ 'rbac' ][ 'actions' ] = [
								                'all'  => [ 'permission' => FormsGlobal::PERM_FORM ],
								                'create'  => [ 'permission' => FormsGlobal::PERM_FORM ],
								                'update'  => [ 'permission' => FormsGlobal::PERM_FORM ],
								                'delete'  => [ 'permission' => FormsGlobal::PERM_FORM ]
							                ];
		
		return $behaviors;
    }

	// CategoryController --------------------

	public function actionAll() {
		
		Url::remember( [ 'form/template/all' ], 'templates' );

		return parent::actionAll();
	}
}

?>