<?php
use yii\widgets\ActiveForm;
?>
<section class="container row clearfix">
    <h1>Feedback</h1>
    <div class="col col2 no-float-center">
    	<?php if( Yii::$app->session->hasFlash( "success" ) ) { ?>
			<p> <?php echo Yii::$app->session->getFlash( "success" ); ?> </p>
		<?php		
			}
			else {

        		$form = ActiveForm::begin( ['id' => 'frm-contact'] ); 
        ?>

            	<?= $form->field( $model, 'name' ) ?>
            	<?= $form->field( $model, 'email' ) ?>

				<!-- rating -->
				<label for="fields['rating'].value">Ratings</label>
				<input type="range" min="0" max="5" value="0" step="0.5" id="feedbackform-rating" class="form-control" name="FeedbackForm[rating]" value="<?=$model->rating?>" />
				<div class="rateit" data-rateit-backingfld="#feedbackform-rating"></div>

            	<?= $form->field( $model, 'message' )->textArea( [ 'rows' => 6 ] ) ?>

            	<input type="submit" value="Send" />
		<?php
        		ActiveForm::end();
			}
        ?>
    </div>
</section>