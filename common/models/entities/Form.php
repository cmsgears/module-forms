<?php
namespace cmsgears\forms\common\models\entities;

// Yii Imports
use yii\db\ActiveRecord;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\forms\common\utilities\MessageUtil;

class Form extends ActiveRecord {

	// Instance Methods --------------------------------------------

	public function getFields() {

    	return $this->hasMany( FormField::className(), [ 'parentId' => 'id' ] );
	}

	public function getFieldsMap() {

		$formFields 	= $this->fields;
		$formFieldsMap	= array();

		foreach ( $formFields as $formField ) {

			$formFieldsMap[ $formField->name ] =  $formField;
		}

    	return $formFieldsMap;
	}

	// yii\base\Model

	public function rules() {

        return [
            [ [ 'name', 'message' ], 'required' ],
			[ [ 'parent', 'desc', 'type' ], 'safe' ]
        ];
    }

	public function attributeLabels() {

		return [
			'name' => 'Name',
			'message' => 'Success Message',
			'parent' => 'Parent',
			'desc' => 'Description',
			'type' => 'type'
		];
	}

	// Static Methods ----------------------------------------------

	public static function tableName() {

		return FormTables::TABLE_FORM;
	}

	// Category

	public static function findById( $id ) {

		return Form::find()->where( [ 'id' => $id ] )->one();
	}

	public static function findByName( $name ) {

		return Form::find()->where( 'name=:name', [ ':name' => $name ] )->one();
	}
}

?>