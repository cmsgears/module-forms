<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Update Form Field';

// Sidebar
$this->params['sidebar-parent'] = 'sidebar-form';
$this->params['sidebar-child'] 	= 'form';
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		<h2>Update Form Field</h2>
		<?php $form = ActiveForm::begin( ['id' => 'frm-field-update', 'options' => ['class' => 'frm-split' ] ] );?>

		<?= $form->field( $model, 'name' ) ?>
		<?= $form->field( $model, 'label' ) ?>
		<?= $form->field( $model, 'type' )->dropDownList( $typeMap ) ?>
		<?= $form->field( $model, 'options' )->textarea() ?>
		<?= $form->field( $model, 'meta' )->textarea() ?>

		<div class="box-filler"></div>

		<?=Html::a( 'Cancel', [ "/cmgforms/form/field/all?formid=$formId" ], ['class' => 'btn' ] );?>
		<input type="submit" value="Update" />

		<?php ActiveForm::end(); ?>
	</div>
</section>