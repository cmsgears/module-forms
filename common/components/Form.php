<?php
namespace cmsgears\forms\common\components;

// Yii Imports
use \Yii;
use yii\di\Container;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

class Form extends \yii\base\Component {

	// Global -----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

    /**
     * Initialise the CMG Core Component.
     */
    public function init() {

        parent::init();

		// Register application components and objects i.e. CMG and Project
		$this->registerComponents();
    }

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// CMG parent classes --------------------

	// Core ----------------------------------

	// Properties

	// Components and Objects

	public function registerComponents() {

		// Init system services
		$this->initSystemServices();

		// Register services
		$this->registerResourceServices();
		$this->registerEntityServices();

		// Init services
		$this->initResourceServices();
		$this->initEntityServices();
	}

	public function initSystemServices() {

		$factory = Yii::$app->factory->getContainer();

		//$factory->set( '<name>', '<classpath>' );
	}

	public function registerResourceServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'cmsgears\forms\common\services\interfaces\resources\IFormSubmitFieldService', 'cmsgears\forms\common\services\resources\FormSubmitFieldService' );
	}

	public function registerEntityServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'cmsgears\forms\common\services\interfaces\entities\IFormSubmitService', 'cmsgears\forms\common\services\entities\FormSubmitService' );
	}

	public function initResourceServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'formSubmitFieldService', 'cmsgears\forms\common\services\resources\FormSubmitFieldService' );
	}

	public function initEntityServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'formSubmitService', 'cmsgears\forms\common\services\entities\FormSubmitService' );
	}
}
