<?php
namespace cmsgears\forms\common\components;

// Yii Imports
use \Yii;
use yii\base\Component;

// CMG Imports
use cmsgears\forms\frontend\config\WebGlobalForms;

class MessageSource extends Component {

	// Variables ---------------------------------------------------

	private $messageDb = [
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

	public function getMessage( $messageKey, $params = [], $language = null ) {

		return $this->messageDb[ $messageKey ];
	}
}

?>