<?php
namespace cmsgears\forms\common\services\interfaces\entities;

interface IFormSubmitService extends \cmsgears\core\common\services\interfaces\base\IEntityService {

	// Data Provider ------

	public function getPageByFormId( $formId );

	// Read ---------------

    // Read - Models ---

    public function findByFormIdSubmittedBy( $formId, $submittedBy );

    public function findFirstByFormIdSubmittedBy( $formId, $submittedBy );

    // Read - Lists ----

    // Read - Maps -----

	// Create -------------

	// Update -------------

	// Delete -------------

}
