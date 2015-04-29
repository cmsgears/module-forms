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
 * @property string $value
 */
class FormSubmitField extends CmgEntity {

	// Instance Methods --------------------------------------------

	/**
	 * @return FormSubmit - the parent
	 */
	public function getFormSubmit() {

		return $this->hasOne( FormSubmit::className(), [ 'id' => 'parentId' ] );
	}

	/**
	 * @return FormSubmit - the parent having alias frmSubmit
	 */
	public function getFormSubmitWithAlias() {

		return $this->hasOne( FormSubmit::className(), [ 'id' => 'parentId' ] )->from( FormTables::TABLE_FORM_SUBMIT . ' frmSubmit' );
	}

	// yii\base\Model --------------------

	public function rules() {

        return [
            [ [ 'parentId', 'name' ], 'required' ],
			[ [ 'id', 'value' ], 'safe' ],
			[ 'name', 'string', 'min'=>1, 'max'=>100 ]
        ];
    }

	public function attributeLabels() {

		return [
			'parentId' => 'Parent Form Submit',
			'name' => 'Name',
			'value' => 'Value'
		];
	}

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord ---------------

	public static function tableName() {

		return FormTables::TABLE_FORM_SUBMIT_FIELD;
	}

	public static function findByFormSubmitId( $formSubmitId ) {

		return self::find()->joinWith( 'formSubmitWithAlias' )->where( 'frmSubmit.id=:id', [ ':id' => $formSubmitId ] )->all();
	}
}

?>