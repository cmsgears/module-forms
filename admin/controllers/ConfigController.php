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

use cmsgears\core\admin\controllers\base\FormController;

/**
 * ConfigController provides actions specific to configuration forms.
 *
 * @since 1.0.0
 */
class ConfigController extends FormController {

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
		$this->type		= CoreGlobal::TYPE_SYSTEM;
		$this->apixBase = 'core/form';
		$this->submits	= false;

		// Services
		$this->modelService = Yii::$app->factory->get( 'cmsgears\core\common\services\interfaces\resources\IFormService' );

		// Sidebar
		$this->sidebar = [ 'parent' => 'sidebar-form', 'child' => 'config' ];

		// Return Url
		$this->returnUrl = Url::previous( 'configs' );
		$this->returnUrl = isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/forms/config/all' ], true );

		// Breadcrumbs
		$this->breadcrumbs = [
			'base' => [
				[ 'label' => 'Home', 'url' => Url::toRoute( '/dashboard' ) ]
			],
			'all' => [ [ 'label' => 'Forms' ] ],
			'create' => [ [ 'label' => 'Forms', 'url' => $this->returnUrl ], [ 'label' => 'Add' ] ],
			'update' => [ [ 'label' => 'Forms', 'url' => $this->returnUrl ], [ 'label' => 'Update' ] ],
			'delete' => [ [ 'label' => 'Forms', 'url' => $this->returnUrl ], [ 'label' => 'Delete' ] ],
			'fields' => [ [ 'label' => 'Forms', 'url' => $this->returnUrl ], [ 'label' => 'Fields' ] ]
		];
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// ConfigController ----------------------

	public function actionAll() {

		Url::remember( Yii::$app->request->getUrl(), 'configs' );

		return parent::actionAll();
	}

}
