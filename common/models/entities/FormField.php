<?php
namespace cmsgears\forms\common\models\entities;

// Yii Imports
use \Yii;
use yii\validators\FilterValidator;
use yii\helpers\ArrayHelper;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\forms\common\config\FormsGlobal;

/**
 * FormSubmitField Entity
 *
 * @property integer $id
 * @property integer $formId
 * @property string $name
 * @property string $label
 * @property short $type
 * @property short $options
 * @property string $meta
 */
class FormField extends \cmsgears\core\common\models\entities\CmgEntity {

	const TYPE_TEXT			= 1;
	const TYPE_TEXTAREA		= 5;
	const TYPE_CHECKBOX		=10;
	const TYPE_RADIO		=15;
	const TYPE_SELECT		=20;
	const TYPE_RATING		=25;

	public static $typeMap = [
		self::TYPE_TEXT => 'Text Input',
		self::TYPE_TEXTAREA => 'Textarea',
		self::TYPE_CHECKBOX => 'Checkbox',
		self::TYPE_RADIO => 'Radio',
		self::TYPE_SELECT => 'Select',
		self::TYPE_RATING => 'Rating'
	];

	// Instance Methods --------------------------------------------

	/**
	 * @return Form
	 */
	public function getForm() {

		return $this->hasOne( Form::className(), [ 'id' => 'formId' ] );
	}

	public function getTypeStr() {

		return self::$typeMap[ $this->type ];
	}

	// yii\db\ActiveRecord ----------------

    /**
     * @inheritdoc
     */
	public function rules() {

		$trim		= [];

		if( Yii::$app->cmgCore->trimFieldValue ) {

			$trim[] = [ [ 'name', 'label' ], 'filter', 'filter' => 'trim', 'skipOnArray' => true ];
		}

        $rules = [
            [ [ 'formId', 'name' ], 'required' ],
			[ [ 'id', 'label', 'type', 'meta', 'options' ], 'safe' ],
            [ 'name', 'validateNameCreate', 'on' => [ 'create' ] ],
            [ 'name', 'validateNameUpdate', 'on' => [ 'update' ] ]
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
			'formId' => Yii::$app->cmgFormsMessage->getMessage( FormsGlobal::FIELD_FORM ),
			'name' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_NAME ),
			'type' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_TYPE ),
			'meta' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_META ),
			'options' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_OPTIONS )
		];
	}

	// FormField -------------------------

	/**
	 * Validates whether a province existing with the same name for same country.
	 */
    public function validateNameCreate( $attribute, $params ) {

        if( !$this->hasErrors() ) {

            if( self::isExistByNameFormId( $this->name, $this->formId ) ) {

                $this->addError( $attribute, Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_EXIST ) );
            }
        }
    }

	/**
	 * Validates whether a province existing with the same name for same country.
	 */
    public function validateNameUpdate( $attribute, $params ) {

        if( !$this->hasErrors() ) {

			$existingField = self::findByNameFormId( $this->name, $this->formId );

			if( isset( $existingField ) && $this->formId == $existingField->formId && 
				$this->id != $existingField->id && strcmp( $existingField->name, $this->name ) == 0 ) {

				$this->addError( $attribute, Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_EXIST ) );
			}
        }
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

	public static function findByFormId( $formId ) {

		$frmTable = FormTables::TABLE_FORM;

		return FormField::find()->joinWith( 'form' )->where( "$frmTable.id=:id", [ ':id' => $formId ] )->all();
	}

	public static function findByNameFormId( $name, $formId ) {

		return self::find()->where( "formId=:id and name=:name", [ ':id' => $formId, ':name' => $name ] )->one();
	}

	public static function isExistByNameFormId( $name, $formId ) {

		$field = self::findByNameFormId( $name, $formId );

		return isset( $field );
	}
}

?>