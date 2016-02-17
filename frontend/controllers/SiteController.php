<?php
namespace cmsgears\forms\frontend\controllers;

// Yii Imports
use Yii;
use yii\filters\VerbFilter;

// CMG Imports
use cmsgears\core\frontend\config\WebGlobalCore;
use cmsgears\forms\frontend\config\WebGlobalForms;

use cmsgears\forms\common\models\forms\GenericForm;

use cmsgears\forms\frontend\services\FormService;

// TODO: Automate the form submission and mail triggers using mail template.

class SiteController extends \cmsgears\core\frontend\controllers\base\Controller {

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

    public function actionIndex( $slug ) {

		$form 		= FormService::findBySlug( $slug );
		$template	= $form->template;
		$formFields	= $form->getFieldsMap();
 		$model		= new GenericForm( [ 'fields' => $formFields ] );

		if( $form->captcha ) {

			$model->setScenario( 'captcha' );
		}

		if( $model->load( Yii::$app->request->post(), 'GenericForm' ) && $model->validate() ) {

			// Save Model
			if( FormService::processForm( $form, $model ) ) {

				// Trigger User Mail
				if( $form->userMail ) {

					Yii::$app->cmgFormsMailer->sendUserMail( $form, $model );
				}

				// Trigger Admin Mail
				if( $form->adminMail ) {

					Yii::$app->cmgFormsMailer->sendAdminMail( $form, $model );
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

			return Yii::$app->templateSource->renderViewPublic( $template, [
	        	'form' => $form,
		        'model' => $model
	        ], true );
		}

        return $this->render( WebGlobalCore::PAGE_INDEX, [
        		'model' => $model
        	]);
	}
}

?>