<?php
namespace cmsgears\forms\frontend\models\forms;

// CMG Imports
use cmsgears\forms\common\models\forms\BaseForm;

class GenericForm extends BaseForm {

	public $fields;
	
	public $attribs;

	public $captcha;

    public function __construct( $config = [] ) {

		$this->fields	= $config[ 'fields' ];
		$this->attribs	= [];
		$fields			= $this->fields;

		unset( $config[ 'fields' ] );

		foreach ( $fields as $key => $field ) {

			$this->__set( $key, null );
			
			$this->attribs[]	= $key;
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
		
		// Prepare validators list
		$validators		= [];
		$fields			= $this->fields;

		foreach ( $fields as $key => $field ) {

			if( isset( $field->validators ) ) {
				
				$fieldValidators = preg_split( "/,/", $field->validators );
				
				foreach ( $fieldValidators as $validator ) {

					if( !isset( $validators[ $validator ] ) ) {

						$validators[ $validator ]	= [];
					}

					$validators[ $validator ][]	= $field->name;
				}
			}
		}
		
        $rules = [
            [ 'captcha', 'captcha', 'captchaAction' => '/cmgforms/site/captcha', 'on' => 'captcha' ],
            [ $this->attribs, 'safe' ]
        ];
		
		foreach ( $validators as $key => $value ) {
			
			$rules[]	= [ $value, $key ];
		}
		
		return $rules;
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