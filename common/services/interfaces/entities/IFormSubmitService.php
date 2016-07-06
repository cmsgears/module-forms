<?php
namespace cmsgears\forms\common\services\interfaces\entities;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

interface IFormSubmitService extends \cmsgears\core\common\services\interfaces\base\IEntityService {

	// Data Provider ------

	public function getPageByFormId( $formId );

	// Read ---------------

    // Read - Models ---

    // Read - Lists ----

    // Read - Maps -----

	// Create -------------

	// Update -------------

	// Delete -------------

}
