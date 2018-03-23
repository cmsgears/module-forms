<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\forms\common\components;

// Yii Imports
use Yii;
use yii\base\Component;

/**
 * Form component register the services provided by Form Module.
 *
 * @since 1.0.0
 */
class Form extends Component {

	// Global -----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	/**
	 * Initialize the services.
	 */
	public function init() {

		parent::init();

		// Register components and objects
		$this->registerComponents();
	}

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// CMG parent classes --------------------

	// Form ----------------------------------

	// Properties ----------------

	// Components and Objects ----

	/**
	 * Register the services.
	 */
	public function registerComponents() {

		// Register services
		$this->registerResourceServices();
		$this->registerEntityServices();

		// Init services
		$this->initResourceServices();
		$this->initEntityServices();
	}

	/**
	 * Registers resource services.
	 */
	public function registerResourceServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'cmsgears\forms\common\services\interfaces\resources\IFormSubmitFieldService', 'cmsgears\forms\common\services\resources\FormSubmitFieldService' );
	}

	/**
	 * Registers entity services.
	 */
	public function registerEntityServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'cmsgears\forms\common\services\interfaces\entities\IFormService', 'cmsgears\forms\common\services\entities\FormService' );
		$factory->set( 'cmsgears\forms\common\services\interfaces\entities\IFormSubmitService', 'cmsgears\forms\common\services\entities\FormSubmitService' );
	}

	/**
	 * Initialize resource services.
	 */
	public function initResourceServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'formSubmitFieldService', 'cmsgears\forms\common\services\resources\FormSubmitFieldService' );
	}

	/**
	 * Initialize entity services.
	 */
	public function initEntityServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'formService', 'cmsgears\forms\common\services\entities\FormService' );
		$factory->set( 'formSubmitService', 'cmsgears\forms\common\services\entities\FormSubmitService' );
	}

}
