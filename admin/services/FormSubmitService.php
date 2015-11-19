<?php
namespace cmsgears\forms\admin\services;

// Yii Imports
use \Yii;
use yii\data\Sort;

// CMG Imports
use cmsgears\forms\common\models\entities\FormSubmit;

class FormSubmitService extends \cmsgears\forms\common\services\FormSubmitService {

	// Static Methods ----------------------------------------------

	// Pagination -------

	public static function getPagination( $config = [] ) {

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

		return self::getDataProvider( new FormSubmit(), $config );
	}

	public static function getPaginationByFormId( $formId ) {

		return self::getPagination( [ 'conditions' => [ 'formId' => $formId ] ] );
	}
}

?>