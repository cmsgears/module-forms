<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | Add Form';

// Sidebar
$this->params['sidebar-parent'] = 'sidebar-form';
$this->params['sidebar-child'] 	= 'form';
?>
<section class="wrap-content container clearfix">
	<div class="cud-box">
		<h2>Add Form</h2>
		<?php $form = ActiveForm::begin( ['id' => 'frm-form-create', 'options' => ['class' => 'frm-split' ] ] );?>

		<?= $form->field( $model, 'name' ) ?>
		<?= $form->field( $model, 'description' )->textarea() ?>
		<?= $form->field( $model, 'templateId' )->dropDownList( $templatesMap ) ?>
		<?= $form->field( $model, 'successMessage' )->textarea() ?>
		<?= $form->field( $model, 'jsonStorage' )->checkbox() ?>
		<?= $form->field( $model, 'captcha' )->checkbox() ?>
		<?= $form->field( $model, 'visibility' )->dropDownList( $visibilityMap ) ?>
		<?= $form->field( $model, 'active' )->checkbox() ?>
		<?= $form->field( $model, 'userMail' )->checkbox() ?>
		<?= $form->field( $model, 'adminMail' )->checkbox() ?>
		<?= $form->field( $model, 'options' )->textarea() ?>

		<div class="box-filler"></div>

		<?=Html::a( "Cancel", [ '/cmgforms/form/all' ], ['class' => 'btn' ] );?>
		<input type="submit" value="Create" />

		<?php ActiveForm::end(); ?>
	</div>
</section>