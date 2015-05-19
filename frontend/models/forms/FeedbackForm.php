<?php
namespace cmsgears\forms\frontend\models\forms;

// CMg Imports
use cmsgears\forms\common\models\forms\BaseForm;

class FeedbackForm extends BaseForm {

	public $name;
	public $email;
	public $rating;
	public $message;

	// Instance Methods --------------------------------------------
	
	// yii\base\Model

    public function rules() {

        return [
            [ [ 'name', 'email', 'rating', 'message' ], 'required' ],
            [ 'name', 'alphanumspace' ],
            [ [ 'message' ], 'alphanumpun' ],
            [ 'email', 'email' ]
        ];
    }

    public function attributeLabels() {

        return [
            'name' => 'Name',
            'email' => 'Email',
            'rating' => 'Ratings',
            'message' => 'Message',
        ];
    }
}

?>