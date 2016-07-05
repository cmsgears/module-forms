<?php
namespace cmsgears\forms\common\components;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\forms\common\config\FormsGlobal;

/**
 * The mail component for CMSGears forms module. It must be initialised for app using the name cmgFormsMailer.
 */
class Mailer extends \cmsgears\core\common\base\Mailer {

	// Variables ---------------------------------------------------

	// Global -----------------

	const MAIL_GENERIC_USER		= 'user';
	const MAIL_GENERIC_ADMIN	= 'admin';

	// Public -----------------

    public $htmlLayout 		= '@cmsgears/module-forms/common/mails/layouts/html';
    public $textLayout 		= '@cmsgears/module-forms/common/mails/layouts/text';
    public $viewPath 		= '@cmsgears/module-forms/common/mails/views';

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// CMG parent classes --------------------

	// Mailer --------------------------------

    public function sendUserMail( $form, $model ) {

		$mailProperties	= $this->mailProperties;
		$fromEmail 		= $mailProperties->getContactEmail();
		$fromName 		= $mailProperties->getContactName();
		$toEmail		= null;
		$name			= null;
		$subject		= '';

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

			$user	= Yii::$app->user->getIdentity();

			if( isset( $user ) ) {

				if( !isset( $toEmail ) ) {

					$toEmail	= $user->email;
				}

				if( !isset( $name ) ) {

					$name	= $user->getName();
				}
			}
		}

		// Name
		if( !isset( $name ) && isset( $toEmail ) ) {

			$name	= preg_split( "/@", $toEmail );
			$name	= $name[0];
		}

		// Subject
		if( isset( $model->subject ) ) {

			$subject = $model->subject;
		}
		else {

			$subject	= $form->name;
		}

		if( isset( $toEmail ) ) {

	        $this->getMailer()->compose( self::MAIL_GENERIC_USER, [ 'coreProperties' => $this->coreProperties, 'form' => $form, 'model' => $model, 'name' => $name ] )
	            ->setTo( $toEmail )
	            ->setFrom( [ $fromEmail => $fromName ] )
	            ->setSubject( $subject )
	            //->setTextBody( $contact->contact_message )
	            ->send();
		}
    }

    public function sendAdminMail( $form, $model ) {

		$mailProperties	= $this->mailProperties;
		$fromEmail 		= $mailProperties->getSenderEmail();
		$fromName 		= $mailProperties->getSenderName();

		$adminEmail		= $mailProperties->getContactEmail();
		$subject		= '';

		// Subject
		if( isset( $model->subject ) ) {

			$subject = $model->subject;
		}
		else {

			$subject	= $form->name;
		}

		// Admin Mail
        $this->getMailer()->compose( self::MAIL_GENERIC_ADMIN, [ 'coreProperties' => $this->coreProperties, 'form' => $form, 'model' => $model, 'name' => $fromName ] )
            ->setTo( $adminEmail )
            ->setFrom( [ $fromEmail => $fromName ] )
            ->setSubject( $subject )
            //->setTextBody( $contact->contact_message )
            ->send();
    }
}

?>