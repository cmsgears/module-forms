<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

// CMG Imports
use cmsgears\core\common\base\Migration;

/**
 * The form index migration inserts the recommended indexes for better performance. It
 * also list down other possible index commented out. These indexes can be created using
 * project based migration script.
 *
 * @since 1.0.0
 */
class m160622_121832_form_index extends Migration {

	// Public Variables

	// Private Variables

	private $prefix;

	public function init() {

		// Table prefix
		$this->prefix = Yii::$app->migration->cmgPrefix;
	}

	public function up() {

		$this->upPrimary();
	}

	private function upPrimary() {

		// Form Submit Field
		$this->createIndex( 'idx_' . $this->prefix . 'submit_field_name', $this->prefix . 'form_submit_field', 'name' );
		//$this->execute( 'ALTER TABLE ' . $this->prefix . 'form_submit_field' . ' ADD FULLTEXT ' . 'idx_' . $this->prefix . 'submit_field_value' . '(value ASC)' );
	}

	public function down() {

		$this->downPrimary();
	}

	private function downPrimary() {

		// Form Submit Field
		$this->dropIndex( 'idx_' . $this->prefix . 'submit_field_name', $this->prefix . 'form_submit_field' );
		//$this->dropIndex( 'idx_' . $this->prefix . 'submit_field_value', $this->prefix . 'form_submit_field' );
	}
}
