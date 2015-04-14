<?php
namespace cmsgears\forms\frontend\controllers;

// Yii Imports
use Yii;
use yii\filters\VerbFilter;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\core\frontend\config\WebGlobalCore;
use cmsgears\forms\frontend\config\WebGlobalForms;

use cmsgears\forms\frontend\models\forms\ContactForm;
use cmsgears\forms\frontend\models\forms\FeedbackForm;

use cmsgears\core\frontend\services\UserService;
use cmsgears\forms\frontend\services\FormService;

use cmsgears\core\frontend\controllers\BaseController;

class SiteController extends BaseController {

	// Constructor and Initialisation ------------------------------

 	public function __construct( $id, $module, $config = [] ) {

        parent::__construct( $id, $module, $config );

		$this->layout	= WebGlobalCore::LAYOUT_PUBLIC;
	}

    public function behaviors() {

        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'contact' => [ 'get','post' ],
                    'feedback' => [ 'get','post' ]
                ]
            ]
        ];
    }

    public function actions() {

        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

	// Instance Methods --------------------------------------------

	// SiteController

    public function actionContact() {

		// Create Form Model
		$model = new ContactForm();

		// Load and Validate Form Model
		if( $model->load( Yii::$app->request->post( "ContactForm" ), "" ) && $model->validate() ) {

			// Save Model
			if( FormService::processContactForm( $model ) ) {

				// Send Contact Mail
				Yii::$app->cmgFormsMailer->sendContactMail( $this->getCoreProperties(), $this->getMailProperties(), $model );

				// Set Flash Message
				Yii::$app->session->setFlash( "success", Yii::$app->cmgFormsMessageSource->getMessage( WebGlobalForms::MESSAGE_CONTACT ) );

				// Refresh the Page
	        	return $this->refresh();
			}
		}

        return $this->render( WebGlobalCore::PAGE_CONTACT, [
        		'model' => $model
        	]);
	}

    public function actionFeedback() {

		// Create Form Model
		$model = new FeedbackForm();

		// Load and Validate Form Model
		if( $model->load( Yii::$app->request->post( "Feedback" ), "" ) && $model->validate() ) {

			// Save Model
			if( FormService::processFeedbackForm( $model ) ) {

				// Send Feedback Mail
				Yii::$app->cmgFormsMailer->sendFeedbackMail( $this->getCoreProperties(), $this->getMailProperties(), $model );

				// Set Flash Message
				Yii::$app->session->setFlash( "success", Yii::$app->cmgFormsMessageSource->getMessage( WebGlobalForms::MESSAGE_FEEDBACK ) );

				// Refresh the Page
	        	return $this->refresh();
			}
		}

        return $this->render( WebGlobalCore::PAGE_FEEDBACK, [
        		'model' => $model
        	]);
	}
}

?>