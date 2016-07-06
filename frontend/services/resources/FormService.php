<?php
namespace cmsgears\forms\frontend\services\resources;

// Yii Imports
use \Yii;
use yii\base\Model;

// CMG Imports
use cmsgears\forms\common\models\entities\Form;

class FormService extends \cmsgears\core\common\services\resources\FormService {

	// Static Methods ----------------------------------------------

	// Update --------------

    public static function processForm( $form, $formModel ) {

		$formSubmit = $formModel->processFormSubmit( $form );

		return $formSubmit;
    }
}
