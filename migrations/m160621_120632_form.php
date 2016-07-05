<?php
// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

class m160621_120632_form extends \yii\db\Migration {

	// Public Variables

	public $fk;
	public $options;

	// Private Variables

	private $prefix;

	public function init() {

		// Fixed
		$this->prefix		= 'cmg_';

		// Get the values via config
		$this->fk			= Yii::$app->migration->isFk();
		$this->options		= Yii::$app->migration->getTableOptions();

		// Default collation
		if( $this->db->driverName === 'mysql' ) {

			$this->options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}
	}

    public function up() {

		// Form Submit
		$this->upFormSubmit();
		$this->upFormSubmitField();

		if( $this->fk ) {

			$this->generateForeignKeys();
		}
    }

	private function upFormSubmit() {

        $this->createTable( $this->prefix . 'form_submit', [
			'id' => $this->bigPrimaryKey( 20 ),
			'formId' => $this->bigInteger( 20 )->notNull(),
			'submittedBy' => $this->bigInteger( 20 ),
			'submittedAt' => $this->dateTime()->notNull(),
			'content' => $this->text(),
			'data' => $this->text()
        ], $this->options );

        // Index for columns form and submitter
        $this->createIndex( 'idx_' . $this->prefix . 'submit_parent', $this->prefix . 'form_submit', 'formId' );
		$this->createIndex( 'idx_' . $this->prefix . 'submit_user', $this->prefix . 'form_submit', 'submittedBy' );
	}

	private function upFormSubmitField() {

        $this->createTable( $this->prefix . 'form_submit_field', [
			'id' => $this->bigPrimaryKey( 20 ),
			'formSubmitId' => $this->bigInteger( 20 )->notNull(),
			'name' => $this->string( CoreGlobal::TEXT_MEDIUM )->notNull(),
			'value' => $this->text()
        ], $this->options );

        // Index for columns site, parent, creator and modifier
		$this->createIndex( 'idx_' . $this->prefix . 'submit_field_parent', $this->prefix . 'form_submit_field', 'formSubmitId' );
	}

	private function generateForeignKeys() {

		// Form Submit
		$this->addForeignKey( 'fk_' . $this->prefix . 'submit_parent', $this->prefix . 'form_submit', 'formId', $this->prefix . 'core_form', 'id', 'CASCADE' );
        $this->addForeignKey( 'fk_' . $this->prefix . 'submit_user', $this->prefix . 'form_submit', 'submittedBy', $this->prefix . 'core_user', 'id', 'CASCADE' );

		// Form Submit Field
		$this->addForeignKey( 'fk_' . $this->prefix . 'submit_field_parent', $this->prefix . 'form_submit_field', 'formSubmitId', $this->prefix . 'form_submit', 'id', 'CASCADE' );
	}

    public function down() {

		if( $this->fk ) {

			$this->dropForeignKeys();
		}

        $this->dropTable( $this->prefix . 'form_submit' );
		$this->dropTable( $this->prefix . 'form_submit_field' );
    }

	private function dropForeignKeys() {

		// Form Submit
        $this->dropForeignKey( 'fk_' . $this->prefix . 'submit_parent', $this->prefix . 'form_submit' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'submit_user', $this->prefix . 'form_submit' );

		// Form Submit Field
		$this->dropForeignKey( 'fk_' . $this->prefix . 'submit_field_parent', $this->prefix . 'form_submit_field' );
	}
}

?>