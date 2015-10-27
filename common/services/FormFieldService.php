<?php
namespace cmsgears\forms\common\services;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\forms\common\config\FormsGlobal;

use cmsgears\forms\common\models\entities\FormField;

class FormFieldService extends \cmsgears\core\common\services\Service {

	// Static Methods ----------------------------------------------

	// Read ----------------

	public static function findById( $id ) {

		return FormField::findById( $id );
	}

	// Data Provider ----

	/**
	 * @param array $config to generate query
	 * @return ActiveDataProvider
	 */
	public static function getPagination( $config = [] ) {

		return self::getDataProvider( new FormField(), $config );
	}

	// Create -----------

	public static function create( $formField ) {

		// Create Model
		$formField->save();

		return $formField;
	}

	// Update -----------

	public static function update( $formField ) {

		$formFieldToUpdate		= self::findById( $formField->id );

		$formFieldToUpdate->copyForUpdateFrom( $formField, [ 'name', 'label', 'type', 'validators', 'options', 'meta' ] );

		$formFieldToUpdate->update();

		return $formFieldToUpdate;
	}

	// Delete -----------

	public static function delete( $formField ) {

		$existingFormField		= self::findById( $formField->id );

		// Delete Model
		$existingFormField->delete();

		return true;
	}
}

?>