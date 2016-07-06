<?php
namespace cmsgears\forms\frontend\controllers\apix;

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\core\frontend\config\WebGlobalCore;
use cmsgears\forms\frontend\config\WebGlobalForms;

use cmsgears\forms\common\models\forms\GenericForm;

use cmsgears\forms\frontend\services\resources\FormService;

use cmsgears\core\common\utilities\AjaxUtil;

class SiteController extends \cmsgears\core\frontend\controllers\base\Controller {

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

				// Trigger Ajax Success
				return AjaxUtil::generateSuccess( $form->successMessage );
			}
		}

		// Generate Errors
		$errors = AjaxUtil::generateErrorMessage( $model );

		// Trigger Ajax Failure
    	return AjaxUtil::generateFailure( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_REQUEST ), $errors );
    }
}
