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

		$this->sidebar 			= [ 'parent' => 'sidebar-form', 'child' => 'template' ];

		$this->crudPermission	= FormsGlobal::PERM_FORM_ADMIN;

		$this->type				= CoreGlobal::TYPE_FORM;

		$this->returnUrl		= Url::previous( 'templates' );
		$this->returnUrl		= isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/forms/form/templates/all' ], true );
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

		Url::remember( [ 'form/template/all' ], 'templates' );

		return parent::actionAll();
	}
}
