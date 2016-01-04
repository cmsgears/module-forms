<?php
namespace cmsgears\forms\common\services;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\forms\common\models\entities\FormSubmit;

use cmsgears\forms\common\services\FormSubmitFieldService;

class FormSubmitService extends \cmsgears\core\common\services\Service {

	// Static Methods ----------------------------------------------

	// Read ----------------

	public static function findById( $id ) {

		return FormSubmit::findById( $id );
	}

	// Data Provider ----

	/**
	 * @param array $config to generate query
	 * @return ActiveDataProvider
	 */
	public static function getPagination( $config = [] ) {

		return self::getDataProvider( new FormSubmit(), $config );
	}

	// Delete -----------

	public static function delete( $formSubmit ) {

		$existingFormSubmit		= self::findById( $formSubmit->id );

		// Delete Dependency
		FormSubmitFieldService::deleteByFormSubmitId( $existingFormSubmit->id );

		// Delete Model
		$existingFormSubmit->delete();

		return true;
	}
}

?>