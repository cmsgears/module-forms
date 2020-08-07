<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\forms\admin\controllers\config;

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
		$this->sidebar = [ 'parent' => 'sidebar-form', 'child' => 'config' ];

		// Return Url
		$this->returnUrl = Url::previous( 'cfields' );
		$this->returnUrl = isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/forms/config/field/all' ], true );

		// All Url
		$allUrl = Url::previous( 'configs' );
		$allUrl = isset( $allUrl ) ? $allUrl : Url::toRoute( [ '/forms/config/all' ], true );

		// Breadcrumbs
		$this->breadcrumbs = [
			'base' => [
				[ 'label' => 'Home', 'url' => Url::toRoute( '/dashboard' ) ],
				[ 'label' => 'Config Forms', 'url' =>  $allUrl ]
			],
			'all' => [ [ 'label' => 'Config Fields' ] ],
			'create' => [ [ 'label' => 'Config Fields', 'url' => $this->returnUrl ], [ 'label' => 'Add' ] ],
			'update' => [ [ 'label' => 'Config Fields', 'url' => $this->returnUrl ], [ 'label' => 'Update' ] ],
			'delete' => [ [ 'label' => 'Config Fields', 'url' => $this->returnUrl ], [ 'label' => 'Delete' ] ]
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

	public function actionAll( $fid ) {

		Url::remember( Yii::$app->request->getUrl(), 'cfields' );

		return parent::actionAll( $fid );
	}

}
