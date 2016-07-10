<?php
namespace cmsgears\forms\frontend\controllers;

// Yii Imports
use Yii;
use yii\filters\VerbFilter;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\core\frontend\config\WebGlobalCore;
use cmsgears\forms\frontend\config\WebGlobalForms;

use cmsgears\forms\common\models\forms\GenericForm;

// TODO: Automate the form submission and mail triggers using mail template.

class SiteController extends \cmsgears\core\frontend\controllers\base\Controller {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	protected $formService;

	// Private ----------------

	// Constructor and Initialisation ------------------------------

 	public function init() {

        parent::init();

		$this->formService	= Yii::$app->factory->get( 'formService' );
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

    public function behaviors() {

        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => [ 'get', 'post' ]
                ]
            ]
        ];
    }

    public function actions() {

        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ]
        ];
    }

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// SiteController ------------------------

    public function actionIndex( $slug, $type = null ) {

		if( !isset( $type ) ) {

			$type = CoreGlobal::TYPE_SITE;
		}

		$form 		= $this->formService->getBySlugType( $slug, $type );
		$template	= $form->template;
		$formFields	= $form->getFieldsMap();
 		$model		= new GenericForm( [ 'fields' => $formFields ] );

		if( $form->captcha ) {

			$model->setScenario( 'captcha' );
		}

		if( $model->load( Yii::$app->request->post(), 'GenericForm' ) && $model->validate() ) {

			// Save Model
			if( $this->formService->processForm( $form, $model ) ) {

				// Trigger User Mail
				if( $form->userMail ) {

					Yii::$app->formsMailer->sendUserMail( $form, $model );
				}

				// Trigger Admin Mail
				if( $form->adminMail ) {

					Yii::$app->formsMailer->sendAdminMail( $form, $model );
				}

				// Set success message
				if( isset( $form->successMessage ) ) {

					Yii::$app->session->setFlash( 'message', $form->successMessage );
				}

				// Refresh the Page
	        	return $this->refresh();
			}
		}

		if( isset( $template ) ) {

			return Yii::$app->templateManager->renderViewPublic( $template, [
	        	'form' => $form,
		        'model' => $model
	        ], [ 'page' => true ] );
		}

        return $this->render( WebGlobalCore::PAGE_INDEX, [
        		'model' => $model
        	]);
	}
}
