<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\forms\common\models\forms;

// Yii Imports
use Yii;
use yii\web\ForbiddenHttpException;

// CMG Imports
use cmsgears\forms\common\config\FormsGlobal;

use cmsgears\core\common\models\forms\GenericForm as ParentGenericForm;
use cmsgears\forms\common\models\entities\FormSubmit;
use cmsgears\forms\common\models\resources\FormSubmitField;

use cmsgears\core\common\utilities\DateUtil;

/**
 * The base class to be used by dynamic forms.
 */
class GenericForm extends ParentGenericForm {

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
	 * Process the submitted form and save all the form fields except captcha field.
	 *
	 * @throws \yii\web\ForbiddenHttpException
	 * @param \cmsgears\core\common\models\resources\Form $form
	 * @return void
	 */
	public function processFormSubmit( $form ) {

		$date		= DateUtil::getDateTime();

		$attributes	= parent::getFormAttributes();

		$fields		= $attributes[ 'fields' ];
		$attribs	= [];
		$user		= Yii::$app->user->getIdentity();

		$formSubmit	= new FormSubmit();

		$formSubmit->formId 		= $form->id;
		$formSubmit->submittedAt	= $date;

		if( isset( $user ) ) {

			$formSubmit->submittedBy = $user->id;
		}

		// Collect fields to save in json format
		foreach ( $fields as $field ) {

			$fieldName = $field->name;

			// Convert CheckBox array to csv
			if( $field->isCheckboxGroup() ) {

				$this->$fieldName = join( ",", $this->$fieldName );
			}

			if( $field->compress ) {

				$attribs[ $field->name ] = $this->$fieldName;
			}
		}

		$formSubmit->data = json_encode( $attribs );

		// Create/Update form submit
		if( $form->uniqueSubmit ) {

			// Find existing form submit
			$existingFormSubmit	= Yii::$app->factory->get( 'formSubmitService' )->findFirstByFormIdSubmittedBy( $formSubmit->formId, $formSubmit->submittedBy );

			if( isset( $existingFormSubmit ) ) {

				// Over write existing submit
				if( $form->updateSubmit ) {

					// update form submit
					$existingFormSubmit->submittedAt = $formSubmit->submittedAt;

					$existingFormSubmit->update();

					$formSubmit	= $existingFormSubmit;
				}
				// Throw error
				else {

					throw new ForbiddenHttpException( Yii::$app->coreMessage->getMessage( FormsGlobal::ERROR_RE_SUBMIT ) );
				}
			}
			else {

				// save form submit
				$formSubmit->save();
			}
		}
		else {

			// save form submit
			$formSubmit->save();
		}

		// Create/Update form submit fields
		if( $formSubmit->id > 0 ) {

			// Save Form Fields
			foreach ( $fields as $field ) {

				$fieldName = $field->name;

				if( !$field->compress ) {

					$formSubmitField = Yii::$app->factory->get( 'formSubmitFieldService' )->findByName( $formSubmit->id, $fieldName );

					if( isset( $formSubmitField ) ) {

						$formSubmitField->value = $this->$fieldName;

						$formSubmitField->update();
					}
					else {

						$formSubmitField = new FormSubmitField();

						$formSubmitField->formSubmitId 	= $formSubmit->id;
						$formSubmitField->name			= $field->name;
						$fieldName						= $field->name;
						$formSubmitField->value			= $this->$fieldName;

						$formSubmitField->save();
					}
				}
			}
		}

		return $formSubmit;
	}
}
