<?php
namespace cmsgears\forms\common\services\resources;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\forms\common\models\base\FormTables;
use cmsgears\forms\common\models\resources\FormSubmitField;

use cmsgears\forms\common\services\interfaces\resources\IFormSubmitFieldService;

class FormSubmitFieldService extends \cmsgears\core\common\services\base\EntityService implements IFormSubmitFieldService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $modelClass	= '\cmsgears\forms\common\models\resources\FormSubmitField';

	public static $modelTable	= FormTables::TABLE_FORM_SUBMIT_FIELD;

	public static $parentType	= null;

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// FormSubmitFieldService ----------------

	// Data Provider ------

	public function getPage( $config = [] ) {

	    $sort = new Sort([
	        'attributes' => [
	            'name' => [
	                'asc' => [ 'name' => SORT_ASC ],
	                'desc' => ['name' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Name',
	            ]
	        ],
	        'defaultOrder' => [
	        	'sdate' => SORT_DESC
	        ]
	    ]);

		if( !isset( $config[ 'sort' ] ) ) {

			$config[ 'sort' ] = $sort;
		}

		return parent::findPage( $config );
	}

	// Read ---------------

    // Read - Models ---

    // Read - Lists ----

    // Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	// Delete -------------

	public function deleteByFormSubmitId( $formSubmitId ) {

		FormSubmitField::deleteByFormSubmitId( $formSubmitId );

		return true;
	}

	// Static Methods ----------------------------------------------

	// CMG parent classes --------------------

	// FormSubmitFieldService ----------------

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

?>