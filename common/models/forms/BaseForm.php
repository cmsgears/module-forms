<?php
namespace cmsgears\forms\common\models\forms;

// Yii Imports
use \Yii;
use yii\base\Model;

// CMG Imports
use cmsgears\forms\common\models\entities\FormSubmit;
use cmsgears\forms\common\models\entities\FormSubmitField;

use cmsgears\core\common\utilities\DateUtil;

/**
 * The base class to be used by dynamic forms.
 */
class BaseForm extends Model {

	/**
	 * The method collect the list of class members and their values using reflection.
	 * return array - list of class members and their value
	 */
	public function getClassAttributesArr() {

	  	$refclass	= new \ReflectionClass( $this );
		$attribArr	= array();

	  	foreach ( $refclass->getProperties() as $property ) {

			$name = $property->name;

	    	if ( $property->class == $refclass->name ) {

				$attribArr[ $name ] = $this->$name;
			}	
	  	}

		return $attribArr;
	}

	/**
	 * The method process the submitted form and save all the form fields except captcha field.
	 */
	public function processFormSubmit( $form ) {

		$date		= DateUtil::getDateTime();
		$fields 	= $this->getClassAttributesArr();
		$fields		= $fields[ 'fields' ];

		// Save Form
		$formSubmit		= new FormSubmit();

		$formSubmit->formId 		= $form->id;
		$formSubmit->submittedAt	= $date;
		$formSubmit->jsonStorage	= false;

		if( $form->jsonStorage ) {


			$attribs					= [];

			foreach ( $fields as $field ) {
				
				$fieldName					= $field->name;
				$attribs[ $field->name ]	= $this->$fieldName;
			}

			$formSubmit->jsonStorage	= true;
			$formSubmit->data			= json_encode( $attribs );
		}

		$formSubmit->save();

		if( !$form->jsonStorage ) {

			// Get Form Submit Id
			$formSubmitId	= $formSubmit->id;

			// Save Form Fields
			foreach ( $fields as $field ) {

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