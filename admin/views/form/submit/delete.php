<?php
// Yii Imports
use yii\helpers\Html;

// CMG Imports
use cmsgears\core\common\widgets\ActiveForm;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= 'Delete Submit | ' . $coreProperties->getSiteTitle();
$returnUrl		= $this->context->returnUrl;
?>
<div class="box box-cud">
	<div class="box-wrap-header">
		<div class="header">Delete Submit</div>
	</div>
	<div class="box-wrap-content frm-split-40-60">
		<?php $form = ActiveForm::begin( [ 'id' => 'frm-gallery' ] );?>

		<?= $form->field( $model, 'submittedAt' )->textInput( [ 'readonly' => true ] ) ?>

		<div class="box-content">
			<div class="info">
				<table style='width:100%;'>
				<?php
					$formData	= json_decode( $model->data, true );

					foreach (  $formData as $key => $value ) {

						echo "<tr><td>$key</td><td>$value</td></tr>";
					}

					$formFields	= $model->fields;

					foreach (  $formFields as $formField ) {

						echo "<tr><td>$formField->name</td><td>$formField->value</td></tr>";
					}
				?>
				</table>
			</div>
		</div>

		<div class="clear filler-height"></div>

		<div class="align align-center">
			<?=Html::a( 'Cancel', $returnUrl, [ 'class' => 'btn btn-medium' ] );?>
			<input class="element-medium" type="submit" value="Delete" />
		</div>

		<?php ActiveForm::end(); ?>
	</div>
</div>