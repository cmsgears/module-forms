<?php
namespace cmsgears\forms\common\models\entities;

// CMG Imports
use cmsgears\core\common\models\entities\CmgEntity;

/**
 * FormSubmitField Entity
 *
 * @property integer $id
 * @property integer $parentId
 * @property string $name
 * @property short $type
 * @property string $meta
 */
class FormField extends CmgEntity {

	const TYPE_TEXT			= 1;
	const TYPE_TEXTAREA		= 2;
	const TYPE_CHECKBOX		= 3;
	const TYPE_RADIO		= 4;
	const TYPE_SELECT		= 5;

	// Instance Methods --------------------------------------------

	/**
	 * @return Form
	 */
	public function getForm() {

		return $this->hasOne( Form::className(), [ 'id' => 'parentId' ] );
	}

	/**
	 * @return Form having alias frm
	 */
	public function getFormWithAlias() {

		return $this->hasOne( Form::className(), [ 'id' => 'parentId' ] )->from( FormTables::TABLE_FORM . ' frm' );
	}

	// yii\db\ActiveRecord ----------------

	public function rules() {

        return [
            [ [ 'parentId', 'name' ], 'required' ],
			[ [ 'id', 'type', 'meta' ], 'safe' ]
        ];
    }

	public function attributeLabels() {

		return [
			'parentId' => 'Parent Form',
			'name' => 'Name',
			'type' => 'type',
			'meta' => 'Field Meta'
		];
	}

	// Static Methods ----------------------------------------------

	// UserMeta ---------------------------

	public static function tableName() {

		return FormTables::TABLE_FORM_FIELD;
	}

	// FormField --------------------------

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

		return self::find()->joinWith( 'formWithAlias' )->where( 'frm.id=:id and name=:name', [ ':id' => $formId, ':name' => $name ] )->one();
	}
}

?>