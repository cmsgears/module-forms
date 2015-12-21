<?php
namespace cmsgears\forms\common\models\entities;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\forms\common\config\FormsGlobal;

/**
 * FormSubmitField Entity
 *
 * @property integer $id
 * @property integer $formId
 * @property integer $submittedBy
 * @property datetime $submittedAt
 * @property string $data
 */
class FormSubmit extends \cmsgears\core\common\models\entities\CmgEntity {

	// Instance Methods --------------------------------------------

	/**
	 * @return Form
	 */
	public function getForm() {

		return $this->hasOne( Form::className(), [ 'id' => 'formId' ] );
	}

	/**
	 * @return User - who submitted the form
	 */
	public function getUser() {

		return $this->hasOne( User::className(), [ 'id' => 'submittedBy' ] );
	}

	/**
	 * @return array - list of FormSubmitField
	 */
	public function getFields() {

    	return $this->hasMany( FormSubmitField::className(), [ 'formSubmitId' => 'id' ] );
	}

	/**
	 * @return array - map of FormSubmitField having field name as key
	 */
	public function getFieldsMap() {

		$formFields 	= $this->fields;
		$formFieldsMap	= array();

		foreach ( $formFields as $formField ) {

			$formFieldsMap[ $formField->name ] =  $formField;
		}

    	return $formFieldsMap;
	}

	// yii\base\Model --------------------

    /**
     * @inheritdoc
     */
	public function rules() {

        return [
            [ [ 'formId' ], 'required' ],
			[ [ 'id', 'data' ], 'safe' ],
			[ [ 'formId', 'submittedBy' ], 'number', 'integerOnly' => true, 'min' => 1 ],
			[ [ 'submittedAt' ], 'date', 'format' => Yii::$app->formatter->datetimeFormat ]
        ];
    }

    /**
     * @inheritdoc
     */
	public function attributeLabels() {

		return [
			'formId' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_PARENT ),
			'submittedBy' => Yii::$app->cmgFormsMessage->getMessage( FormsGlobal::FIELD_SUBMITTED_BY ),
			'data' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_DATA )
		];
	}

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord ----------------

	public static function tableName() {

		return FormTables::TABLE_FORM_SUBMIT;
	}

	// FormSubmit ------------------------

	public static function findWithForm() {

		return self::find()->joinWith( 'form' );
	}

	public static function findWithFormUser() {

		return self::find()->joinWith( 'form' )->joinWith( 'user' );
	}
}

?>