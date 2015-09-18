<?php
// Yii Imports
use \Yii;
use yii\helpers\Html;
use yii\helpers\Url;

$core	= Yii::$app->cmgCore;
$user	= Yii::$app->user->getIdentity();
?>

<?php if( $core->hasModule( 'cmgforms' ) && $user->isPermitted( 'form' ) ) { ?>
	<div id="sidebar-form" class="collapsible-tab <?php if( strcmp( $parent, 'sidebar-form' ) == 0 ) echo 'active';?>">
		<div class="collapsible-tab-header">
			<a href="<?php echo Url::toRoute( ['/cmgforms/form/all'] ); ?>">
				<div class="colf colf4"><span class="icon-sidebar icon-slider"></span></div>
				<div class="colf colf4x3">Forms</div>
			</a>
		</div>
	</div>
<?php } ?>