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

		$this->layout	= WebGlobalForms::LAYOUT_FORMS;
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
            ],
        ];
    }

	// Instance Methods --------------------------------------------

	// SiteController

    public function actionContact() {
		
		$this->layout	= WebGlobalForms::LAYOUT_FORMS_PRIVATE;
		
		// Create Form Model
		$model = new ContactForm();

		// Load and Validate Form Model
		if( $model->load( Yii::$app->request->post(), 'ContactForm' ) && $model->validate() ) {

			// Save Model
			if( FormService::processContactForm( $model ) ) {

				// Send Contact Mail
				Yii::$app->cmgFormsMailer->sendContactMail( $model );

				// Set Flash Message
				Yii::$app->session->setFlash( 'success', Yii::$app->cmgFormsMessage->getMessage( WebGlobalForms::MESSAGE_CONTACT ) );

				// Refresh the Page
	        	return $this->refresh();
			}
		}

        return $this->render( WebGlobalCore::PAGE_INDEX, [
        		'model' => $model
        	]);
	}
}

?>