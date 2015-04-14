<?php
namespace cmsgears\forms\frontend\controllers\apix;

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\forms\frontend\config\WebGlobalForms;

use cmsgears\forms\frontend\models\forms\ContactForm;
use cmsgears\forms\frontend\models\forms\FeedbackForm;

use cmsgears\core\frontend\services\UserService;
use cmsgears\forms\frontend\services\FormService;

use cmsgears\core\frontend\controllers\BaseController;

use cmsgears\core\common\utilities\AjaxUtil;

class SiteController extends BaseController {

	// Constructor and Initialisation ------------------------------

	public function _construct( $id, $module, $config = [] )  {
		
		parent::_construct( $id, $module, $config );
	}

	// Instance Methods --------------------------------------------

	// yii\base\Component

    public function behaviors() {

        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'contact' => ['post']
                ]
            ]
        ];
    }

	// SiteController

    public function actionContact() {

		// Create Form Model
		$contact 	= new ContactForm();

		// Load and Validate Form Model
		if( $contact->load( Yii::$app->request->post( "Contact" ), "" ) && $contact->validate() ) {

			// Save Model
			if( FormService::processContactForm( $contact ) ) {

				// Send Contact Mail
				Yii::$app->cmgFormsMailer->sendContactMail( $this->getCoreProperties(), $this->getMailProperties(), $contact );

				// Trigger Ajax Success
				AjaxUtil::generateSuccess( Yii::$app->cmgFormsMessageSource->getMessage( WebGlobalForms::MESSAGE_CONTACT ) );
			}
		}
		else {

			// Generate Errors
			$errors = AjaxUtil::generateErrorMessage( $contact );

			// Trigger Ajax Failure
        	AjaxUtil::generateFailure( Yii::$app->cmgCoreMessageSource->getMessage( CoreGlobal::ERROR_REQUEST ), $errors );
		}
    }
}

?>