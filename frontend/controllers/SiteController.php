<?php
namespace cmsgears\forms\frontend\controllers;

// Yii Imports
use Yii;
use yii\filters\VerbFilter;

// CMG Imports
use cmsgears\core\frontend\config\WebGlobalCore;
use cmsgears\forms\frontend\config\WebGlobalForms;

use cmsgears\forms\frontend\models\forms\GenericForm;

use cmsgears\forms\frontend\services\FormService;

// TODO: Automate the form submission and mail triggers using mail template.

class SiteController extends \cmsgears\core\frontend\controllers\BaseController {

	// Constructor and Initialisation ------------------------------

 	public function __construct( $id, $module, $config = [] ) {

        parent::__construct( $id, $module, $config );
	}

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

	// Instance Methods --------------------------------------------

	// SiteController

    public function actionIndex( $form ) {

		$formModel 	= FormService::findByName( $form );
		$template	= $formModel->template;
		$formFields	= $formModel->getFieldsMap();
 		$model		= new GenericForm( [ 'fields' => $formFields ] );

		if( $formModel->captcha ) {

			$model->setScenario( 'captcha' );
		}

		if( $model->load( Yii::$app->request->post(), 'GenericForm' ) && $model->validate() ) {

			// Save Model
			if( FormService::processForm( $form, $model ) ) {

				// Trigger User Mail
				if( $formModel->userMail ) {

					//Yii::$app->cmgFormsMailer->sendUserMail( $model );
				}

				// Trigger Admin Mail
				if( $formModel->adminMail ) {

					//Yii::$app->cmgFormsMailer->sendAdminMail( $model );
				}

				// Set success message
				if( isset( $formModel->successMessage ) ) {

					Yii::$app->session->setFlash( 'message', $formModel->successMessage );
				}

				// Refresh the Page
	        	return $this->refresh();
			}
		}

		if( isset( $template ) ) {

			// Configure Layout
			if( isset( $template->layout ) ) {

				if( $formModel->isPrivate() ) {
	
					$this->layout	= "//$template->layout" . "-private";
				}
				else {
	
					$this->layout	= "//$template->layout";
				}
			}

			$view	= $template->viewPath . "/$template->name";

			if( isset( $template->layout ) && isset( $view ) ) {

		        return $this->render( $view, [
		        	'form' => $formModel,
		        	'model' => $model
		        ]);
			}
		}

        return $this->render( WebGlobalCore::PAGE_INDEX, [
        		'model' => $model
        	]);
	}
}

?>