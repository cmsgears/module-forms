<?php
namespace cmsgears\forms\admin\controllers;

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\forms\common\config\FormsGlobal;

use cmsgears\forms\common\models\entities\Form;

use cmsgears\forms\admin\services\FormService;
use cmsgears\core\admin\services\TemplateService;

class FormController extends \cmsgears\core\admin\controllers\BaseController {

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
	                'create' => [ 'permission' => FormsGlobal::PERM_FORM ],
	                'update' => [ 'permission' => FormsGlobal::PERM_FORM ],
	                'delete' => [ 'permission' => FormsGlobal::PERM_FORM ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
	                'index'  => ['get'],
	                'all'   => ['get'],
	                'create' => ['get', 'post'],
	                'update' => ['get', 'post'],
	                'delete' => ['get', 'post']
                ]
            ]
        ];
    }

	// PageController --------------------

	public function actionIndex() {

		$this->redirect( [ 'all' ] );
	}

	public function actionAll() {

		$dataProvider = FormService::getPagination();

	    return $this->render( 'all', [
	         'dataProvider' => $dataProvider
	    ]);
	}

	public function actionCreate() {

		$model			= new Form();
		$model->siteId	= Yii::$app->cmgCore->siteId;

		$model->setScenario( 'create' );

		if( $model->load( Yii::$app->request->post(), 'Form' ) && $model->validate() ) {

			if( FormService::create( $model ) ) {

				$this->redirect( [ 'all' ] );
			}
		}

		$templatesMap	= TemplateService::getIdNameMapByType( FormsGlobal::TYPE_FORM );

    	return $this->render( 'create', [
    		'model' => $model,
    		'templatesMap' => $templatesMap,
    		'visibilityMap' => Form::$visibilityMap
    	]);
	}

	public function actionUpdate( $id ) {

		// Find Model
		$model		= FormService::findById( $id );

		// Update/Render if exist
		if( isset( $model ) ) {

			$model->setScenario( 'update' );

			if( $model->load( Yii::$app->request->post(), 'Form' ) && $model->validate() ) {

				if( FormService::update( $model ) ) {

					$this->redirect( [ 'all' ] );
				}
			}

			$templatesMap	= TemplateService::getIdNameMapByType( FormsGlobal::TYPE_FORM );

	    	return $this->render( 'update', [
	    		'model' => $model,
	    		'templatesMap' => $templatesMap,
	    		'visibilityMap' => Form::$visibilityMap
	    	]);
		}
		
		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	public function actionDelete( $id ) {

		// Find Model
		$model	= FormService::findById( $id );

		// Delete/Render if exist
		if( isset( $model ) ) {

			if( $model->load( Yii::$app->request->post(), 'Form' ) ) {

				if( FormService::delete( $model ) ) {

					$this->redirect( [ 'all' ] );
				}
			}

			$templatesMap	= TemplateService::getIdNameMapByType( FormsGlobal::TYPE_FORM );
			
	    	return $this->render( 'delete', [
	    		'model' => $model,
	    		'templatesMap' => $templatesMap,
	    		'visibilityMap' => Form::$visibilityMap
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
}

?>