<?php
namespace cmsgears\forms\admin\controllers\form;

// Yii Imports
use \Yii;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\db\IntegrityException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\forms\common\config\FormsGlobal;

class TemplateController extends \cmsgears\core\admin\controllers\base\TemplateController {

	// Constructor and Initialisation ------------------------------

 	public function __construct( $id, $module, $config = [] ) {

        parent::__construct( $id, $module, $config );
		
		$this->sidebar 		= [ 'parent' => 'sidebar-form', 'child' => 'form-template' ];
	}

	// Instance Methods ------------------

	// yii\base\Component ----------------

    public function behaviors() {

        return [
            'rbac' => [
                'class' => Yii::$app->cmgCore->getRbacFilterClass(),
                'actions' => [
	                'all'    => [ 'permission' => FormsGlobal::PERM_FORM ],
	                'create' => [ 'permission' => FormsGlobal::PERM_FORM ],
	                'update' => [ 'permission' => FormsGlobal::PERM_FORM ],
	                'delete' => [ 'permission' => FormsGlobal::PERM_FORM ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
	                'all'  => [ 'get' ],
	                'create'  => [ 'get', 'post' ],
	                'update'  => [ 'get', 'post' ],
	                'delete'  => [ 'get', 'post' ]
                ]
            ]
        ];
    }

	// CategoryController --------------------

	public function actionAll() {
		
		Url::remember( [ 'form/template/all' ], 'templates' );

		return parent::actionAll( CoreGlobal::TYPE_FORM );
	}
	
	public function actionCreate() {

		return parent::actionCreate( CoreGlobal::TYPE_FORM );
	}
	 
	public function actionUpdate( $id ) {

		return parent::actionUpdate( $id, CoreGlobal::TYPE_FORM );
	}
	
	public function actionDelete( $id ) {

		return parent::actionDelete( $id, CoreGlobal::TYPE_FORM );
	}
}

?>