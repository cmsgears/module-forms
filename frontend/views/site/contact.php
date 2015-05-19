<?php
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;
?>
<h1>Contact Us</h1>
<?php if( Yii::$app->session->hasFlash( "success" ) ) { ?>
	<p> <?php echo Yii::$app->session->getFlash( "success" ); ?> </p>
<?php		
	}
	else {

    	$form = ActiveForm::begin( [ 'id' => 'frm-contact' ] ); 
    ?>

    	<?= $form->field( $model, 'name' )->textInput( [ 'placeholder' => 'Name*' ] )->label( false ) ?>
    	<?= $form->field( $model, 'email' )->textInput( [ 'placeholder' => 'Email*' ] )->label( false ) ?>
    	<?= $form->field( $model, 'subject' )->textInput( [ 'placeholder' => 'Subject*' ] )->label( false ) ?>
    	<?= $form->field( $model, 'message' )->textArea( [ 'placeholder' => 'Message*', 'rows' => 6 ] )->label( false ) ?>

		<?= $form->field( $model, 'captcha' )->label( false )->widget( Captcha::classname(), [ 'options' => [ 'placeholder' => 'Captcha*' ] ] ) ?>

    	<input type="submit" value="Send" />
<?php
		ActiveForm::end();
	}
?>