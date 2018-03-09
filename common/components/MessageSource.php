<?php
namespace cmsgears\forms\common\components;

// CMG Imports
use cmsgears\forms\common\config\FormsGlobal;

class MessageSource extends \yii\base\Component {

	// Variables ---------------------------------------------------

	// Global -----------------

	// Public -----------------

	// Protected --------------

	protected $messageDb = [
		// Generic Errors
		FormsGlobal::ERROR_RE_SUBMIT => 'The form is already submitted by you. It cannot be processed.',

		// Generic Fields
		FormsGlobal::FIELD_SUBMITTED_BY => 'Submitted By'
	];

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// CMG parent classes --------------------

	// MessageSource -------------------------

	public function getMessage( $messageKey, $params = [], $language = null ) {

		return $this->messageDb[ $messageKey ];
	}
}
