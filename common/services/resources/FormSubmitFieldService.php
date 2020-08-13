<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\forms\common\services\resources;

// CMG Imports
use cmsgears\forms\common\services\interfaces\resources\IFormSubmitFieldService;

/**
 * FormSubmitFieldService provide service methods of form submit field.
 *
 * @since 1.0.0
 */
class FormSubmitFieldService extends \cmsgears\core\common\services\base\ResourceService implements IFormSubmitFieldService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $modelClass = '\cmsgears\forms\common\models\resources\FormSubmitField';

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

		$searchParam	= $config[ 'search-param' ] ?? 'keywords';
		$searchColParam	= $config[ 'search-col-param' ] ?? 'search';

		$defaultSort = isset( $config[ 'defaultSort' ] ) ? $config[ 'defaultSort' ] : [ 'id' => SORT_DESC ];

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
	            'name' => [
	                'asc' => [ "$modelTable.name" => SORT_ASC ],
	                'desc' => [ "$modelTable.name" => SORT_DESC ],
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

		// Query ------------

		// Filters ----------

		// Searching --------

		$searchCol		= Yii::$app->request->getQueryParam( $searchColParam );
		$keywordsCol	= Yii::$app->request->getQueryParam( $searchParam );

		$search = [
			'name' => "$modelTable.name"
		];

		if( isset( $searchCol ) ) {

			$config[ 'search-col' ] = $search[ $searchCol ];
		}
		else if( isset( $keywordsCol ) ) {

			$config[ 'search-col' ] = $search;
		}

		// Reporting --------

		$config[ 'report-col' ]	= [
			'name' => "$modelTable.name"
		];

		// Result -----------

		return parent::findPage( $config );
	}

	// Read ---------------

    // Read - Models ---

    public function findByFormSubmitId( $formSubmitId ) {

		$modelClass	= static::$modelClass;

		return $modelClass::findByFormSubmitId( $formSubmitId );
    }

    public function findByName( $formSubmitId, $name ) {

		$modelClass	= static::$modelClass;

		return $modelClass::findByName( $formSubmitId, $name );
    }

    // Read - Lists ----

    // Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	// Delete -------------

	public function deleteByFormSubmitId( $formSubmitId ) {

		$modelClass	= self::$modelClass;

		$modelClass::deleteByFormSubmitId( $formSubmitId );

		return true;
	}

	// Bulk ---------------

	protected function applyBulk( $model, $column, $action, $target, $config = [] ) {

		switch( $column ) {

			case 'model': {

				switch( $action ) {

					case 'delete': {

						$this->delete( $model );

						break;
					}
				}

				break;
			}
		}
	}

	// Notifications ------

	// Cache --------------

	// Additional ---------

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
