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
	}

	// Instance Methods --------------------------------------------

	// yii\base\Component ----------------

    public function behaviors() {

        return [
            'rbac' => [
                'class' => Yii::$app->cmgCore->getRbacFilterClass(),
                'actions' => [
	                'index'  => [ 'permission' => FormsGlobal::PERM_FORM ],
	                'all'    => [ 'permission' => FormsGlobal::PERM_FORM ],
	                'create' => [ 'permission' => FormsGlobal::PERM_FORM ],
	                'update' => [ 'permission' => FormsGlobal::PERM_FORM ],
	                'delete' => [ 'permission' => FormsGlobal::PERM_FORM ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
	                'index'   => [ 'get' ],
	                'all'   => [ 'get' ],
	                'create' => [ 'get', 'post' ],
	                'update' => [ 'get', 'post' ],
	                'delete' => [ 'get', 'post' ]
                ]
            ]
        ];
    }

	// RoleController --------------------

	public function actionIndex() {

		$this->redirect( 'all' );
	}

	public function actionAll() {

		// Remember return url for crud
		Url::remember( [ 'form/all' ], 'forms' );

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