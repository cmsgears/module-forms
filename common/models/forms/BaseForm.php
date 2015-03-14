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

	public function getClassAttributesArr() {

	  	$refclass	= new \ReflectionClass( $this );
		$attribArr	= array();

	  	foreach ( $refclass->getProperties() as $property ) {

			$name = $property->name;

	    	if ($property->class == $refclass->name) {

				$attribArr[ $name ] = $this->$name;
			}	
	  	}
		
		return $attribArr;
	}
	
	public function processFormSubmit( $form ) {

		$date		= DateUtil::getMysqlDate();

		// Save Form
		$formSubmit	= new FormSubmit();
		
		$formSubmit->setFormId( $form->getId() );
		$formSubmit->setSubmittedOn( $date );

		$formSubmit->save();
		
		// Get Form Submit Id
		$formSubmitId	= $formSubmit->getId();
		
		// Save Form Fields		
		$attrib 		= $this->getClassAttributesArr();
		
		foreach ( $attrib as $key => $value ) {

			$formSubmitField	= new FormSubmitField();
			
			$formSubmitField->setFormSubmitId( $formSubmitId );
			$formSubmitField->setName( $key );
			$formSubmitField->setValue( $value );
			
			$formSubmitField->save();
		}
	}
}

?>