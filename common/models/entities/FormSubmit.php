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
 * @property integer $submittedBy
 * @property string $submittedAt
 */
class FormSubmit extends CmgEntity {

	// Instance Methods --------------------------------------------

	/**
	 * @return Form
	 */
	public function getForm() {

		return $this->hasOne( Form::className(), [ 'id' => 'parentId' ] );
	}

	/**
	 * @return Form - parent form with alias frm
	 */
	public function getFormWithAlias() {

		return $this->hasOne( Form::className(), [ 'id' => 'parentId' ] )->from( FormTables::TABLE_FORM . ' frm' );
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

    	return $this->hasMany( FormSubmitField::className(), [ 'parentId' => 'id' ] );
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
            [ [ 'parentId' ], 'required' ],
			[ 'id', 'safe' ],
			[ [ 'parentId', 'submittedBy' ], 'number', 'integerOnly' => true, 'min' => 1 ]
        ];
    }

    /**
     * @inheritdoc
     */
	public function attributeLabels() {

		return [
			'parentId' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_PARENT ),
			'submittedBy' => Yii::$app->cmgFormsMessage->getMessage( FormsGlobal::FIELD_SUBMITTED_BY )
		];
	}

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord ----------------

	public static function tableName() {

		return FormTables::TABLE_FORM_SUBMIT;
	}

	// FormSubmit ------------------------
}

?>