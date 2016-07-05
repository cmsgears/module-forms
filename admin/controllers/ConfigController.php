<?php
namespace cmsgears\forms\admin\controllers;

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\forms\common\config\FormsGlobal;

class ConfigController extends \cmsgears\core\admin\controllers\base\FormController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

 	public function init() {

        parent::init();

		$this->crudPermission 	= FormsGlobal::PERM_FORM;
		$this->sidebar 			= [ 'parent' => 'sidebar-form', 'child' => 'form-config' ];

		$this->submits			= false;

		$this->returnUrl		= Url::previous( 'forms' );
		$this->returnUrl		= isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/forms/config/all' ], true );
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
		Url::remember( [ 'config/all' ], 'forms' );

		return parent::actionAll();
	}
}

?>