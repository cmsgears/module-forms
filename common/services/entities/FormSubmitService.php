<?php
namespace cmsgears\forms\common\services\entities;

// Yii Imports
use yii\data\Sort;

// CMG Imports
use cmsgears\forms\common\models\base\FormTables;

use cmsgears\forms\common\services\interfaces\entities\IFormSubmitService;
use cmsgears\forms\common\services\interfaces\resources\IFormSubmitFieldService;

class FormSubmitService extends \cmsgears\core\common\services\base\EntityService implements IFormSubmitService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $modelClass	= '\cmsgears\forms\common\models\entities\FormSubmit';

	public static $modelTable	= FormTables::TABLE_FORM_SUBMIT;

	public static $parentType	= null;

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	private $formSubmitFieldService;

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

    public function __construct( IFormSubmitFieldService $formSubmitFieldService, $config = [] ) {

		$this->formSubmitFieldService	= $formSubmitFieldService;

        parent::__construct( $config );
    }

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// FormSubmitService ---------------------

	// Data Provider ------

	public function getPage( $config = [] ) {

	    $sort = new Sort([
	        'attributes' => [
	            'sdate' => [
	                'asc' => [ 'submittedAt' => SORT_ASC ],
	                'desc' => ['submittedAt' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'sdate',
	            ]
	        ],
	        'defaultOrder' => [
	        	'sdate' => SORT_DESC
	        ]
	    ]);

		if( !isset( $config[ 'sort' ] ) ) {

			$config[ 'sort' ] = $sort;
		}

		if( !isset( $config[ 'search-col' ] ) ) {

			$config[ 'search-col' ] = 'submittedAt';
		}

		return parent::findPage( $config );
	}

	public function getPageByFormId( $formId ) {

		return $this->getPage( [ 'conditions' => [ 'formId' => $formId ] ] );
	}

	// Read ---------------

    // Read - Models ---

    public function findbyFormIdSubmittedBy( $formId, $submittedBy, $first = false ) {

		$modelClass	= self::$modelClass;

		if( $first ) {

			return $modelClass::find()->where( 'formId=:fid AND submittedBy=:uid', [ ':fid' => $formId, ':uid' => $submittedBy ] )->one();
		}

		return $modelClass::find()->where( 'formId=:fid AND submittedBy=:uid', [ ':fid' => $formId, ':uid' => $submittedBy ] )->all();
    }

    // Read - Lists ----

    // Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	// Delete -------------

	public function delete( $model, $config = [] ) {

		$existingFormSubmit		= self::findById( $model->id );

		// Delete Dependency
		$this->formSubmitFieldService->deleteByFormSubmitId( $model->id );

		return parent::delete( $model, $config );
	}

	// Static Methods ----------------------------------------------

	// CMG parent classes --------------------

	// FormSubmitService ---------------------

	// Data Provider ------

	// Read ---------------

    // Read - Models ---

    // Read - Lists ----

    // Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	// Delete -------------
}
