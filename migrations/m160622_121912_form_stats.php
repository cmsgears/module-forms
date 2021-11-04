<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\core\common\models\resources\ModelStats;
use cmsgears\forms\common\models\base\FormTables;

/**
 * The form stats migration insert the default row count for all the tables available in
 * form module. A scheduled console job can be executed to update these stats.
 *
 * @since 1.0.0
 */
class m160622_121912_form_stats extends \cmsgears\core\common\base\Migration {

	// Public Variables

	// Private Variables

	private $prefix;

	public function init() {

		// Table prefix
		$this->prefix = Yii::$app->migration->cmgPrefix;
	}

	public function up() {

		// Table Stats
		$this->insertTables();
	}

	private function insertTables() {

		$columns = [ 'parentId', 'parentType', 'name', 'type', 'count' ];

		$tableData = [
			[ 1, CoreGlobal::TYPE_SITE, $this->prefix . 'form_submit', 'rows', 0 ],
			[ 1, CoreGlobal::TYPE_SITE, $this->prefix . 'form_submit_field', 'rows', 0 ]
		];

		$this->batchInsert( $this->prefix . 'core_model_stats', $columns, $tableData );
	}

	public function down() {

		ModelStats::deleteByTable( FormTables::getTableName( FormTables::TABLE_FORM_SUBMIT ) );
		ModelStats::deleteByTable( FormTables::getTableName( FormTables::TABLE_FORM_SUBMIT_FIELD ) );
	}

}
