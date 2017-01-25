<?php
namespace cmsgears\forms\common\services\interfaces\entities;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

interface IFormService extends \cmsgears\core\common\services\interfaces\resources\IFormService {

	// Data Provider ------

	// Read ---------------

    // Read - Models ---

    // Read - Lists ----

    // Read - Maps -----

	// Create -------------

	public function processForm( $form, $formModel );

	// Update -------------

	// Delete -------------

}
