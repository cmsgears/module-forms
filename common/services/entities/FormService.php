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

use cmsgears\core\common\services\resources\FormService;

/**
 * FormService provide service methods of form model.
 *
 * @since 1.0.0
 */
class FormService extends FormService implements IFormService {

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

    private function triggerNotification( $form ) {

        $formId = $form->id;

        Yii::$app->eventManager->triggerNotification( FormsGlobal::TEMPLATE_NOTIFY_FORM_SUBMIT,
            [ 'title' => $form->name ],
            [
                'parentId' => $formId,
                'parentType' => CoreGlobal::TYPE_FORM,
                'adminLink' => "/forms/form/submit/all?fid=$formId",
            ]
        );
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
