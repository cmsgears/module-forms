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

// CMG Imports
use cmsgears\core\common\base\Component;

/**
 * The Form Factory component initialise the services available in Form Module.
 *
 * @since 1.0.0
 */
class Factory extends Component {

	// Global -----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		// Register services
		$this->registerServices();

		// Register service alias
		$this->registerServiceAlias();
	}

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// CMG parent classes --------------------

	// Factory -------------------------------

	public function registerServices() {

		$this->registerResourceServices();
		$this->registerEntityServices();
	}

	public function registerServiceAlias() {

		$this->registerResourceAliases();
		$this->registerEntityAliases();
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
	 * Registers resource aliases.
	 */
	public function registerResourceAliases() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'formSubmitFieldService', 'cmsgears\forms\common\services\resources\FormSubmitFieldService' );
	}

	/**
	 * Registers entity aliases.
	 */
	public function registerEntityAliases() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'formService', 'cmsgears\forms\common\services\entities\FormService' );
		$factory->set( 'formSubmitService', 'cmsgears\forms\common\services\entities\FormSubmitService' );
	}

}
