<?php
namespace cmsgears\forms\common\models\forms;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\forms\common\models\entities\FormSubmit;
use cmsgears\forms\common\models\resources\FormSubmitField;

use cmsgears\core\common\utilities\DateUtil;

/**
 * The base class to be used by dynamic forms.
 */
class GenericForm extends \cmsgears\core\common\models\forms\GenericForm {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Model ---------

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	// GenericForm ---------------------------

	/**
	 * The method process the submitted form and save all the form fields except captcha field.
	 */
	public function processFormSubmit( $form ) {

		$date		= DateUtil::getDateTime();

		$attributes	= parent::getFormAttributes();

		$fields		= $attributes[ 'fields' ];
		$attribs	= [];
		$user		= Yii::$app->user->getIdentity();

		$formSubmit		= new FormSubmit();

		$formSubmit->formId 		= $form->id;
		$formSubmit->submittedAt	= $date;

		if( isset( $user ) ) {

			$formSubmit->submittedBy	= $user->id;
		}

		// Collect fields to save in json format
		foreach ( $fields as $field ) {

			$fieldName	= $field->name;

			// Convert CheckBox array to csv
			if( $field->isCheckboxGroup() ) {

				$this->$fieldName	= join( ",", $this->$fieldName );
			}

			if( $field->compress ) {

				$attribs[ $field->name ]	= $this->$fieldName;
			}
		}

		$formSubmit->data	= json_encode( $attribs );

		// save form submit
		$formSubmit->save();

		// Get Form Submit Id
		$formSubmitId	= $formSubmit->id;

		// Save Form Fields
		foreach ( $fields as $field ) {

			if( !$field->compress ) {

				$formSubmitField	= new FormSubmitField();

				$formSubmitField->formSubmitId 	= $formSubmitId;
				$formSubmitField->name			= $field->name;
				$fieldName						= $field->name;
				$formSubmitField->value			= $this->$fieldName;

				$formSubmitField->save();
			}
		}

		return $formSubmit;
	}
}

?>