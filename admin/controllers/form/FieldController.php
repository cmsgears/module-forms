<?php
namespace cmsgears\forms\admin\controllers\form;

// Yii Imports
use \Yii;
use yii\helpers\Url;

// CMG Imports
use cmsgears\forms\common\config\FormsGlobal;

class FieldController extends \cmsgears\core\admin\controllers\base\form\FieldController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

 	public function init() {

        parent::init();

        $this->crudPermission	= FormsGlobal::PERM_FORM_ADMIN;

		$this->sidebar 			= [ 'parent' => 'sidebar-form', 'child' => 'form' ];

		$this->returnUrl		= Url::previous( 'fields' );
		$this->returnUrl		= isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/forms/form/field/all' ], true );
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// FieldController -----------------------

	public function actionAll( $fid ) {

		Url::remember( [ "form/field/all?fid=$fid" ], 'fields' );

		return parent::actionAll( $fid );
	}
}
