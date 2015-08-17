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
		if( $contact->load( Yii::$app->request->post(), 'Contact' ) && $contact->validate() ) {

			// Save Model
			if( FormService::processContactForm( $contact ) ) {

				// Send Contact Mail
				Yii::$app->cmgFormsMailer->sendContactMail( $contact );

				// Trigger Ajax Success
				return AjaxUtil::generateSuccess( Yii::$app->cmgFormsMessage->getMessage( WebGlobalForms::MESSAGE_CONTACT ) );
			}
		}
		else {

			// Generate Errors
			$errors = AjaxUtil::generateErrorMessage( $contact );

			// Trigger Ajax Failure
        	return AjaxUtil::generateFailure( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_REQUEST ), $errors );
		}
    }
}

?>