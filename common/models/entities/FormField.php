<?php
namespace cmsgears\forms\common\models\entities;

// Yii Imports
use yii\db\ActiveRecord;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\forms\common\utilities\MessageUtil;

class FormField extends ActiveRecord {

	// Instance Methods --------------------------------------------

	public function getForm() {

		return $this->hasOne( Form::className(), [ 'id' => 'parentId' ] );
	}

	public function getFormWithAlias() {

		return $this->hasOne( Form::className(), [ 'id' => 'parentId' ] )->from( FormTables::TABLE_FORM . ' frm' );
	}

	// yii\base\Model

	public function rules() {

        return [
            [ [ 'name' ], 'required' ],
			[ [ 'parentId', 'type', 'meta' ], 'safe' ]
        ];
    }

	public function attributeLabels() {

		return [
			'parentId' => 'Form',
			'name' => 'Name',
			'value' => 'Value',
			'type' => 'type',
			'meta' => 'Field Meta'
		];
	}

	// Static Methods ----------------------------------------------

	public static function tableName() {

		return FormTables::TABLE_FORM_FIELD;
	}

	// Category

	public static function findById( $id ) {

		return FormField::find()->where( 'id=:id', [ ':id' => $id ] )->one();
	}

	public static function findByName( $name ) {

		return FormField::find()->where( 'name=:name', [ ':name' => $name ] )->all();
	}

	public static function findByFormId( $formId ) {

		return FormField::find()->joinWith( 'formWithAlias' )->where( 'frm.id=:id', [ ':id' => $formId ] )->all();
	}
	
	public static function findByFormIdName( $formId, $name ) {

		return FormField::find()->joinWith( 'formWithAlias' )->where( 'frm.id=:id', [ ':id' => $formId ] )->andWhere( 'name=:name', [ ':name' => $name ] )->one();
	}
}

?>