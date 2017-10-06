<?php
namespace cmsgears\forms\frontend\controllers;

// Yii Imports
use Yii;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use yii\web\UnauthorizedHttpException;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\core\frontend\config\WebGlobalCore;
use cmsgears\forms\frontend\config\WebGlobalForms;

use cmsgears\forms\common\models\forms\GenericForm;

// TODO: Automate the form submission and mail triggers using mail template.

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

		$this->formService	= Yii::$app->factory->get( 'formService' );
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

    public function behaviors() {

        return [
            'rbac' => [
                'class' => Yii::$app->core->getRbacFilterClass(),
                'actions' => [
	                // secure actions
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'single' => [ 'get', 'post' ]
                ]
            ]
        ];
    }

	// yii\base\Controller ----

    public function actions() {

        return [
        	// Captcha for regular forms
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        	// Captcha for ajax forms
            'acaptcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ]
        ];
    }

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// SiteController ------------------------

    public function actionSingle( $slug, $type = null ) {

		if( !isset( $type ) ) {

			$type = CoreGlobal::TYPE_SITE;
		}

		$form	= $this->formService->getBySlugType( $slug, $type );

		if( isset( $form ) ) {

			$template	= $form->template;
			$formFields	= $form->getFieldsMap();
	 		$model		= new GenericForm( [ 'fields' => $formFields ] );

			$user		= Yii::$app->user->getIdentity();

			// Form need a valid user
			if( !$form->isVisibilityPublic() ) {

				// Form need it's owner
				if( $form->isVisibilityPrivate() && !$form->isOwner( $user ) ) {

					// Error- Not allowed
					throw new UnauthorizedHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_ALLOWED ) );
				}

				// Form need logged in user
				if( $form->isVisibilityProtected() && empty( $user ) ) {

					// Remember URL for Login
					Url::remember( Url::canonical(), CoreGlobal::REDIRECT_LOGIN );

					// Error- Not allowed
					return $this->redirect( [ '/login' ] );
				}
			}

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

					// Set success message
					if( isset( $form->successMessage ) ) {

						Yii::$app->session->setFlash( 'message', $form->successMessage );
					}

					// Refresh the Page
		        	return $this->refresh();
				}
			}

			if( isset( $template ) ) {

				return Yii::$app->templateManager->renderViewPublic( $template, [
		        	'form' => $form,
			        'model' => $model
		        ], [ 'page' => true ] );
			}

	        return $this->render( WebGlobalCore::PAGE_INDEX, [
	        	'model' => $model
	        ]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
}
