<?php
namespace cmsgears\forms\frontend\services;

// Yii Imports
use \Yii;
use yii\base\Model;

// Project Imports
use cmsgears\forms\common\config\FormsGlobal;

use cmsgears\forms\common\models\entities\Form;

class FormService extends \cmsgears\forms\common\services\FormService {

	// Static Methods ----------------------------------------------

	// Update --------------

    public static function processContactForm( $contactForm ) {

		$form 		= Form::findByName( FormsGlobal::FORM_CONTACT );

		// Save Form
		$formSubmit = $contactForm->processFormSubmit( $form );

		return $formSubmit;
    }

    public static function processFeedbackForm( $feedbackForm ) {

		$form 		= Form::findByName( FormsGlobal::FORM_FEEDBACK );

		// Save Form
		$formSubmit = $feedbackForm->processFormSubmit( $form );

		return $formSubmit;
    }
}

?>