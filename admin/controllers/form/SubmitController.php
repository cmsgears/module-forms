<?php
namespace cmsgears\forms\admin\controllers\form;

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\forms\common\config\FormsGlobal;

class SubmitController extends \cmsgears\core\admin\controllers\base\Controller {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

 	public function init() {

        parent::init();

		$this->crudPermission 	= CoreGlobal::PERM_CORE;
		$this->modelService		= Yii::$app->factory->get( 'formSubmitService' );
		$this->sidebar 			= [ 'parent' => 'sidebar-form', 'child' => 'form' ];

		$this->returnUrl		= Url::previous( 'submits' );
		$this->returnUrl		= isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/forms/form/submit/all' ], true );
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

    public function behaviors() {

        return [
            'rbac' => [
                'class' => Yii::$app->core->getRbacFilterClass(),
                'actions' => [
	                'index'  => [ 'permission' => $this->crudPermission ],
	                'all'    => [ 'permission' => $this->crudPermission ],
	                'delete' => [ 'permission' => $this->crudPermission ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
	                'index'  => [ 'get' ],
	                'all'   => [ 'get' ],
	                'delete' => [ 'get', 'post' ]
                ]
            ]
        ];
    }

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// SubmitController ----------------------

	public function actionIndex() {

		$this->redirect( [ 'all' ] );
	}

	public function actionAll( $fid ) {

		// Remember return url for crud
		Url::remember( [ "form/submit/all?fid=$fid" ], 'submits' );

		$dataProvider = $this->modelService->getPageByFormId( $fid );

	    return $this->render( 'all', [
	         'dataProvider' => $dataProvider,
	         'formId' => $fid
	    ]);
	}

	public function actionDelete( $id ) {

		// Find Model
		$model	= $this->modelService->getById( $id );

		// Delete/Render if exist
		if( isset( $model ) ) {

			if( $model->load( Yii::$app->request->post(), $model->getClassName() ) ) {

				$this->modelService->delete( $model );

				$this->redirect( [ "all?fid=$model->formId" ] );
			}

	    	return $this->render( 'delete', [
				'model' => $model,
				'formId' => $model->formId
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
}
