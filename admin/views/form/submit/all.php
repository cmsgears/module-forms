<?php
use \Yii;
use yii\helpers\Html; 
use yii\widgets\LinkPager;

use cmsgears\core\common\utilities\CodeGenUtil;

$coreProperties = $this->context->getCoreProperties();
$this->title 	= $coreProperties->getSiteTitle() . ' | All Forms';
$siteUrl		= $coreProperties->getSiteUrl();

// Sidebar
$this->params['sidebar-parent'] = 'sidebar-form';
$this->params['sidebar-child'] 	= 'form';

// Data
$pagination		= $dataProvider->getPagination();
$models			= $dataProvider->getModels();

// Searching
$searchTerms	= Yii::$app->request->getQueryParam( 'search' );

// Sorting
$sortOrder		= Yii::$app->request->getQueryParam( 'sort' );

if( !isset( $sortOrder ) ) {

	$sortOrder	= '';
}
?>
<div class="content-header clearfix">
	<div class="header-actions"></div>
	<div class="header-search"></div>
</div>
<div class="data-grid">
	<div class="grid-header">
		<?= LinkPager::widget( [ 'pagination' => $pagination ] ); ?>
	</div>
	<div class="wrap-grid">
		<table>
			<thead>
				<tr>
					<th>Form Data</th>
					<th>SubmittedAt
						<span class='box-icon-sort'>
							<span sort-order='sdate' class="icon-sort <?php if( strcmp( $sortOrder, 'sdate') == 0 ) echo 'icon-up-active'; else echo 'icon-up';?>"></span>
							<span sort-order='-sdate' class="icon-sort <?php if( strcmp( $sortOrder, '-sdate') == 0 ) echo 'icon-down-active'; else echo 'icon-down';?>"></span>
						</span>
					</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php

					$slugBase	= $siteUrl;

					foreach( $models as $formSubmit ) {

						$id 		= $formSubmit->id;
				?>
					<tr>
						<td>
							<table>
							<?php 
								$formData	= json_decode( $formSubmit->data, true );
								
								foreach (  $formData as $key => $value ) {
									
									echo "<tr><td>$key</td><td>$value</td></tr>";
								}

								$formFields	= $formSubmit->fields;

								foreach (  $formFields as $formField ) {
									
									echo "<tr><td>$formField->name</td><td>$formField->value</td></tr>";
								}
							?>
							</table>
						</td>
						<td><?= $formSubmit->submittedAt ?></td>
						<td>
							<span class="wrap-icon-action" title="Delete Form"><?= Html::a( "", ["/cmgforms/form/submit/delete?id=$id"], ['class'=>'icon-action icon-action-delete'] )  ?></span>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<div class="grid-footer">
		<div class="text"> <?=CodeGenUtil::getPaginationDetail( $dataProvider ) ?> </div>
		<?= LinkPager::widget( [ 'pagination' => $pagination ] ); ?>
	</div>
</div>