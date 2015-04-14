<?php
namespace cmsgears\forms\common\components;

// Yii Imports
use \Yii;
use yii\base\Component;

// CMG Imports
use cmsgears\forms\frontend\config\WebGlobalForms;

class MessageSourceForms extends Component {

	// Variables ---------------------------------------------------

	public $errorsDb = [
		// Errors - Generic
		// Messages - Generic
		WebGlobalForms::MESSAGE_CONTACT => 'Thanks for contacting us. We will contact you within next 48 hrs.',
		WebGlobalForms::MESSAGE_FEEDBACK => 'Thanks for providing your valuable.'
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