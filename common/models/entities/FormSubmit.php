<?php
namespace cmsgears\forms\common\models\entities;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\forms\common\config\FormsGlobal;

use cmsgears\core\common\models\entities\User;
use cmsgears\core\common\models\resources\Form;
use cmsgears\forms\common\models\base\FormTables;
use cmsgears\forms\common\models\resources\FormSubmitField;

use cmsgears\core\common\models\traits\resources\DataTrait;

/**
 * FormSubmit Entity
 *
 * @property integer $id
 * @property integer $formId
 * @property integer $submittedBy
 * @property datetime $submittedAt
 * @property string $content
 * @property string $data
 */
class FormSubmit extends \cmsgears\core\common\models\base\Entity {

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

	use DataTrait;

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
			'formId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_PARENT ),
			'submittedBy' => Yii::$app->formsMessage->getMessage( FormsGlobal::FIELD_SUBMITTED_BY ),
			'content' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_CONTENT ),
			'data' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_DATA )
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	// FormSubmit ----------------------------

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

	// Static Methods ----------------------------------------------

	// Yii parent classes --------------------

	// yii\db\ActiveRecord ----

	public static function tableName() {

		return FormTables::TABLE_FORM_SUBMIT;
	}

	// CMG parent classes --------------------

	// FormSubmit ----------------------------

	// Read - Query -----------

	public static function queryWithHasOne( $config = [] ) {

		$relations				= isset( $config[ 'relations' ] ) ? $config[ 'relations' ] : [ 'form', 'user' ];
		$config[ 'relations' ]	= $relations;

		return parent::queryWithAll( $config );
	}

	public static function queryWithForm( $config = [] ) {

		$config[ 'relations' ]	= [ 'form' ];

		return parent::queryWithAll( $config );
	}

	public static function queryWithFields( $config = [] ) {

		$config[ 'relations' ]	= [ 'fields' ];

		return parent::queryWithAll( $config );
	}

	// Read - Find ------------

	// Create -----------------

	// Update -----------------

	// Delete -----------------
}
