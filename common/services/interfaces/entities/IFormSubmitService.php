<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\forms\common\services\interfaces\entities;

// CMG Imports
use cmsgears\core\common\services\interfaces\base\IEntityService;

/**
 * IFormSubmitService declares methods specific to form submit.
 *
 * @since 1.0.0
 */
interface IFormSubmitService extends IEntityService {

	// Data Provider ------

	public function getPageByFormId( $formId );

	// Read ---------------

    // Read - Models ---

    public function findByFormIdSubmittedBy( $formId, $submittedBy );

    public function findFirstByFormIdSubmittedBy( $formId, $submittedBy );

    // Read - Lists ----

    // Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	// Delete -------------

	// Bulk ---------------

	// Notifications ------

	// Cache --------------

	// Additional ---------

}
