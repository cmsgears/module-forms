<?php
namespace cmsgears\forms\common\components;

// Yii Imports
use \Yii;
use yii\base\Component;

class MessageDbForms extends Component {

	// Errors - Generic

	// Messages - Generic
	const MESSAGE_CONTACT 			= "contactMessage";
	const MESSAGE_FEEDBACK 			= "feedbackMessage";

	// Variables ---------------------------------------------------

	public $errorsDb = [
		// Errors - Generic
		// Messages - Generic
		self::MESSAGE_CONTACT => 'Thanks for contacting us. We will contact you within next 48 hrs.',
		self::MESSAGE_FEEDBACK => 'Thanks for providing your valuable.'
	];

	/**
	 * Initialise the Forms Message DB Component.
	 */
    public function init() {

        parent::init();
    }

	public function getMessage( $messageKey ) {

		return $this->errorsDb[ $messageKey ];
	}
}

?>