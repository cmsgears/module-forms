<?php
namespace cmsgears\forms\frontend\controllers\apix;

// Yii Imports
use Yii;
use yii\filters\VerbFilter;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\forms\common\models\forms\GenericForm;

use cmsgears\core\frontend\controllers\base\Controller;

use cmsgears\core\common\utilities\AjaxUtil;

class FormController extends Controller {

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
                'class' => VerbFilter::class,
                'actions' => [
                    'submit' => [ 'post' ]
                ]
            ]
        ];
    }

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// FormController ------------------------

    public function actionSubmit( $slug, $type = null ) {

		if( !isset( $type ) ) {

			$type = CoreGlobal::TYPE_FORM;
		}

		$form 		= $this->formService->getBySlugType( $slug, $type );
		$template	= $form->template;
		$formFields	= $form->getFieldsMap();
 		$model		= new GenericForm( [ 'fields' => $formFields, 'ajax' => true ] );

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

				// Trigger Ajax Success
				return AjaxUtil::generateSuccess( $form->success );
			}
		}

		// Generate Errors
		$errors = AjaxUtil::generateErrorMessage( $model );

		// Trigger Ajax Failure
    	return AjaxUtil::generateFailure( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_REQUEST ), $errors );
    }

}
