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
		FormsGlobal::FIELD_SUBMITTED_BY => 'Submitted By'
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