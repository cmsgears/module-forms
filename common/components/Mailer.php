<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\forms\common\components;

// Yii Imports
use Yii;

/**
 * Mailer triggers the mails provided by Forms Module.
 *
 * @since 1.0.0
 */
class Mailer extends \cmsgears\core\common\base\Mailer {

	// Variables ---------------------------------------------------

	// Global -----------------

	const MAIL_GENERIC_USER		= 'user';
	const MAIL_GENERIC_ADMIN	= 'admin';

	// Public -----------------

    public $htmlLayout 	= '@cmsgears/module-core/common/mails/layouts/html';
    public $textLayout 	= '@cmsgears/module-core/common/mails/layouts/text';
    public $viewPath 	= '@cmsgears/module-forms/common/mails/views';

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// CMG parent classes --------------------

	// Mailer --------------------------------

    public function sendUserMail( $form, $model ) {

		$mailProperties = $this->mailProperties;

		$fromEmail 	= $mailProperties->getContactEmail();
		$fromName 	= $mailProperties->getContactName();
		$toEmail	= null;
		$name		= null;
		$subject	= '';

		// Email
		if( isset( $model->email ) ) {

			$toEmail = $model->email;
		}

		// Name
		if( isset( $model->name ) ) {

			$name = $model->name;
		}

		// Email, Name
		if( isset( Yii::$app->user ) ) {

			$user = Yii::$app->core->getUser();

			if( isset( $user ) ) {

				if( !isset( $toEmail ) ) {

					$toEmail = $user->email;
				}

				if( !isset( $name ) ) {

					$name = $user->getName();
				}
			}
		}

		// Name
		if( !isset( $name ) && isset( $toEmail ) ) {

			$name = preg_split( "/@", $toEmail );
			$name = $name[ 0 ];
		}

		// Subject
		if( isset( $model->subject ) ) {

			$subject = $model->subject;
		}
		else {

			$subject = $form->name;
		}

		if( empty( $toEmail ) ) {

			return;
		}

		if( isset( $toEmail ) ) {

	        $this->getMailer()->compose( self::MAIL_GENERIC_USER, [ 'coreProperties' => $this->coreProperties, 'form' => $form, 'model' => $model, 'name' => $name, 'email' => $toEmail ] )
	            ->setTo( $toEmail )
	            ->setFrom( [ $fromEmail => $fromName ] )
	            ->setSubject( $subject )
	            //->setTextBody( $contact->contact_message )
	            ->send();
		}
    }

    public function sendAdminMail( $form, $model ) {

		$mailProperties = $this->mailProperties;

		$fromEmail 	= $mailProperties->getSenderEmail();
		$fromName 	= $mailProperties->getSenderName();
		$adminName	= $mailProperties->getContactName();
		$adminEmail	= $mailProperties->getContactEmail();
		$subject	= '';

		// Subject
		if( isset( $model->subject ) ) {

			$subject = $model->subject;
		}
		else {

			$subject = $form->name;
		}

		if( empty( $adminEmail ) ) {

			return;
		}

		// Admin Mail
        $this->getMailer()->compose( self::MAIL_GENERIC_ADMIN, [ 'coreProperties' => $this->coreProperties, 'form' => $form, 'model' => $model, 'name' => $adminName, 'email' => $adminEmail ] )
            ->setTo( $adminEmail )
            ->setFrom( [ $fromEmail => $fromName ] )
            ->setSubject( $subject )
            //->setTextBody( $contact->contact_message )
            ->send();
    }

}
