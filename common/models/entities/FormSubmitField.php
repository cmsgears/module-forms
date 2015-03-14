<?php
namespace cmsgears\forms\common\models\entities;

// Yii Imports
use yii\db\ActiveRecord;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\forms\common\utilities\MessageUtil;

class FormSubmitField extends ActiveRecord {

	// Instance Methods --------------------------------------------

	// db columns

	public function getId() {

		return $this->form_submit_field_id;
	}

	public function getFormSubmitId() {

		return $this->form_submit_field_parent;
	}

	public function getFormSubmit() {

		return $this->hasOne( FormSubmit::className(), [ 'form_submit_id' => 'form_submit_field_parent' ] );
	}

	public function setFormSubmitId( $formSubmitId ) {

		$this->form_submit_field_parent = $formSubmitId;
	}

	public function getName() {

		return $this->form_submit_field_name;
	}

	public function setName( $name ) {

		$this->form_submit_field_name = $name;
	}

	public function getValue() {

		return $this->form_submit_field_value;
	}

	public function setValue( $value ) {

		$this->form_submit_field_value = $value;
	}

	// Static Methods ----------------------------------------------

	public static function tableName() {

		return FormTables::TABLE_FORM_SUBMIT_FIELD;
	}

	public static function findByFormSubmitId( $formSubmitId ) {

		return FormField::find()->joinWith( 'formSubmit' )->where( 'form_submit_id=:id', [ ':id' => $formSubmitId ] )->all();
	}
}

?>