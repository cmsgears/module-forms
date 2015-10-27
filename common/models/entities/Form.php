<?php
namespace cmsgears\forms\common\models\entities;

// Yii Imports
use \Yii;
use yii\validators\FilterValidator;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\forms\common\config\FormsGlobal;

use cmsgears\core\common\behaviors\AuthorBehavior;

use cmsgears\core\common\models\entities\Template;
use cmsgears\core\common\models\traits\MetaTrait;

/**
 * Form Entity
 *
 * @property integer $id
 * @property integer $templateId
 * @property integer $createdBy
 * @property integer $modifiedBy
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property string $successMessage
 * @property boolean $jsonStorage
 * @property boolean $captcha
 * @property boolean $visibility
 * @property boolean $userMail
 * @property boolean $adminMail
 * @property string $options
 * @property datetime $createdAt
 * @property datetime $modifiedAt 
 */
class Form extends \cmsgears\core\common\models\entities\NamedCmgEntity {

	const VISIBILITY_PUBLIC		=  0;
	const VISIBILITY_PRIVATE	=  1;

	public static $visibilityMap = [
		self::VISIBILITY_PUBLIC => 'Public',
		self::VISIBILITY_PRIVATE => 'Private'
	];

	use MetaTrait;

	public $metaType	= FormsGlobal::TYPE_FORM;

	// Instance Methods --------------------------------------------

	public function getTemplate() {

		return $this->hasOne( Template::className(), [ 'id' => 'templateId' ] );
	}

	public function getTemplateName() {

		$template = $this->template;

		if( isset( $template ) ) {

			return $template->name;
		}

		return '';
	}

	public function getJsonStorageStr() {

		return Yii::$app->formatter->asBoolean( $this->jsonStorage ); 
	}

	public function getCaptchaStr() {

		return Yii::$app->formatter->asBoolean( $this->captcha ); 
	}

	public function getVisibilityStr() {

		return self::$visibilityMap[ $this->visibility ]; 
	}

	public function getUserMailStr() {

		return Yii::$app->formatter->asBoolean( $this->userMail ); 
	}

	public function getAdminMailStr() {

		return Yii::$app->formatter->asBoolean( $this->adminMail ); 
	}

	/**
	 * @return array - array of FormField
	 */
	public function getFields() {

    	return $this->hasMany( FormField::className(), [ 'formId' => 'id' ] );
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

	public function isPrivate() {

		return $this->visibility == self::VISIBILITY_PRIVATE;
	}

	// yii\base\Component ----------------

    /**
     * @inheritdoc
     */
    public function behaviors() {

        return [

			'authorBehavior' => [
				'class' => AuthorBehavior::className()
			],
            'timestampBehavior' => [
                'class' => TimestampBehavior::className(),
				'createdAtAttribute' => 'createdAt',
 				'updatedAtAttribute' => 'modifiedAt',
 				'value' => new Expression('NOW()')
            ],
            'sluggableBehavior' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'slugAttribute' => 'slug',
                'ensureUnique' => true
            ]
        ];
    }

	// yii\base\Model --------------------

    /**
     * @inheritdoc
     */
	public function rules() {

		$trim		= [];

		if( Yii::$app->cmgCore->trimFieldValue ) {

			$trim[] = [ [ 'name', 'description', 'successMessage' ], 'filter', 'filter' => 'trim', 'skipOnArray' => true ];
		}

        $rules = [
            [ [ 'name' ], 'required' ],
			[ [ 'id', 'slug', 'templateId', 'description', 'successMessage', 'jsonStorage', 'captcha', 'visibility', 'userMail', 'adminMail', 'options' ], 'safe' ],
            [ 'name', 'validateNameCreate', 'on' => [ 'create' ] ],
            [ 'name', 'validateNameUpdate', 'on' => [ 'update' ] ],
            [ [ 'createdBy', 'modifiedBy' ], 'number', 'integerOnly' => true, 'min' => 1 ],
            [ [ 'createdAt', 'modifiedAt' ], 'date', 'format' => Yii::$app->formatter->datetimeFormat ]
        ];

		if( Yii::$app->cmgCore->trimFieldValue ) {

			return ArrayHelper::merge( $trim, $rules );
		}

		return $rules;
    }

    /**
     * @inheritdoc
     */
	public function attributeLabels() {

		return [
			'name' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_NAME ),
			'slug' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_SLUG ),
			'description' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_DESCRIPTION ),
			'successMessage' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_MESSAGE_SUCCESS ),
			'jsonStorage' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_STORE_JSON ),
			'captcha' => Yii::$app->cmgFormsMessage->getMessage( FormsGlobal::FIELD_CAPTCHA ),
			'visibility' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_VISIBILITY ),
			'userMail' => Yii::$app->cmgFormsMessage->getMessage( FormsGlobal::FIELD_MAIL_USER ),
			'adminMail' => Yii::$app->cmgFormsMessage->getMessage( FormsGlobal::FIELD_MAIL_ADMIN ),
			'options' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_OPTIONS )
		];
	}

	// Static Methods ----------------------------------------------

    /**
     * @inheritdoc
     */
	public static function tableName() {

		return FormTables::TABLE_FORM;
	}

	// Form

	// Read ------

	/**
	 * @return Form - by slug.
	 */
	public static function findBySlug( $slug ) {

		return self::find()->where( 'slug=:slug', [ ':slug' => $slug ] )->one();
	}
}

?>