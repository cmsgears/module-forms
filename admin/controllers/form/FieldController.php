<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\forms\admin\controllers\form;

// Yii Imports
use Yii;
use yii\helpers\Url;

// CMG Imports
use cmsgears\forms\common\config\FormsGlobal;

/**
 * FieldController provides actions specific to form field model.
 *
 * @since 1.0.0
 */
class FieldController extends \cmsgears\core\admin\controllers\base\form\FieldController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

 	public function init() {

        parent::init();

		// Permission
        $this->crudPermission = FormsGlobal::PERM_FORM_ADMIN;

		// Config
		$this->apixBase = 'core/form/field';

		// Sidebar
		$this->sidebar = [ 'parent' => 'sidebar-form', 'child' => 'form' ];

		// Return Url
		$this->returnUrl = Url::previous( 'fields' );
		$this->returnUrl = isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/forms/form/field/all' ], true );

		// All Url
		$allUrl = Url::previous( 'forms' );
		$allUrl = isset( $allUrl ) ? $allUrl : Url::toRoute( [ '/forms/form/all' ], true );

		// Breadcrumbs
		$this->breadcrumbs = [
			'base' => [
				[ 'label' => 'Home', 'url' => Url::toRoute( '/dashboard' ) ],
				[ 'label' => 'Forms', 'url' =>  $allUrl ]
			],
			'all' => [ [ 'label' => 'Form Fields' ] ],
			'create' => [ [ 'label' => 'Form Fields', 'url' => $this->returnUrl ], [ 'label' => 'Add' ] ],
			'update' => [ [ 'label' => 'Form Fields', 'url' => $this->returnUrl ], [ 'label' => 'Update' ] ],
			'delete' => [ [ 'label' => 'Form Fields', 'url' => $this->returnUrl ], [ 'label' => 'Delete' ] ]
		];
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// FieldController -----------------------

	public function actionAll( $pid ) {

		Url::remember( Yii::$app->request->getUrl(), 'fields' );

		return parent::actionAll( $pid );
	}

}
