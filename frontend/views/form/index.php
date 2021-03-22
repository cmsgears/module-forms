<?php
// CMG Imports
use cmsgears\core\common\widgets\ActiveForm;

use cmsgears\widgets\form\BasicFormWidget;
?>
<div class="rounded rounded-medium">
	<?php if( Yii::$app->session->hasFlash( 'message' ) ) {  ?>
		<p class="margin margin-medium-v"><?=Yii::$app->session->getFlash( 'message' )?></p>
	<?php } else { ?>
		<?php $activeForm = ActiveForm::begin( [ 'options' => [ 'class' => $formClass ] ] ); ?>

			<?= BasicFormWidget::widget([
				'model' => $model, 'form' => $form,
				'activeForm' => $activeForm, 'captchaAction' => '/forms/form/captcha',
				'wrapCaptcha' => true, 'wrapActions' => true,
				'labels' => true, 'split4060' => true
			])?>

		<?php ActiveForm::end(); ?>
	<?php } ?>
</div>
