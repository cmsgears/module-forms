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

// CMG Imports
use cmsgears\forms\common\config\FormsGlobal;

use cmsgears\forms\common\services\interfaces\resources\IFormService;

/**
 * FormService provide service methods of form model.
 *
 * @since 1.0.0
 */
class FormService extends \cmsgears\core\common\services\resources\FormService implements IFormService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

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

	// FormService ---------------------------

	// Data Provider ------

	// Read ---------------

    // Read - Models ---

    // Read - Lists ----

    // Read - Maps -----

	// Read - Others ---

	// Create -------------

    public function processForm( $form, $formModel, $config = [] ) {

		$notification = isset( $config[ 'notification' ] ) ? $config[ 'notification' ] : [];

		$notification[ 'template' ]		= isset( $notification[ 'template' ] ) ? $notification[ 'template' ] : FormsGlobal::TPL_NOTIFY_FORM_SUBMIT;
		$notification[ 'adminLink' ]	= isset( $notification[ 'adminLink' ] ) ? $notification[ 'adminLink' ] : "forms/form/submit/all?pid=$form->id";

		$formSubmit = $formModel->processFormSubmit( $form );

		// Trigger Notification
		$this->notifyAdmin( $form, $notification );

		// Trigger Emails
		if( $formSubmit ) {

			// Trigger User Mail
			if( $form->userMail ) {

				Yii::$app->formsMailer->sendUserMail( $form, $formModel );
			}

			// Trigger Admin Mail
			if( $form->adminMail ) {

				Yii::$app->formsMailer->sendAdminMail( $form, $formModel );
			}
		}

		return $formSubmit;
    }

	// Update -------------

	// Delete -------------

	// Bulk ---------------

	// Notifications ------

	// Cache --------------

	// Additional ---------

	// Static Methods ----------------------------------------------

	// CMG parent classes --------------------

	// FormService ---------------------------

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
