<?php
use yii\widgets\ActiveForm;
?>
<section class="container row clearfix">
    <h1>CONTACT US</h1>
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
            	<?= $form->field( $model, 'subject' ) ?>
            	<?= $form->field( $model, 'message' )->textArea( [ 'rows' => 6 ] ) ?>

            	<input type="submit" value="Send" />
		<?php
        		ActiveForm::end();
			}
        ?>
    </div>
</section>