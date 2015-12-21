<?php
namespace cmsgears\forms\admin\controllers\form;

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\forms\common\config\FormsGlobal;

use cmsgears\forms\admin\services\FormService;
use cmsgears\forms\admin\services\FormSubmitService;

class SubmitController extends \cmsgears\core\admin\controllers\base\Controller {

	// Constructor and Initialisation ------------------------------

 	public function __construct( $id, $module, $config = [] ) {

        parent::__construct( $id, $module, $config );
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
	                'delete' => [ 'permission' => FormsGlobal::PERM_FORM ]
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

	// PageController --------------------

	public function actionIndex() {

		$this->redirect( [ 'all' ] );
	}

	public function actionAll( $formid ) {

		$dataProvider = FormSubmitService::getPaginationByFormId( $formid );

	    return $this->render( 'all', [
	         'dataProvider' => $dataProvider,
	         'formId' => $formid
	    ]);
	}

	public function actionDelete( $id ) {

		// Find Model
		$model	= FormSubmitService::findById( $id );

		// Delete/Render if exist
		if( isset( $model ) ) {

			if( $model->load( Yii::$app->request->post(), 'FormSubmit' ) ) {

				if( FormSubmitService::delete( $model ) ) {

					$this->redirect( [ "all?formid=$model->formId" ] );
				}
			}

	    	return $this->render( 'delete', [
				'model' => $model,
				'formId' => $model->formId
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
}

?>