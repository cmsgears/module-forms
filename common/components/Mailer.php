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
class Mailer extends Component {

	// Various mail views
	const MAIL_CONTACT			= "contact";
	const MAIL_CONTACT_ADMIN	= "contact-admin";
	const MAIL_FEEDBACK			= "feedback";
	const MAIL_FEEDBACK_ADMIN	= "feedback-admin";

    public $htmlLayout 		= '@cmsgears/module-forms/common/mails/layouts/html';
    public $textLayout 		= '@cmsgears/module-forms/common/mails/layouts/text';
    public $viewPath 		= '@cmsgears/module-forms/common/mails/views';

	private $mailer;

	/**
	 * Initialise the CMG Core Mailer.
	 */
    public function init() {

        parent::init();

        $this->mailer = Yii::$app->getMailer();

        $this->mailer->htmlLayout 	= $this->htmlLayout;
        $this->mailer->textLayout 	= $this->textLayout;
        $this->mailer->viewPath 	= $this->viewPath;
    }
	
	/**
	 * @return core mailer
	 */
	public function getMailer() {

		return $this->mailer;
	}

    public function sendContactMail( $coreProperties, $mailProperties, $contactForm ) {

		$adminEmail	= $mailProperties->getSenderEmail();
		$adminName	= $mailProperties->getSenderName();

		$fromEmail 	= $mailProperties->getContactEmail();
		$fromName 	= $mailProperties->getContactName();

		// User Mail
        $this->getMailer()->compose( self::MAIL_CONTACT, [ 'coreProperties' => $coreProperties, FormsGlobal::FORM_CONTACT => $contactForm ] )
            ->setTo( $contactForm->email )
            ->setFrom( [ $fromEmail => $fromName ] )
            ->setSubject( $contactForm->subject )
            //->setTextBody( $contact->contact_message )
            ->send();

		// Admin Mail
        $this->getMailer()->compose( self::MAIL_CONTACT_ADMIN, [ 'coreProperties' => $coreProperties, 'mailProperties' => $mailProperties, FormsGlobal::FORM_CONTACT => $contactForm ] )
            ->setTo( $fromEmail )
            ->setFrom( [ $adminEmail => $adminName ] )
            ->setSubject( $contactForm->subject )
            //->setTextBody( $contact->contact_message )
            ->send();
    }

    public function sendFeedbackMail( $coreProperties, $mailProperties, $feedbackForm ) {
		
		$adminEmail	= $mailProperties->getSenderEmail();
		$fromEmail 	= $mailProperties->getContactEmail();
		$fromName 	= $mailProperties->getContactName();

		// User Mail
        $this->getMailer()->compose( self::MAIL_FEEDBACK, [ 'coreProperties' => $coreProperties, FormsGlobal::FORM_FEEDBACK => $feedbackForm ] )
            ->setTo( $feedbackForm->email )
            ->setFrom( [ $fromEmail => $fromName ] )
            ->setSubject( "Re: Feedback" )
            //->setTextBody( $contact->contact_message )
            ->send();

		// Admin Mail
        $this->getMailer()->compose( self::MAIL_FEEDBACK_ADMIN, [ 'coreProperties' => $coreProperties, 'mailProperties' => $mailProperties, FormsGlobal::FORM_FEEDBACK => $feedbackForm ] )
            ->setTo( $fromEmail )
            ->setFrom( [ $adminEmail => $adminName ] )
            ->setSubject( "Re: Feedback" )
            //->setTextBody( $contact->contact_message )
            ->send();
    }
}

?>