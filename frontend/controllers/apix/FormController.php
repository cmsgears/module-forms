<?php
namespace cmsgears\forms\frontend\controllers\apix;

// Yii Imports
use Yii;
use yii\filters\VerbFilter;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\forms\common\models\forms\GenericForm;

use cmsgears\core\common\utilities\AjaxUtil;

class FormController extends \cmsgears\core\frontend\controllers\base\Controller {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	protected $formService;

	// Private ----------------

	// Constructor and Initialisation ------------------------------

 	public function init() {

        parent::init();

		$this->formService = Yii::$app->factory->get( 'formService' );
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

		$model 		= $this->formService->getBySlugType( $slug, $type );
		$formFields	= $model->getFieldsMap();
 		$form		= new GenericForm( [ 'fields' => $formFields, 'ajax' => true ] );

		if( $model->captcha ) {

			$form->setScenario( 'captcha' );
		}

		if( $form->load( Yii::$app->request->post(), $form->getClassName() ) && $form->validate() ) {

			// Save Model
			if( $this->formService->processForm( $model, $form ) ) {

				$data = [];

				// Set success message
				if( isset( $model->success ) ) {

					$data[ 'message' ] = $model->success;
				}

				// Trigger Ajax Success
				return AjaxUtil::generateSuccess( $model->success, $data );
			}
		}

		// Generate Errors
		$errors = AjaxUtil::generateErrorMessage( $form );

		// Trigger Ajax Failure
    	return AjaxUtil::generateFailure( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_REQUEST ), $errors );
    }

}
