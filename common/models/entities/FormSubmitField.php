<?php
namespace cmsgears\forms\common\models\entities;

// Yii Imports
use yii\db\ActiveRecord;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\forms\common\utilities\MessageUtil;

class FormSubmitField extends ActiveRecord {

	// Instance Methods --------------------------------------------

	public function getFormSubmit() {

		return $this->hasOne( FormSubmit::className(), [ 'id' => 'parentId' ] );
	}

	public function getFormSubmitWithAlias() {

		return $this->hasOne( Form::className(), [ 'id' => 'parentId' ] )->from( FormTables::TABLE_FORM_SUBMIT . ' frmSubmit' );
	}

	// Static Methods ----------------------------------------------

	public static function tableName() {

		return FormTables::TABLE_FORM_SUBMIT_FIELD;
	}

	public static function findByFormSubmitId( $formSubmitId ) {

		return FormField::find()->joinWith( 'formSubmitWithAlias' )->where( 'frmSubmit.id=:id', [ ':id' => $formSubmitId ] )->all();
	}
}

?>