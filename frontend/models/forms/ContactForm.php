<?php
namespace cmsgears\forms\frontend\models\forms;

// CMG Imports
use cmsgears\forms\common\models\forms\BaseForm;

class ContactForm extends BaseForm {

	public $name;
	public $email;
	public $subject;
	public $message;

	public $captcha;

	// Instance Methods --------------------------------------------

	// yii\base\Model

    public function rules() {

        return [
            [ [ 'name', 'email', 'subject', 'message', 'captcha' ], 'required' ],
            [ 'name', 'alphanumspace' ],
            [ [ 'subject', 'message' ], 'alphanumpun' ],
            [ 'email', 'email' ],
            [ 'captcha', 'captcha', 'captchaAction' => '/cmgforms/site/captcha' ]
        ];
    }

    public function attributeLabels() {

        return [
            'name' => 'Name',
            'email' => 'Email',
            'subject' => 'Subject',
            'message' => 'Message',
        ];
    }
}

?>