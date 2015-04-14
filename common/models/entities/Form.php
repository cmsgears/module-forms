<?php
namespace cmsgears\forms\common\models\entities;

// CMG Imports
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
	 * @return array - map of FormField having file name as key
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

	public function rules() {

        return [
            [ [ 'name' ], 'required' ],
			[ [ 'description', 'successMessage' ], 'safe' ],
            [ 'name', 'validateNameCreate', 'on' => [ 'create' ] ],
            [ 'name', 'validateNameUpdate', 'on' => [ 'update' ] ]
        ];
    }

	public function attributeLabels() {

		return [
			'name' => 'Name',
			'description' => 'Description',
			'successMessage' => 'Success Message',
		];
	}

	// Static Methods ----------------------------------------------

	public static function tableName() {

		return FormTables::TABLE_FORM;
	}

	// Category

	public static function findById( $id ) {

		return Form::find()->where( [ 'id' => $id ] )->one();
	}

	public static function findByName( $name ) {

		return Form::find()->where( 'name=:name', [ ':name' => $name ] )->one();
	}
}

?>