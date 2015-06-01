<?php
namespace cmsgears\forms\common\models\entities;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\forms\common\config\FormsGlobal;

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

		return $this->hasOne( Form::className(), [ 'id' => 'parentId' ] )->from( FormTables::TABLE_FORM . ' frm' );
	}

	// yii\db\ActiveRecord ----------------

    /**
     * @inheritdoc
     */
	public function rules() {

        return [
            [ [ 'parentId', 'name' ], 'required' ],
			[ [ 'id', 'type', 'meta' ], 'safe' ]
        ];
    }

    /**
     * @inheritdoc
     */
	public function attributeLabels() {

		return [
			'parentId' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_PARENT ),
			'name' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_NAME ),
			'type' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_TYPE ),
			'meta' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_META )
		];
	}

	// Static Methods ----------------------------------------------

	// UserMeta ---------------------------

    /**
     * @inheritdoc
     */
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

		return FormField::find()->joinWith( 'form' )->where( 'frm.id=:id', [ ':id' => $formId ] )->all();
	}

	public static function findByFormIdName( $formId, $name ) {

		return self::find()->joinWith( 'form' )->where( 'frm.id=:id and name=:name', [ ':id' => $formId, ':name' => $name ] )->one();
	}
}

?>