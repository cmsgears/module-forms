<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Update Form';

// Sidebar
$this->params['sidebar-parent'] = 'sidebar-form';
$this->params['sidebar-child'] 	= 'form';
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		<h2>Update Form</h2>
		<?php $form = ActiveForm::begin( ['id' => 'frm-form-update', 'options' => ['class' => 'frm-split' ] ] );?>

		<?= $form->field( $model, 'name' ) ?>
		<?= $form->field( $model, 'description' )->textarea() ?>
		<?= $form->field( $model, 'templateId' )->dropDownList( $templatesMap ) ?>
		<?= $form->field( $model, 'successMessage' )->textarea() ?>
		<?= $form->field( $model, 'jsonStorage' )->checkbox() ?>
		<?= $form->field( $model, 'options' )->textarea() ?>

		<div class="box-filler"></div>

		<?=Html::a( "Cancel", [ '/cmgforms/form/all' ], ['class' => 'btn' ] );?>
		<input type="submit" value="update" />

		<?php ActiveForm::end(); ?>
	</div>
</section>