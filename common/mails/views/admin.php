<?php
// Yii Imports
use yii\helpers\Html;

$siteProperties = Yii::$app->controller->getSiteProperties();

$defaultIncludes = Yii::getAlias( '@cmsgears' ) . '/module-core/common/mails/views/includes';

$name	= Html::encode( $name );
$email	= Html::encode( $email );

$siteName	= Html::encode( $coreProperties->getSiteName() );
$siteUrl	= Html::encode( $coreProperties->getSiteUrl() );
$logoUrl	= "$siteUrl/images/" . $siteProperties->getMailAvatar();
$homeUrl	= $siteUrl;
$siteBkg	= "$siteUrl/images/" . $siteProperties->getMailBanner();

$fields = $model->fields;
?>
<?php include "$defaultIncludes/header.php"; ?>
<table cellspacing="0" cellpadding="0" border="0" margin="0" padding="0" width="80%" align="center" class="ctmax">
	<tr><td height="40"></td></tr>
	<tr>
		<td><font face="Roboto, Arial, sans-serif">Dear <?= $name ?>,</font></td>
	</tr>
	<tr><td height="20"></td></tr>
	<tr>
		<td>
			<font face="Roboto, Arial, sans-serif">A new form is submitted for <?= $form->name ?>. The details are as listed below:</font>
		</td>
	</tr>
	<tr><td height="20"></td></tr>
	<?php
		foreach( $fields as $field ) {

			$fieldName = isset( $field->label ) ? $field->label :  $field->name;
			$fieldName = strtolower( $fieldName );
	?>
		<tr><td><font face="Roboto, Arial, sans-serif"><?= ucfirst( $fieldName ) ?>: <?= Html::encode( $model->$fieldName ) ?></font></td></tr>
	<?php } ?>
	<tr><td height="40"></td></tr>
</table>
<?php include "$defaultIncludes/footer.php"; ?>
