<?php
namespace cmsgears\forms\admin\controllers;

// Yii Imports
use \Yii;
use yii\helpers\Url;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\forms\common\config\FormsGlobal;

class FormController extends \cmsgears\core\admin\controllers\base\FormController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

 	public function init() {

        parent::init();

		$this->type				= CoreGlobal::TYPE_SITE;
		
		// Permissions
        $this->crudPermission	= FormsGlobal::PERM_FORM_ADMIN;

		// Sidebar
		$this->sidebar 			= [ 'parent' => 'sidebar-form', 'child' => 'form' ];

		// Return Url
		$this->returnUrl		= Url::previous( 'forms' );
		$this->returnUrl		= isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/forms/form/all' ], true );
		
		// Breadcrumbs
		$this->breadcrumbs		= [
			'all' => [ [ 'label' => 'Form' ] ],
			'create' => [ [ 'label' => 'Form', 'url' => $this->returnUrl ], [ 'label' => 'Add' ] ],
			'update' => [ [ 'label' => 'Form', 'url' => $this->returnUrl ], [ 'label' => 'Update' ] ],
			'delete' => [ [ 'label' => 'Form', 'url' => $this->returnUrl ], [ 'label' => 'Delete' ] ],
			'items' => [ [ 'label' => 'Form', 'url' => $this->returnUrl ], [ 'label' => 'Items' ] ]
		];
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// FormController ------------------------

	public function actionAll() {

		// Remember return url for crud
		Url::remember( Yii::$app->request->getUrl(), 'forms' );

		return parent::actionAll();
	}
}
