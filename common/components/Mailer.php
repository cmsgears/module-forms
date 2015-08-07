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
	const MAIL_CONTACT			= "contact";
	const MAIL_CONTACT_ADMIN	= "contact-admin";
	const MAIL_FEEDBACK			= "feedback";
	const MAIL_FEEDBACK_ADMIN	= "feedback-admin";

    public $htmlLayout 		= '@cmsgears/module-forms/common/mails/layouts/html';
    public $textLayout 		= '@cmsgears/module-forms/common/mails/layouts/text';
    public $viewPath 		= '@cmsgears/module-forms/common/mails/views';

    public function sendContactMail( $contactForm ) {
		
		$mailProperties	= $this->mailProperties;
		$adminEmail		= $mailProperties->getSenderEmail();
		$adminName		= $mailProperties->getSenderName();

		$fromEmail 		= $mailProperties->getContactEmail();
		$fromName 		= $mailProperties->getContactName();

		// User Mail
        $this->getMailer()->compose( self::MAIL_CONTACT, [ 'coreProperties' => $this->coreProperties, FormsGlobal::FORM_CONTACT => $contactForm ] )
            ->setTo( $contactForm->email )
            ->setFrom( [ $fromEmail => $fromName ] )
            ->setSubject( $contactForm->subject )
            //->setTextBody( $contact->contact_message )
            ->send();

		// Admin Mail
        $this->getMailer()->compose( self::MAIL_CONTACT_ADMIN, [ 'coreProperties' => $this->coreProperties, 'mailProperties' => $mailProperties, FormsGlobal::FORM_CONTACT => $contactForm ] )
            ->setTo( $fromEmail )
            ->setFrom( [ $adminEmail => $adminName ] )
            ->setSubject( $contactForm->subject )
            //->setTextBody( $contact->contact_message )
            ->send();
    }

    public function sendFeedbackMail( $feedbackForm ) {
		
		$mailProperties	= $this->mailProperties;
		$adminEmail		= $mailProperties->getSenderEmail();
		$fromEmail 		= $mailProperties->getContactEmail();
		$fromName 		= $mailProperties->getContactName();

		// User Mail
        $this->getMailer()->compose( self::MAIL_FEEDBACK, [ 'coreProperties' => $this->coreProperties, FormsGlobal::FORM_FEEDBACK => $feedbackForm ] )
            ->setTo( $feedbackForm->email )
            ->setFrom( [ $fromEmail => $fromName ] )
            ->setSubject( "Re: Feedback" )
            //->setTextBody( $contact->contact_message )
            ->send();

		// Admin Mail
        $this->getMailer()->compose( self::MAIL_FEEDBACK_ADMIN, [ 'coreProperties' => $this->coreProperties, 'mailProperties' => $mailProperties, FormsGlobal::FORM_FEEDBACK => $feedbackForm ] )
            ->setTo( $fromEmail )
            ->setFrom( [ $adminEmail => $adminName ] )
            ->setSubject( "Re: Feedback" )
            //->setTextBody( $contact->contact_message )
            ->send();
    }
}

?>