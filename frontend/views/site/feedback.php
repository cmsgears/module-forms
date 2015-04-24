<?php
use yii\widgets\ActiveForm;
?>
<h1>Feedback</h1>
<?php if( Yii::$app->session->hasFlash( "success" ) ) { ?>
	<p> <?php echo Yii::$app->session->getFlash( "success" ); ?> </p>
<?php		
	}
	else {

    	$form = ActiveForm::begin( [ 'id' => 'frm-feedback' ] ); 
    ?>

    	<?= $form->field( $model, 'name' )->textInput( [ 'placeholder' => 'Name*' ] )->label( false ) ?>
    	<?= $form->field( $model, 'email' )->textInput( [ 'placeholder' => 'Email*' ] )->label( false ) ?>

		<!-- rating -->
		<label for="fields['rating'].value">Ratings</label>
		<input id="feedbackform-rating" class="form-control" type="range" min="0" max="5" value="0" step="0.5" name="FeedbackForm[rating]" value="<?=$model->rating?>" />

    	<?= $form->field( $model, 'message' )->textArea( [ 'rows' => 6 ] ) ?>

    	<input type="submit" value="Send" />
<?php
		ActiveForm::end();
	}
?>