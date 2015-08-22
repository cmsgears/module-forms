<?php
use yii\helpers\Html;
use yii\helpers\Url;

$logoUrl		= Yii::getAlias( "@web" );
$logoUrl		= Url::to( $logoUrl. "/images/logo-mail.png", true );

$logo 			= "<img class='logo' style='height:35px;float:right; margin-top:6px; margin-right:53px' src='$logoUrl'>";
$siteName		= $coreProperties->getSiteName();

$adminName		= $mailProperties->getSenderName();

$name 			= Html::encode( $contact->name );
$email 			= Html::encode( $contact->email );
$subject 		= Html::encode( $contact->subject );
$message 		= Html::encode( $contact->message );
?>
<table cellspacing='0' cellpadding='2' border='0' align='center' width='805px' style='font-family: Calibri; color: #4f4f4f; font-size: 14px; font-weight: 400;'>
	<tbody>
		<tr>
 			<td>
 				<div style='width:100%; margin:0 auto; min-height:45px; background-color:#f6f9f4; text-align: center;'>
 					<?=$logo?>
 				</div>
 			</td>
		</tr>
		<tr>
			<td>
				<div style='margin-top:60px;'>Dear <?=$adminName?>,</div>
			</td>
		</tr>
		<tr>
			<td>
				<br/>A new contact form is submitted.<br/>
			</td>
		</tr>
		<tr> <td>Name: <?=$name?></td> </tr>
		<tr> <td>Email: <?=$email?></td> </tr>
		<tr> <td>Subject: <?=$subject?></td> </tr>
		<tr> <td>Message: <?=$message?></td> </tr>
		<tr> 
			<td>
  				<div style='line-height:15px; margin:0px; padding:0px; margin-top:30px;'>Sincerely,</div>
  				<div style='line-height:15px; margin:0px; padding:0px; margin-top:3px;'><?=$siteName?> Team</div>
  			</td>
		</tr>
	</tbody>
</table>