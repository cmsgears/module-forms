<?php
namespace cmsgears\forms\admin\services;

// Yii Imports
use \Yii;
use yii\data\Sort;

// CMG Imports
use cmsgears\forms\common\models\entities\Form;

class FormService extends \cmsgears\forms\common\services\FormService {

	// Static Methods ----------------------------------------------

	// Pagination -------

	public static function getPagination( $config = [] ) {

	    $sort = new Sort([
	        'attributes' => [
	            'name' => [
	                'asc' => [ 'name' => SORT_ASC ],
	                'desc' => ['name' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'name',
	            ],
	            'cdate' => [
	                'asc' => [ 'createdAt' => SORT_ASC ],
	                'desc' => ['createdAt' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'cdate',
	            ],
	            'udate' => [
	                'asc' => [ 'updatedAt' => SORT_ASC ],
	                'desc' => ['updatedAt' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'udate',
	            ]
	        ],
	        'defaultOrder' => [
	        	'cdate' => SORT_DESC
	        ]
	    ]);

		if( !isset( $conditions[ 'sort' ] ) ) {

			$conditions[ 'sort' ] = $sort;
		}

		if( !isset( $conditions[ 'search-col' ] ) ) {

			$conditions[ 'search-col' ] = 'name';
		}

		return self::getDataProvider( new Form(), $conditions );
	}
}

?>