<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\forms\common\services\interfaces\resources;

// CMG Imports
use cmsgears\core\common\services\interfaces\base\IResourceService;

/**
 * IFormSubmitFieldService declares methods specific to form submit field.
 *
 * @since 1.0.0
 */
interface IFormSubmitFieldService extends IResourceService {

	// Data Provider ------

	// Read ---------------

    // Read - Models ---

    public function findByFormSubmitId( $formSubmitId );

    public function findByName( $formSubmitId, $name );

    // Read - Lists ----

    // Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	// Delete -------------

	public function deleteByFormSubmitId( $formSubmitId );

	// Bulk ---------------

	// Notifications ------

	// Cache --------------

	// Additional ---------

}
