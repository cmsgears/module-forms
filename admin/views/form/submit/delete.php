<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Delete Form Field';

// Sidebar
$this->params['sidebar-parent'] = 'sidebar-form';
$this->params['sidebar-child'] 	= 'form';
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		<h2>Delete Form Submit</h2>
		<?php $form = ActiveForm::begin( ['id' => 'frm-field-delete', 'options' => ['class' => 'frm-split' ] ] );?>

		<?= $form->field( $model, 'submittedAt' )->textInput( [ 'readonly' => true ] ) ?>
		
		<table style='width:100%;'>
		<?php 
			if( $model->jsonStorage ) {
				
				$formData	= json_decode( $model->data, true );
				
				foreach (  $formData as $key => $value ) {
					
					echo "<tr><td>$key</td><td>$value</td></tr>";
				}
			}
			else {
				
				$formFields	= $model->fields;

				foreach (  $formFields as $formField ) {
					
					echo "<tr><td>$formField->name</td><td>$formField->value</td></tr>";
				}
			}
		?>
		</table>

		<div class="box-filler"></div>

		<?=Html::a( 'Cancel', [ "/cmgforms/form/submit/all?formid=$formId" ], ['class' => 'btn' ] );?>
		<input type="submit" value="Delete" />

		<?php ActiveForm::end(); ?>
	</div>
</section>