<?php
namespace cmsgears\forms\common\models\entities;

// Yii Imports
use \Yii;
use yii\validators\FilterValidator;
use yii\helpers\ArrayHelper;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

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

	// yii\base\Model --------------------

    /**
     * @inheritdoc
     */
	public function rules() {

		$trim		= [];

		if( Yii::$app->cmgCore->trimFieldValue ) {

			$trim[] = [ [ 'name', 'value' ], 'filter', 'filter' => 'trim', 'skipOnArray' => true ];
		}

        $rules = [
            [ [ 'parentId', 'name' ], 'required' ],
			[ [ 'id', 'value' ], 'safe' ],
			[ 'name', 'string', 'min'=>1, 'max'=>100 ]
        ];

		if( Yii::$app->cmgCore->trimFieldValue ) {

			return ArrayHelper::merge( $trim, $rules );
		}

		return $rules;
    }

    /**
     * @inheritdoc
     */
	public function attributeLabels() {

		return [
			'parentId' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_PARENT ),
			'name' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_NAME ),
			'value' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_VALUE )
		];
	}

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord ---------------

    /**
     * @inheritdoc
     */
	public static function tableName() {

		return FormTables::TABLE_FORM_SUBMIT_FIELD;
	}

	// FormSubmitField -------------------

	public static function findByFormSubmitId( $formSubmitId ) {

		$frmSubmitTable	= FormTables::TABLE_FORM_SUBMIT;

		return self::find()->joinWith( 'formSubmit' )->where( "$frmSubmitTable.id=:id", [ ':id' => $formSubmitId ] )->all();
	}
}

?>