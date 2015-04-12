<?php
namespace cmsgears\forms\common\services;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\forms\common\models\entities\Form;

use cmsgears\core\common\services\Service;

class FormService extends Service {

	// Static Methods ----------------------------------------------

	// Read ----------------

	public static function findByName( $formName ) {

		return Form::findByName( $formName );
	}
}

?>