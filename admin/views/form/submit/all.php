<?php
// CMG Imports
use cmsgears\widgets\popup\Popup;

use cmsgears\widgets\grid\DataGrid;

$coreProperties = $this->context->getCoreProperties();
$this->title	= 'Form Submits | ' . $coreProperties->getSiteTitle();
$apixBase		= $this->context->apixBase;

// View Templates
$moduleTemplates	= '@cmsgears/module-forms/admin/views/templates';
$themeTemplates		= '@themes/admin/views/templates';
?>
<?= DataGrid::widget([
	'dataProvider' => $dataProvider, 'add' => true, 'addUrl' => 'create', 'data' => [ 'submits' => $submits ],
	'title' => 'Form Submits', 'options' => [ 'class' => 'grid-data grid-data-admin' ],
	'searchColumns' => [ 'user' => 'User', 'email' => 'Email' ],
	'sortColumns' => [
		'user' => 'User', 'email' => 'Email',
		'sdate' => 'Submitted At'
	],
	'filters' => [],
	'reportColumns' => [
		'user' => [ 'title' => 'User', 'type' => 'text' ],
		'email' => [ 'title' => 'Email', 'type' => 'text' ],
		'sdate' => [ 'title' => 'Submitted At', 'type' => 'date' ]
	],
	'bulkPopup' => 'popup-grid-bulk', 'bulkActions' => [
		'model' => [ 'delete' => 'Delete' ]
	],
	'header' => false, 'footer' => true,
	'grid' => true, 'columns' => [ 'root' => 'colf colf15', 'factor' => [ null, 'x7', 'x2', 'x2', 'x2', null ] ],
	'gridColumns' => [
		'bulk' => 'Action',
		'fields' => [ 'title' => 'Fields', 'generate' => function( $model ) {
			ob_start();

			echo "<table>";

			$formData = json_decode( $formSubmit->data, true );

			foreach(  $formData as $key => $value ) {

				echo "<tr><td>$key</td><td>$value</td></tr>";
			}

			$formFields	= $formSubmit->fields;

			foreach (  $formFields as $formField ) {

				echo "<tr><td>$formField->name</td><td>$formField->value</td></tr>";
			}

			echo "</table>";

			$output = ob_get_clean();

			return $output;
		}],
		'user' => [ 'title' => 'User', 'generate' => function( $model ) {
			return isset( $model->user ) ? $model->user->name : null;
		}],
		'email' => [ 'title' => 'Email', 'generate' => function( $model ) {
			return isset( $model->user ) ? $model->user->email : null;
		}],
		'submittedAt' => 'Submitted At',
		'actions' => 'Actions'
	],
	'gridCards' => [ 'root' => 'col col12', 'factor' => 'x3' ],
	'templateDir' => "$themeTemplates/widget/grid",
	//'dataView' => "$moduleTemplates/grid/data/submit",
	//'cardView' => "$moduleTemplates/grid/cards/submit",
	//'actionView' => "$moduleTemplates/grid/actions/submit"
]) ?>

<?= Popup::widget([
	'title' => 'Apply Bulk Action', 'size' => 'medium',
	'templateDir' => Yii::getAlias( "$themeTemplates/widget/popup/grid" ), 'template' => 'bulk',
	'data' => [ 'model' => 'Form', 'grid' => 'main', 'controller' => 'crud', 'action' => 'bulk', 'url' => "$apixBase/bulk" ]
]) ?>

<?= Popup::widget([
	'title' => 'Delete Form', 'size' => 'medium',
	'templateDir' => Yii::getAlias( "$themeTemplates/widget/popup/grid" ), 'template' => 'delete',
	'data' => [ 'model' => 'Form', 'grid' => 'main', 'controller' => 'crud', 'action' => 'delete', 'url' => "$apixBase/delete?id=" ]
]) ?>
