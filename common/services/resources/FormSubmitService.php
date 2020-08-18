<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\forms\common\services\resources;

// Yii Imports
use Yii;
use yii\data\Sort;

// CMG Imports
use cmsgears\forms\common\services\interfaces\resources\IFormSubmitService;

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

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// FormSubmitService ---------------------

	// Data Provider ------

	public function getPage( $config = [] ) {

		$searchParam	= $config[ 'search-param' ] ?? 'keywords';
		$searchColParam	= $config[ 'search-col-param' ] ?? 'search';

		$defaultSort = isset( $config[ 'defaultSort' ] ) ? $config[ 'defaultSort' ] : [ 'id' => SORT_DESC ];

		$modelClass	= static::$modelClass;
		$modelTable	= $this->getModelTable();

		$userTable = Yii::$app->factory->get( 'userService' )->getModelTable();

		// Sorting ----------

	    $sort = new Sort([
	        'attributes' => [
				'id' => [
					'asc' => [ "$modelTable.id" => SORT_ASC ],
					'desc' => [ "$modelTable.id" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Id'
				],
				'name' => [
					'asc' => [ "$userTable.name" => SORT_ASC ],
					'desc' => [ "$userTable.name" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Name'
				],
				'email' => [
					'asc' => [ "$userTable.email" => SORT_ASC ],
					'desc' => [ "$userTable.email" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Name'
				],
	            'sdate' => [
	                'asc' => [ "$modelTable.submittedAt" => SORT_ASC ],
	                'desc' => [ "$modelTable.submittedAt" => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'sdate',
	            ]
	        ],
			'defaultOrder' => $defaultSort
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
			'name' => "$userTable.name",
			'email' => "$userTable.email"
		];

		if( isset( $searchCol ) ) {

			$config[ 'search-col' ] = $config[ 'search-col' ] ?? $search[ $searchCol ];
		}
		else if( isset( $keywordsCol ) ) {

			$config[ 'search-col' ] = $config[ 'search-col' ] ?? $search;
		}

		// Reporting --------

		$config[ 'report-col' ]	= $config[ 'report-col' ] ?? [
			'name' => "$userTable.name",
			'email' => "$userTable.email",
			'sdate' => "$modelTable.submittedAt"
		];

		// Result -----------

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

		// Delete Dependency
		$this->formSubmitFieldService->deleteByFormSubmitId( $model->id );

		return parent::delete( $model, $config );
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
