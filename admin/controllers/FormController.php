<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\forms\admin\controllers;

// Yii Imports
use Yii;
use yii\helpers\Url;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\forms\common\config\FormsGlobal;

/**
 * FormController provides actions specific to forms.
 *
 * @since 1.0.0
 */
class FormController extends \cmsgears\core\admin\controllers\base\FormController {

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
		$this->type		= CoreGlobal::TYPE_SITE;
		$this->apixBase = 'core/form';
		$this->submits	= true;

		// Sidebar
		$this->sidebar = [ 'parent' => 'sidebar-form', 'child' => 'form' ];

		// Return Url
		$this->returnUrl = Url::previous( 'forms' );
		$this->returnUrl = isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/forms/form/all' ], true );

		// Breadcrumbs
		$this->breadcrumbs = [
			'base' => [
				[ 'label' => 'Home', 'url' => Url::toRoute( '/dashboard' ) ]
			],
			'all' => [ [ 'label' => 'Form' ] ],
			'create' => [ [ 'label' => 'Form', 'url' => $this->returnUrl ], [ 'label' => 'Add' ] ],
			'update' => [ [ 'label' => 'Form', 'url' => $this->returnUrl ], [ 'label' => 'Update' ] ],
			'delete' => [ [ 'label' => 'Form', 'url' => $this->returnUrl ], [ 'label' => 'Delete' ] ],
			'fields' => [ [ 'label' => 'Form', 'url' => $this->returnUrl ], [ 'label' => 'Fields' ] ]
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

		Url::remember( Yii::$app->request->getUrl(), 'forms' );

		return parent::actionAll();
	}

}
