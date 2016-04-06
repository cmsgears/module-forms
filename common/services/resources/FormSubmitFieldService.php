<?php
namespace cmsgears\forms\common\services\resources;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\forms\common\models\resources\FormSubmitField;

class FormSubmitFieldService extends \cmsgears\core\common\services\base\Service {

	// Static Methods ----------------------------------------------

	// Read ----------------

	public static function findById( $id ) {

		return FormSubmitField::findById( $id );
	}

	// Data Provider ----

	/**
	 * @param array $config to generate query
	 * @return ActiveDataProvider
	 */
	public static function getPagination( $config = [] ) {

		return self::getDataProvider( new FormSubmitField(), $config );
	}

	// Delete -----------

	public static function delete( $field ) {

		$existingField		= self::findById( $field->id );

		// Delete Model
		$existingField->delete();

		return true;
	}

	public static function deleteByFormSubmitId( $formSubmitId ) {

		FormSubmitField::deleteByFormSubmitId( $formSubmitId );

		return true;
	}
}

?>