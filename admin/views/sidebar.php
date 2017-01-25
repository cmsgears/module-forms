<?php
// Yii Imports
use yii\helpers\Html;
use yii\helpers\Url;

$core	= Yii::$app->core;
$user	= Yii::$app->user->getIdentity();
?>

<?php if( $core->hasModule( 'forms' ) && $user->isPermitted( 'form' ) ) { ?>
	<div id="sidebar-form" class="collapsible-tab has-children <?php if( strcmp( $parent, 'sidebar-form' ) == 0 ) echo 'active';?>">
		<div class="collapsible-tab-header clearfix">
			<div class="colf colf5 wrap-icon"><span class="cmti cmti-checkbox-b-active"></span></div>
			<div class="colf colf5x4">Forms</div>
		</div>
		<div class="collapsible-tab-content clear <?php if( strcmp( $parent, 'sidebar-form' ) == 0 ) echo 'expanded visible';?>">
			<ul>
				<li class='form <?php if( strcmp( $child, 'form' ) == 0 ) echo 'active';?>'><?= Html::a( "Forms", ['/forms/form/all'] ) ?></li>
				<li class='form <?php if( strcmp( $child, 'form-config' ) == 0 ) echo 'active';?>'><?= Html::a( "Config Forms", ['/forms/config/all'] ) ?></li>
				<li class='form-template <?php if( strcmp( $child, 'form-template' ) == 0 ) echo 'active';?>'><?= Html::a( "Form Templates", ['/forms/form/template/all'] ) ?></li>
			</ul>
		</div>
	</div>
<?php } ?>