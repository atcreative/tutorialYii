<?php
 	use yii\grid\GridView;
 	use yii\helpers\Html;
 ?>
 	<h3>Top product sale</h3>
 <?php
 	echo GridView::widget([
		'dataProvider' => $model,
		'columns' => ['name', 'total']
	]);
?>