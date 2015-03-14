<?php
namespace cmsgears\forms\common\models\entities;

// Yii Imports
use yii\db\ActiveRecord;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\forms\common\utilities\MessageUtil;

class FormField extends ActiveRecord {

	// Instance Methods --------------------------------------------

	// db columns

	public function getId() {

		return $this->form_field_id;
	}

	public function getFormId() {

		return $this->form_field_parent;
	}

	public function getForm() {

		return $this->hasOne( Form::className(), [ 'form_id' => 'form_field_parent' ] );
	}

	public function setFormId( $formId ) {

		$this->form_field_parent = $formId;
	}

	public function getName() {

		return $this->form_field_name;
	}

	public function setName( $name ) {

		$this->form_field_name = $name;
	}

	public function getValue() {

		return $this->form_field_value;
	}

	public function setValue( $value ) {

		$this->form_field_value = $value;
	}

	// yii\base\Model

	public function rules() {

        return [
            [ [ 'form_field_name' ], 'required' ],
			[ [ 'form_field_parent', 'form_field_type', 'form_field_meta' ], 'safe' ]
        ];
    }

	public function attributeLabels() {

		return [
			'form_field_parent' => 'Form',		
			'form_field_name' => 'Name',
			'form_field_value' => 'Value',
			'form_field_type' => 'type',
			'form_field_meta' => 'Field Meta'
		];
	}

	// Static Methods ----------------------------------------------

	public static function tableName() {

		return FormTables::TABLE_FORM_FIELD;
	}

	// Category

	public static function findById( $id ) {

		return FormField::find()->where( 'form_field_id=:id', [ ':id' => $id ] )->one();
	}

	public static function findByName( $name ) {

		return FormField::find()->where( 'form_field_name=:name', [ ':name' => $name ] )->all();
	}

	public static function findByFormId( $formId ) {

		return FormField::find()->joinWith( 'form' )->where( 'form_id=:id', [ ':id' => $formId ] )->all();
	}
	
	public static function findByFormIdName( $formId, $name ) {

		return FormField::find()->joinWith( 'form' )->where( 'form_id=:id', [ ':id' => $formId ] )->andWhere( 'form_field_name=:name', [ ':name' => $name ] )->one();
	}
}

?>