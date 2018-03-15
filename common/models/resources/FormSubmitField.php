<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\forms\common\models\resources;

// Yii Imports
use Yii;
use yii\helpers\ArrayHelper;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\forms\common\config\FormsGlobal;

use cmsgears\core\common\models\base\Resource;

use cmsgears\forms\common\models\base\FormTables;
use cmsgears\forms\common\models\entities\FormSubmit;

/**
 * FormSubmitField Entity
 *
 * @property integer $id
 * @property integer $formSubmitId
 * @property string $name
 * @property string $value
 *
 * @since 1.0.0
 */
class FormSubmitField extends Resource {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	protected $modelType	= FormsGlobal::TYPE_FORM_SUBMIT_FIELD;

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

		// Model Rules
        $rules = [
        	// Required, Safe
            [ [ 'formSubmitId', 'name' ], 'required' ],
            [ [ 'id', 'value' ], 'safe' ],
            // Text Limit
			[ 'name', 'string', 'min' => 1, 'max' => Yii::$app->core->xLargeText ]
        ];

		// Trim Text
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
	 * Returns corresponding form submit.
	 *
	 * @return FormSubmit
	 */
	public function getFormSubmit() {

		return $this->hasOne( FormSubmit::class, [ 'id' => 'formSubmitId' ] );
	}

	// Static Methods ----------------------------------------------

	// Yii parent classes --------------------

	// yii\db\ActiveRecord ----

    /**
     * @inheritdoc
     */
	public static function tableName() {

		return FormTables::getTableName( FormTables::TABLE_FORM_SUBMIT_FIELD );
	}

	// CMG parent classes --------------------

	// FormSubmitField -----------------------

	// Read - Query -----------

    /**
     * @inheritdoc
     */
	public static function queryWithHasOne( $config = [] ) {

		$relations				= isset( $config[ 'relations' ] ) ? $config[ 'relations' ] : [ 'formSubmit' ];
		$config[ 'relations' ]	= $relations;

		return parent::queryWithAll( $config );
	}

	// Read - Find ------------

	/**
	 * Find and return the form submit fields associated with given form submit id.
	 *
	 * @param integer $formSubmitId
	 * @return FormSubmitField[]
	 */
	public static function findByFormSubmitId( $formSubmitId ) {

		$frmSubmitTable	= FormTables::getTableName( FormTables::TABLE_FORM_SUBMIT );

		$query	= static::find()->joinWith( 'formSubmit' )->where( "$frmSubmitTable.id=:id", [ ':id' => $formSubmitId ] );

		return $query->all();
	}

	/**
	 * Find and return the form submit field associated with given form submit id and name.
	 *
	 * @param integer $formSubmitId
	 * @param string $name
	 * @return FormSubmitField
	 */
	public static function findByName( $formSubmitId, $name ) {

		$frmSubmitTable			= FormTables::getTableName( FormTables::TABLE_FORM_SUBMIT );
		$frmSubmitFieldTable	= FormTables::getTableName( FormTables::TABLE_FORM_SUBMIT_FIELD );

		$query	= static::find()->joinWith( 'formSubmit' )->where( "$frmSubmitTable.id=:id AND $frmSubmitFieldTable.name=:name", [ ':id' => $formSubmitId, ':name' => $name ] );

		return $query->one();
	}

	// Create -----------------

	// Update -----------------

	// Delete -----------------

	/**
	 * Delete all submit fields associated with given form submit id.
	 *
	 * @param integer $formSubmitId
	 * @return integer number of rows.
	 */
	public static function deleteByFormSubmitId( $formSubmitId ) {

		return self::deleteAll( 'formSubmitId=:id', [ ':id' => $formSubmitId ] );
	}
}
