<?php
namespace cmsgears\forms\common\services;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\forms\common\models\entities\Form;

class FormService extends \cmsgears\core\common\services\Service {

	// Static Methods ----------------------------------------------

	// Read ----------------

	public static function findById( $id ) {

		return Form::findById( $id );
	}

	/**
	 * @param string $name
	 * @return Form
	 */
    public static function findByName( $name ) {

		return Form::findByName( $name );
    }

	/**
	 * @param string $slug
	 * @return Form
	 */
    public static function findBySlug( $slug ) {

		return Form::findBySlug( $slug );
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

		$formToUpdate->copyForUpdateFrom( $form, [ 'templateId', 'name', 'description', 'successMessage', 'jsonStorage', 'captcha', 'visibility', 'active', 'userMail', 'adminMail', 'options' ] );

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