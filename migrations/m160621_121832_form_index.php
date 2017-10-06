<?php

class m160621_121832_form_index extends \yii\db\Migration {

	// Public Variables

	// Private Variables

	private $prefix;

	public function init() {

		// Table prefix
		$this->prefix		= Yii::$app->migration->cmgPrefix;
	}

	public function up() {

		$this->upPrimary();
	}

	private function upPrimary() {

		// Form Submit Field
		$this->createIndex( 'idx_' . $this->prefix . 'submit_field_name', $this->prefix . 'form_submit_field', 'name' );
	}

	public function down() {

		$this->downPrimary();
	}

	private function downPrimary() {

		// Form Submit Field
		$this->dropIndex( 'idx_' . $this->prefix . 'submit_field_name', $this->prefix . 'form_submit_field' );
	}
}