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

		$date			= DateUtil::getMysqlDate();

		// Save Form
		$formSubmit		= new FormSubmit();

		$formSubmit->parentId 		= $form->id;
		$formSubmit->submittedOn	= $date;

		$formSubmit->save();

		// Get Form Submit Id
		$formSubmitId	= $formSubmit->id;

		// Save Form Fields
		$attrib 		= $this->getClassAttributesArr();

		foreach ( $attrib as $key => $value ) {
			
			if( strcmp( $key, 'captcha' ) != 0 ) {

				$formSubmitField	= new FormSubmitField();
	
				$formSubmitField->parentId 	= $formSubmitId;
				$formSubmitField->name		= $key;
				$formSubmitField->value		= $value;
	
				$formSubmitField->save();
			}	
		}
	}
}

?>