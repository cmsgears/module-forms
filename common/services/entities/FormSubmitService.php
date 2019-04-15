<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\forms\common\services\entities;

// Yii Imports
use yii\data\Sort;

// CMG Imports
use cmsgears\forms\common\services\interfaces\entities\IFormSubmitService;
use cmsgears\forms\common\services\interfaces\resources\IFormSubmitFieldService;

/**
 * FormSubmitService provide service methods of form submit.
 *
 * @since 1.0.0
 */
class FormSubmitService extends \cmsgears\core\common\services\base\EntityService implements IFormSubmitService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $modelClass = '\cmsgears\forms\common\models\entities\FormSubmit';

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	private $formSubmitFieldService;

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

    public function __construct( IFormSubmitFieldService $formSubmitFieldService, $config = [] ) {

		$this->formSubmitFieldService = $formSubmitFieldService;

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

		$modelClass	= static::$modelClass;
		$modelTable	= $this->getModelTable();

	    $sort = new Sort([
	        'attributes' => [
				'id' => [
					'asc' => [ "$modelTable.id" => SORT_ASC ],
					'desc' => [ "$modelTable.id" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Id'
				],
	            'sdate' => [
	                'asc' => [ "$modelTable.submittedAt" => SORT_ASC ],
	                'desc' => [ "$modelTable.submittedAt" => SORT_DESC ],
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

    public function findByFormIdSubmittedBy( $formId, $submittedBy ) {

		$modelClass	= self::$modelClass;

		return $modelClass::find()->where( 'formId=:fid AND submittedBy=:uid', [ ':fid' => $formId, ':uid' => $submittedBy ] )->all();
    }

    public function findFirstByFormIdSubmittedBy( $formId, $submittedBy ) {

		$modelClass	= self::$modelClass;

		return $modelClass::find()->where( 'formId=:fid AND submittedBy=:uid', [ ':fid' => $formId, ':uid' => $submittedBy ] )->one();
    }

    // Read - Lists ----

    // Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	// Delete -------------

	public function delete( $model, $config = [] ) {

		$existingFormSubmit	= self::findById( $model->id );

		// Delete Dependency
		$this->formSubmitFieldService->deleteByFormSubmitId( $model->id );

		return parent::delete( $model, $config );
	}

	// Bulk ---------------

	// Notifications ------

	// Cache --------------

	// Additional ---------

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
