<?php
namespace cmsgears\forms\common\components;

// Yii Imports
use \Yii;
use yii\base\Component;

// CMG Imports
use cmsgears\forms\common\config\FormsGlobal;

/**
 * The mail component for CMSGears forms module. It must be initialised for app using the name cmgFormsMailer. 
 */
class Mailer extends \cmsgears\core\common\components\Mailer {

	// Various mail views
	const MAIL_CONTACT		= "contact";
	const MAIL_FEEDBACK		= "feedback";

    public $htmlLayout 		= '@cmsgears/module-forms/common/mails/layouts/html';
    public $textLayout 		= '@cmsgears/module-forms/common/mails/layouts/text';
    public $viewPath 		= '@cmsgears/module-forms/common/mails/views';

    public function sendContactMail( $coreProperties, $mailProperties, $contactForm ) {

		$fromEmail 	= $mailProperties->getContactEmail();
		$fromName 	= $mailProperties->getContactName();

        $this->getMailer()->compose( self::MAIL_CONTACT, [ 'coreProperties' => $coreProperties, FormsGlobal::FORM_CONTACT => $contactForm ] )
            ->setTo( $contactForm->email )
            ->setFrom( [ $fromEmail => $fromName ] )
            ->setSubject( $contactForm->subject )
            //->setTextBody( $contact->contact_message )
            ->send();
    }

    public function sendFeedbackMail( $coreProperties, $mailProperties, $feedbackForm ) {

		$fromEmail 	= $mailProperties->getContactEmail();
		$fromName 	= $mailProperties->getContactName();

        $this->getMailer()->compose( self::MAIL_FEEDBACK, [ 'coreProperties' => $coreProperties, FormsGlobal::FORM_FEEDBACK => $feedbackForm ] )
            ->setTo( $feedbackForm->email )
            ->setFrom( [ $fromEmail => $fromName ] )
            ->setSubject( "Re: Feedback" )
            //->setTextBody( $contact->contact_message )
            ->send();
    }
}

?>