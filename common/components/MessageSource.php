<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\forms\common\components;

// CMG Imports
use cmsgears\forms\common\config\FormsGlobal;

use cmsgears\core\common\base\MessageSource as BaseMessageSource;

/**
 * MessageSource stores and provide the messages and message templates available in
 * Cms Module.
 *
 * @since 1.0.0
 */
class MessageSource extends BaseMessageSource {

	// Variables ---------------------------------------------------

	// Global -----------------

	// Public -----------------

	// Protected --------------

	protected $messageDb = [
		// Generic Errors
		FormsGlobal::ERROR_RE_SUBMIT => 'The form is already submitted by you. It cannot be processed.',

		// Generic Fields
		// Field
		FormsGlobal::FIELD_SUBMITTED_BY => 'Submitted By'
	];

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// CMG parent classes --------------------

	// MessageSource -------------------------

}
