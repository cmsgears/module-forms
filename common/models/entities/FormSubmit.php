<?php
namespace cmsgears\forms\common\models\entities;

// Yii Imports
use yii\db\ActiveRecord;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\forms\common\utilities\MessageUtil;

class FormSubmit extends ActiveRecord {

	// Instance Methods --------------------------------------------

	public function getForm() {

		return $this->hasOne( Form::className(), [ 'id' => 'parentId' ] );
	}

	public function getFormWithAlias() {

		return $this->hasOne( Form::className(), [ 'id' => 'parentId' ] )->from( FormTables::TABLE_FORM . ' frm' );
	}

	public function getUser() {

		return $this->hasOne( User::className(), [ 'id' => 'submittedBy' ] );
	}

	public function getFields() {

    	return $this->hasMany( FormSubmitField::className(), [ 'parentId' => 'id' ] );
	}

	public function getFieldsMap() {
		
		$formFields 	= $this->fields;
		$formFieldsMap	= array();

		foreach ( $formFields as $formField ) {
			
			$formFieldsMap[ $formField->name ] =  $formField;
		}

    	return $formFieldsMap;
	}

	// Static Methods ----------------------------------------------

	public static function tableName() {

		return FormTables::TABLE_FORM_SUBMIT;
	}
}

?>