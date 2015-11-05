<?php
namespace cmsgears\forms\frontend\controllers\apix;

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\forms\frontend\config\WebGlobalForms;

use cmsgears\forms\frontend\models\forms\GenericForm;

use cmsgears\forms\frontend\services\FormService;

use cmsgears\core\common\utilities\AjaxUtil;

class SiteController extends \cmsgears\core\frontend\controllers\BaseController {

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
                    'index' => [ 'post' ]
                ]
            ]
        ];
    }

	// SiteController

    public function actionIndex( $form ) {

		$formModel 	= FormService::findBySlug( $form );
		$template	= $formModel->template;
		$formFields	= $formModel->getFieldsMap();
 		$model		= new GenericForm( [ 'fields' => $formFields ] );

		if( $formModel->captcha ) {

			$model->setScenario( 'captcha' );
		}

		if( $model->load( Yii::$app->request->post(), 'GenericForm' ) && $model->validate() ) {

			// Save Model
			if( FormService::processForm( $formModel, $model ) ) {

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

				// Trigger Ajax Success
				return AjaxUtil::generateSuccess( $formModel->successMessage );
			}
		}

		// Generate Errors
		$errors = AjaxUtil::generateErrorMessage( $model );

		// Trigger Ajax Failure
    	return AjaxUtil::generateFailure( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_REQUEST ), $errors );
    }
}

?>