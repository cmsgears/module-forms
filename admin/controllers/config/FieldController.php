<?php
namespace cmsgears\forms\admin\controllers\config;

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

		$this->sidebar 			= [ 'parent' => 'sidebar-form', 'child' => 'config' ];

		$this->returnUrl		= Url::previous( 'fields' );
		$this->returnUrl		= isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/forms/config/field/all' ], true );
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

		Url::remember( [ "config/field/all?fid=$fid" ], 'fields' );

		return parent::actionAll( $fid );
	}
}
