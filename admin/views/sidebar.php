<?php
// Yii Imports
use \Yii;
use yii\helpers\Html;
use yii\helpers\Url;

$core	= Yii::$app->cmgCore;
$user	= Yii::$app->user->getIdentity();
?>

<?php if( $core->hasModule( 'cmgforms' ) && $user->isPermitted( 'form' ) ) { ?>
	<div id="sidebar-form" class="collapsible-tab has-children <?php if( strcmp( $parent, 'sidebar-form' ) == 0 ) echo 'active';?>">
		<div class="collapsible-tab-header clearfix">
			<div class="colf colf4"><span class="icon-sidebar icon-slider"></span></div>
			<div class="colf colf4x3">Forms</div>
		</div>
		<div class="collapsible-tab-content clear <?php if( strcmp( $parent, 'sidebar-form' ) == 0 ) echo 'expanded visible';?>">
			<ul>
				<li class='form <?php if( strcmp( $child, 'form' ) == 0 ) echo 'active';?>'><?= Html::a( "Forms", ['/cmgforms/form/all'] ) ?></li>
				<li class='form-template <?php if( strcmp( $child, 'form-template' ) == 0 ) echo 'active';?>'><?= Html::a( "Form Templates", ['/cmgforms/form/template/all'] ) ?></li>
			</ul>
		</div>
	</div>
<?php } ?>