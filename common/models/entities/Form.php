<?php
namespace cmsgears\forms\common\models\entities;

// Yii Imports
use yii\db\ActiveRecord;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\forms\common\utilities\MessageUtil;

class Form extends ActiveRecord {

	// Instance Methods --------------------------------------------
	
	// db columns

	public function getId() {

		return $this->form_id;
	}

	public function getName() {

		return $this->form_name;
	}

	public function setName( $name ) {

		$this->form_name = $name;
	}

	public function getMessage() {

		return $this->form_message;
	}

	public function setMessage( $message ) {

		$this->form_message = $message;
	}

	public function getFields() {

    	return $this->hasMany( FormField::className(), [ 'form_field_parent' => 'form_id' ] );
	}

	public function getFieldsMap() {
		
		$formFields 	= $this->fields;
		$formFieldsMap	= array();

		foreach ( $formFields as $formField ) {
			
			$formFieldsMap[ $formField->form_field_name ] =  $formField;
		}

    	return $formFieldsMap;
	}

	// yii\base\Model

	public function rules() {

        return [
            [ [ 'form_name', 'form_message' ], 'required' ],
			[ [ 'form_parent', 'form_desc', 'form_type' ], 'safe' ]
        ];
    }

	public function attributeLabels() {

		return [
			'form_name' => 'Name',
			'form_message' => 'Success Message',
			'form_parent' => 'Parent',
			'form_desc' => 'Description',
			'form_type' => 'type'
		];
	}

	// Static Methods ----------------------------------------------

	public static function tableName() {

		return FormTables::TABLE_FORM;
	}

	// Category

	public static function findById( $id ) {

		return Form::find()->where( [ 'form_id' => $id ] )->one();
	}

	public static function findByName( $name ) {

		return Form::find()->where( 'form_name=:name', [ ':name' => $name ] )->one();
	}
}

?>