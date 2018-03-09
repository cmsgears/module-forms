<?php
namespace cmsgears\forms\common\services\interfaces\resources;

interface IFormSubmitFieldService extends \cmsgears\core\common\services\interfaces\base\IEntityService {

	// Data Provider ------

	// Read ---------------

    // Read - Models ---

    public function findByFormSubmitId( $formSubmitId );

    public function findByName( $formSubmitId, $name );

    // Read - Lists ----

    // Read - Maps -----

	// Create -------------

	// Update -------------

	// Delete -------------

	public function deleteByFormSubmitId( $formSubmitId );
}
