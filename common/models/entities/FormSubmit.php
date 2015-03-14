<?php
namespace cmsgears\forms\common\models\entities;

// Yii Imports
use yii\db\ActiveRecord;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\forms\common\utilities\MessageUtil;

class FormSubmit extends ActiveRecord {

	// Instance Methods --------------------------------------------
	
	// db columns

	public function getId() {

		return $this->form_submit_id;
	}

	public function getFormId() {

		return $this->form_submit_parent;
	}

	public function setFormId( $formId ) {

		$this->form_submit_parent = $formId;
	}

	public function getForm() {

		return $this->hasOne( Form::className(), [ 'form_id' => 'form_submit_parent' ] );
	}

	public function getUserId() {

		return $this->form_submitted_by;
	}

	public function getUser() {

		return $this->hasOne( User::className(), [ 'user_id' => 'form_submited_by' ] );
	}

	public function setUserId( $userId ) {

		$this->form_submitted_by = $userId;
	}

	public function getSubmittedOn() {

		return $this->form_submitted_on;
	}

	public function setSubmittedOn( $submittedOn ) {

		$this->form_submitted_on = $submittedOn;
	}

	public function getFields() {

    	return $this->hasMany( FormSubmitField::className(), [ 'form_field_parent' => 'form_id' ] );
	}

	public function getFieldsMap() {
		
		$formFields 	= $this->fields;
		$formFieldsMap	= array();

		foreach ( $formFields as $formField ) {
			
			$formFieldsMap[ $formField->form_field_name ] =  $formField;
		}

    	return $formFieldsMap;
	}

	// Static Methods ----------------------------------------------

	public static function tableName() {

		return FormTables::TABLE_FORM_SUBMIT;
	}
}

?>