<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\form\admin\controllers\apix\form;

// Yii Imports
use Yii;
use yii\filters\VerbFilter;

// CMG Imports
use cmsgears\forms\common\config\FormsGlobal;

use cmsgears\core\admin\controllers\base\Controller;

/**
 * FormController provides actions specific to form model.
 *
 * @since 1.0.0
 */
class FormController extends Controller {

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

		// Services
		$this->modelService = Yii::$app->factory->get( 'formSubmitService' );
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	public function behaviors() {

		return [
			'rbac' => [
				'class' => Yii::$app->core->getRbacFilterClass(),
				'actions' => [
					'bulk' => [ 'permission' => $this->crudPermission ],
					'delete' => [ 'permission' => $this->crudPermission ]
				]
			],
			'verbs' => [
				'class' => VerbFilter::class,
				'actions' => [
					'bulk' => [ 'post' ],
					'delete' => [ 'post' ]
				]
			]
		];
	}

	// yii\base\Controller ----

	public function actions() {

		return [
			'bulk' => [ 'class' => 'cmsgears\core\common\actions\grid\Bulk' ],
			'delete' => [ 'class' => 'cmsgears\core\common\actions\grid\Delete' ]
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// FormController ------------------------

}
