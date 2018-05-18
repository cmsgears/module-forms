<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\forms\admin\controllers\form;

// Yii Imports
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\forms\common\config\FormsGlobal;

use cmsgears\core\admin\controllers\base\Controller;

/**
 * SubmitController provides actions specific to form submit model.
 *
 * @since 1.0.0
 */
class SubmitController extends Controller {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	protected $formService;

	// Private ----------------

	// Constructor and Initialisation ------------------------------

 	public function init() {

        parent::init();

		// Permission
        $this->crudPermission = FormsGlobal::PERM_FORM_ADMIN;

		// Config
		$this->apixBase = 'form/form/submit';

		// Services
		$this->modelService = Yii::$app->factory->get( 'formSubmitService' );
		$this->formService = Yii::$app->factory->get( 'formService' );

		// Sidebar
		$this->sidebar = [ 'parent' => 'sidebar-form', 'child' => 'form' ];

		// Return Url
		$this->returnUrl = Url::previous( 'form-submits' );
		$this->returnUrl = isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/forms/form/submit/all' ], true );

		// Form Url
		$formsUrl = Url::previous( 'forms' );
		$formsUrl = isset( $formsUrl ) ? $formsUrl : Url::toRoute( [ '/forms/form/all' ], true );

		// Breadcrumbs
		$this->breadcrumbs = [
			'base' => [ [ 'label' => 'Forms', 'url' =>  $formsUrl ] ],
			'all' => [ [ 'label' => 'Form Submit' ] ],
			'create' => [ [ 'label' => 'Form Submit', 'url' => $this->returnUrl ], [ 'label' => 'Add' ] ],
			'update' => [ [ 'label' => 'Form Submit', 'url' => $this->returnUrl ], [ 'label' => 'Update' ] ],
			'delete' => [ [ 'label' => 'Form Submit', 'url' => $this->returnUrl ], [ 'label' => 'Delete' ] ],
			'items' => [ [ 'label' => 'Form Submit', 'url' => $this->returnUrl ], [ 'label' => 'Items' ] ]
		];
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
                'class' => VerbFilter::class,
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

		$form	= $this->formService->getById( $fid );

		if( isset( $form ) ) {

			// Remember return url for crud
			Url::remember( [ "form/submit/all?fid=$fid" ], 'form-submits' );

			$dataProvider = $this->modelService->getPageByFormId( $fid );

		    return $this->render( 'all', [
		         'dataProvider' => $dataProvider,
		         'form' => $form
		    ]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
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
