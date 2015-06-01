<?php
namespace cmsgears\forms\common\models\entities;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\core\common\models\entities\NamedCmgEntity;

/**
 * Form Entity
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $successMessage
 */
class Form extends NamedCmgEntity {

	// Instance Methods --------------------------------------------

	/**
	 * @return array - array of FormField
	 */
	public function getFields() {

    	return $this->hasMany( FormField::className(), [ 'parentId' => 'id' ] );
	}

	/**
	 * @return array - map of FormField having field name as key
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
            [ [ 'name' ], 'required' ],
			[ [ 'description', 'successMessage' ], 'safe' ],
            [ 'name', 'validateNameCreate', 'on' => [ 'create' ] ],
            [ 'name', 'validateNameUpdate', 'on' => [ 'update' ] ]
        ];
    }

    /**
     * @inheritdoc
     */
	public function attributeLabels() {

		return [
			'name' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_NAME ),
			'description' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_DESCRIPTION ),
			'message' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_MESSAGE )
		];
	}

	// Static Methods ----------------------------------------------

    /**
     * @inheritdoc
     */
	public static function tableName() {

		return FormTables::TABLE_FORM;
	}

	// Category

	public static function findById( $id ) {

		return Form::find()->where( 'id=:id', [ ':id' => $id ] )->one();
	}

	public static function findByName( $name ) {

		return Form::find()->where( 'name=:name', [ ':name' => $name ] )->one();
	}
}

?>