<?php
namespace cmsgears\forms\common\services;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\forms\common\config\FormsGlobal;

use cmsgears\forms\common\models\entities\Form;

class FormService extends \cmsgears\core\common\services\Service {

	// Static Methods ----------------------------------------------

	// Read ----------------

	public static function findById( $id ) {

		return Form::findById( $id );
	}

	public static function findByName( $name ) {

		return Form::findById( $id );
	}

	// Data Provider ----

	/**
	 * @param array $config to generate query
	 * @return ActiveDataProvider
	 */
	public static function getPagination( $config = [] ) {

		return self::getDataProvider( new Form(), $config );
	}

	// Create -----------

	public static function create( $form ) {

		// Create Form
		$form->save();

		return $form;
	}

	// Update -----------

	public static function update( $form ) {

		$formToUpdate		= self::findById( $form->id );

		$formToUpdate->copyForUpdateFrom( $form, [ 'name', 'description', 'successMessage', 'jsonStorage', 'options' ] );

		$formToUpdate->update();

		return $formToUpdate;
	}

	// Delete -----------

	public static function delete( $form ) {

		$existingForm		= self::findById( $form->id );

		// Delete Form
		$existingForm->delete();

		return true;
	}
}

?>