<?php
namespace cmsgears\forms\common\components;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\forms\common\config\FormsGlobal;

/**
 * The mail component for CMSGears forms module. It must be initialised for app using the name cmgFormsMailer. 
 */
class Mailer extends \cmsgears\core\common\base\Mailer {

	// Various mail views
	const MAIL_GENERIC			= "generic";
	const MAIL_GENERIC_ADMIN	= "generic-admin";

    public $htmlLayout 		= '@cmsgears/module-forms/common/mails/layouts/html';
    public $textLayout 		= '@cmsgears/module-forms/common/mails/layouts/text';
    public $viewPath 		= '@cmsgears/module-forms/common/mails/views';

    public function sendUserMail( $form, $model ) {

		$mailProperties	= $this->mailProperties;
		$fromEmail 		= $mailProperties->getContactEmail();
		$fromName 		= $mailProperties->getContactName();
		$toEmail		= null;
		$name			= null;
		$subject		= '';

		// Email, Name
		if( isset( $model->email ) ) {

			$toEmail = $model->email;
		}

		if( isset( $model->name ) ) {

			$name = $model->name;
		}

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

		if( !isset( $name ) && isset( $toEmail ) ) {
	
			$name	= preg_split( "/@", $toEmail );
			$name	= $name[0];
		}

		// Subject
		if( isset( $model->subject ) ) {

			$subject = $model->subject;
		}
		else {
			
			$subject	= "Contact";
		}

		if( isset( $toEmail ) ) {

	        $this->getMailer()->compose( self::MAIL_GENERIC, [ 'coreProperties' => $this->coreProperties, 'form' => $form, 'model' => $model, 'name' => $name ] )
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
			
			$subject	= "Contact";
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