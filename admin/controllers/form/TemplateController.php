<?php
namespace cmsgears\forms\admin\controllers\form;

// Yii Imports
use \Yii;
use yii\helpers\Url;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\forms\common\config\FormsGlobal;

class TemplateController extends \cmsgears\core\admin\controllers\base\TemplateController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

 	public function init() {

        parent::init();

		// Sidebar
		$this->sidebar 			= [ 'parent' => 'sidebar-form', 'child' => 'template' ];

		// Permission
		$this->crudPermission	= FormsGlobal::PERM_FORM_ADMIN;

		$this->type				= CoreGlobal::TYPE_FORM;

		// Return Url
		$this->returnUrl		= Url::previous( 'templates' );
		$this->returnUrl		= isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/forms/form/templates/all' ], true );
		
		// Breadcrumbs
		$this->breadcrumbs		= [
			'all' => [ [ 'label' => 'Form Template' ] ],
			'create' => [ [ 'label' => 'Form Template', 'url' => $this->returnUrl ], [ 'label' => 'Add' ] ],
			'update' => [ [ 'label' => 'Form Template', 'url' => $this->returnUrl ], [ 'label' => 'Update' ] ],
			'delete' => [ [ 'label' => 'Form Template', 'url' => $this->returnUrl ], [ 'label' => 'Delete' ] ],
			'items' => [ [ 'label' => 'Form Template', 'url' => $this->returnUrl ], [ 'label' => 'Items' ] ]
		];
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// TemplateController --------------------

	public function actionAll() {

		Url::remember( Yii::$app->request->getUrl(), 'templates' );

		return parent::actionAll();
	}
}
