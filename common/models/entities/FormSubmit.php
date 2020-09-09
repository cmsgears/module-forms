<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\forms\common\models\entities;

// Yii Imports
use Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\forms\common\config\FormsGlobal;

use cmsgears\core\common\models\interfaces\resources\IData;

use cmsgears\core\common\models\entities\User;
use cmsgears\core\common\models\resources\Form;

use cmsgears\forms\common\models\base\FormTables;
use cmsgears\forms\common\models\resources\FormSubmitField;

use cmsgears\core\common\models\traits\resources\DataTrait;

/**
 * FormSubmit model stores the form data submitted by user. It can either store the submitted
 * data in [[$data]] object data or [[FormSubmitField]].
 *
 * @property integer $id
 * @property integer $formId
 * @property integer $submittedBy
 * @property datetime $submittedAt
 * @property string $content
 * @property string $data
 *
 * @since 1.0.0
 */
class FormSubmit extends \cmsgears\core\common\models\base\Entity implements IData {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	protected $modelType = FormsGlobal::TYPE_FORM_SUBMIT;

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

		// Model Rules
        $rules = [
			// Required, Safe
            [ 'formId', 'required' ],
			[ [ 'id', 'content' ], 'safe' ],
			// Other
			[ [ 'formId', 'submittedBy' ], 'number', 'integerOnly' => true, 'min' => 1 ],
			[ 'submittedAt', 'date', 'format' => Yii::$app->formatter->datetimeFormat ]
        ];

		return $rules;
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
	 * Returns the corresponding form.
	 *
	 * @return Form
	 */
	public function getForm() {

		return $this->hasOne( Form::class, [ 'id' => 'formId' ] );
	}

	/**
	 * Returns user who submitted the form.
	 *
	 * @return User
	 */
	public function getUser() {

		return $this->hasOne( User::class, [ 'id' => 'submittedBy' ] );
	}

	/**
	 * Returns all the form fields associated with the form.
	 *
	 * @return FormSubmitField[]
	 */
	public function getFields() {

    	return $this->hasMany( FormSubmitField::class, [ 'formSubmitId' => 'id' ] );
	}

	/**
	 * Generate and return the map of form submit fields.
	 *
	 * @return array
	 */
	public function getFieldsMap() {

		$formFields = $this->fields;

		$formFieldsMap = [];

		foreach( $formFields as $formField ) {

			$formFieldsMap[ $formField->name ] = $formField;
		}

    	return $formFieldsMap;
	}

	// Static Methods ----------------------------------------------

	// Yii parent classes --------------------

	// yii\db\ActiveRecord ----

    /**
     * @inheritdoc
     */
	public static function tableName() {

		return FormTables::getTableName( FormTables::TABLE_FORM_SUBMIT );
	}

	// CMG parent classes --------------------

	// FormSubmit ----------------------------

	// Read - Query -----------

    /**
     * @inheritdoc
     */
	public static function queryWithHasOne( $config = [] ) {

		$relations = isset( $config[ 'relations' ] ) ? $config[ 'relations' ] : [ 'form', 'user' ];

		$config[ 'relations' ] = $relations;

		return parent::queryWithAll( $config );
	}

	/**
	 * Return query to find the form submit with form.
	 *
	 * @param array $config
	 * @return \yii\db\ActiveQuery to query with form.
	 */
	public static function queryWithForm( $config = [] ) {

		$config[ 'relations' ] = [ 'form' ];

		return parent::queryWithAll( $config );
	}

	/**
	 * Return query to find the form submit with submit fields.
	 *
	 * @param array $config
	 * @return \yii\db\ActiveQuery to query with submit fields.
	 */
	public static function queryWithFieds( $config = [] ) {

		$config[ 'relations' ] = [ 'fields' ];

		return parent::queryWithAll( $config );
	}

	// Read - Find ------------

	// Create -----------------

	// Update -----------------

	// Delete -----------------

}
