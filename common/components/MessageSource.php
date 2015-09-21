<?php
namespace cmsgears\forms\common\components;

// Yii Imports
use \Yii;
use yii\base\Component;

// CMG Imports
use cmsgears\forms\common\config\FormsGlobal;

use cmsgears\forms\frontend\config\WebGlobalForms;

class MessageSource extends Component {

	// Variables ---------------------------------------------------

	private $messageDb = [
		// Model Fields ----------------------------------------------------
		// Generic Fields
		FormsGlobal::FIELD_FORM => 'Form',
		FormsGlobal::FIELD_SUBMITTED_BY => 'Submitted By',
		FormsGlobal::FIELD_CAPTCHA => 'Captcha',
		FormsGlobal::FIELD_MAIL_USER => 'User Mail',
		FormsGlobal::FIELD_MAIL_ADMIN => 'Admin Mail'
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