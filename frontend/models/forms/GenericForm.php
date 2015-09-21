<?php
namespace cmsgears\forms\frontend\models\forms;

// CMG Imports
use cmsgears\forms\common\models\forms\BaseForm;

class GenericForm extends BaseForm {

	public $fields;

	public $captcha;

    public function __construct( $config = [] ) {

		$this->fields	= $config[ 'fields' ];
		$fields			= $this->fields;

		unset( $config[ 'fields' ] );

		foreach ( $fields as $key => $field ) {

			$this->__set( $key, null );
		}

		parent::__construct( $config );
    }

	// Instance Methods --------------------------------------------

	// yii\base\Object

	public function __set( $name, $value ) {

        $setter 	= 'set' . $name;

        if( method_exists( $this, $setter ) ) {

            $this->$setter( $value );
        }
        else {

            $this->$name	= $value;
        }
	}

	// yii\base\Model

 	public function rules() {

        return [
            [ 'captcha', 'captcha', 'captchaAction' => '/cmgforms/site/captcha', 'on' => 'captcha' ]
        ];
    }
 
    public function attributeLabels() {

		$fields	= $this->fields;
		$labels	= [];

		foreach ( $fields as $key => $field ) {

			if( isset( $field->label ) ) {

				$labels[ $key ] = $field->label;
			}
			else {

				$labels[ $key ] = $key;
			}
		}

        return $labels;
    }
}

?>