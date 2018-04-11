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
use Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\forms\common\config\FormsGlobal;

use cmsgears\forms\common\services\interfaces\entities\IFormService;

use cmsgears\core\common\services\resources\FormService as BaseFormService;

/**
 * FormService provide service methods of form model.
 *
 * @since 1.0.0
 */
class FormService extends BaseFormService implements IFormService {

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

    public function processForm( $form, $formModel ) {

		$formSubmit = $formModel->processFormSubmit( $form );

		$this->triggerNotification( $form );

		return $formSubmit;
    }

	// Update -------------

	// Delete -------------

	// Bulk ---------------

	// Notifications ------

    private function triggerNotification( $form ) {

        Yii::$app->eventManager->triggerNotification( FormsGlobal::TEMPLATE_NOTIFY_FORM_SUBMIT,
            [ 'model' => $form ],
            [
                'parentId' => $form->id,
                'parentType' => CoreGlobal::TYPE_FORM,
                'adminLink' => "/forms/form/submit/all?fid=$form->id"
            ]
        );
    }

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
