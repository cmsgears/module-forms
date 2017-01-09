<?php
namespace cmsgears\forms\common\models\resources;

// Yii Imports
use \Yii;
use yii\validators\FilterValidator;
use yii\helpers\ArrayHelper;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\forms\common\models\base\FormTables;
use cmsgears\forms\common\models\entities\FormSubmit;

/**
 * FormSubmitField Entity
 *
 * @property integer $id
 * @property integer $formSubmitId
 * @property string $name
 * @property string $value
 */
class FormSubmitField extends \cmsgears\core\common\models\base\Entity {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Model ---------

    /**
     * @inheritdoc
     */
	public function rules() {

		// model rules
        $rules = [
        	// Required, Safe
            [ [ 'formSubmitId', 'name' ], 'required' ],
            [ [ 'id', 'value' ], 'safe' ],
            // Text Limit
			[ 'name', 'string', 'min' => 1, 'max' => Yii::$app->core->largeText ]
        ];

		// trim if configured
		if( Yii::$app->core->trimFieldValue ) {

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
			'formSubmitId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_PARENT ),
			'name' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_NAME ),
			'value' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_VALUE )
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	// FormSubmitField -----------------------

	/**
	 * @return FormSubmit - the parent
	 */
	public function getFormSubmit() {

		return $this->hasOne( FormSubmit::className(), [ 'id' => 'formSubmitId' ] );
	}

	// Static Methods ----------------------------------------------

	// Yii parent classes --------------------

	// yii\db\ActiveRecord ----

    /**
     * @inheritdoc
     */
	public static function tableName() {

		return FormTables::TABLE_FORM_SUBMIT_FIELD;
	}

	// CMG parent classes --------------------

	// FormSubmitField -----------------------

	// Read - Query -----------

	public static function queryWithHasOne( $config = [] ) {

		$relations				= isset( $config[ 'relations' ] ) ? $config[ 'relations' ] : [ 'formSubmit' ];
		$config[ 'relations' ]	= $relations;

		return parent::queryWithAll( $config );
	}

	// Read - Find ------------

	public static function findByFormSubmitId( $formSubmitId, $first = false ) {

		$frmSubmitTable	= FormTables::TABLE_FORM_SUBMIT;

		$query	= self::find()->joinWith( 'formSubmit' )->where( "$frmSubmitTable.id=:id", [ ':id' => $formSubmitId ] );

		if( $first ) {

			return $query->one();
		}

		return $query->all();
	}

	// Create -----------------

	// Update -----------------

	// Delete -----------------

	/**
	 * Delete all entries related to a form submit
	 */
	public static function deleteByFormSubmitId( $formSubmitId ) {

		self::deleteAll( 'formSubmitId=:id', [ ':id' => $formSubmitId ] );
	}
}