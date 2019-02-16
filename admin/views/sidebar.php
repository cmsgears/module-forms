<?php
// Yii Imports
use yii\helpers\Html;

// CMG Imports
use cmsgears\forms\common\config\FormsGlobal;

$core	= Yii::$app->core;
$user	= $core->getUser();
?>
<?php if( $core->hasModule( 'forms' ) && $user->isPermitted( FormsGlobal::PERM_FORM_ADMIN ) ) { ?>
	<div id="sidebar-form" class="collapsible-tab has-children <?php if( strcmp( $parent, 'sidebar-form' ) == 0 ) echo 'active';?>">
		<div class="row tab-header">
			<div class="tab-icon"><span class="cmti cmti-checkbox-b-active"></span></div>
			<div class="tab-title">Forms</div>
		</div>
		<div class="tab-content clear <?php if( strcmp( $parent, 'sidebar-form' ) == 0 ) echo 'expanded visible';?>">
			<ul>
				<li class='form <?php if( strcmp( $child, 'form' ) == 0 ) echo 'active';?>'><?= Html::a( "Forms", ['/forms/form/all'] ) ?></li>
				<li class='config <?php if( strcmp( $child, 'config' ) == 0 ) echo 'active';?>'><?= Html::a( "Configs", ['/forms/config/all'] ) ?></li>
				<li class='template <?php if( strcmp( $child, 'template' ) == 0 ) echo 'active';?>'><?= Html::a( "Templates", ['/forms/form/template/all'] ) ?></li>
			</ul>
		</div>
	</div>
<?php } ?>
