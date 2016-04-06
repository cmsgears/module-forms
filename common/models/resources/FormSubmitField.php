<?php
namespace cmsgears\forms\common\models\resources;

// Yii Imports
use \Yii;
use yii\validators\FilterValidator;
use yii\helpers\ArrayHelper;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\forms\common\models\base\FormTables;

/**
 * FormSubmitField Entity
 *
 * @property integer $id
 * @property integer $formSubmitId
 * @property string $name
 * @property string $value
 */
class FormSubmitField extends \cmsgears\core\common\models\base\CmgEntity {

	// Variables ---------------------------------------------------

	// Constants/Statics --

	// Public -------------

	// Private/Protected --

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	// Instance Methods --------------------------------------------

	// yii\base\Component ----------------

	// yii\base\Model --------------------

    /**
     * @inheritdoc
     */
	public function rules() {

		// model rules
        $rules = [
            [ [ 'formSubmitId', 'name' ], 'required' ],
            [ [ 'id', 'value' ], 'safe' ],
			[ 'name', 'string', 'min' => 1, 'max' => Yii::$app->cmgCore->mediumText ]
        ];

		// trim if configured
		if( Yii::$app->cmgCore->trimFieldValue ) {

			$trim[] = [ [ 'name', 'value' ], 'filter', 'filter' => 'trim', 'skipOnArray' => true ];

			return ArrayHelper::merge( $trim, $rules );
		}

		return $rules;
    }

    /**
     * @inheritdoc
     */
	public function attributeLabels() {

		return [
			'formSubmitId' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_PARENT ),
			'name' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_NAME ),
			'value' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_VALUE )
		];
	}

	// FormSubmitField -------------------

	/**
	 * @return FormSubmit - the parent
	 */
	public function getFormSubmit() {

		return $this->hasOne( FormSubmit::className(), [ 'id' => 'formSubmitId' ] );
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

	// Create -------------

	// Read ---------------

	public static function findByFormSubmitId( $formSubmitId ) {

		$frmSubmitTable	= FormTables::TABLE_FORM_SUBMIT;

		return self::find()->joinWith( 'formSubmit' )->where( "$frmSubmitTable.id=:id", [ ':id' => $formSubmitId ] )->all();
	}

	// Delete ----

	/**
	 * Delete all entries related to a form submit
	 */
	public static function deleteByFormSubmitId( $formSubmitId ) {

		self::deleteAll( 'formSubmitId=:id', [ ':id' => $formSubmitId ] );
	}

	// Update -------------

	// Delete -------------
}

?>