<?php
	use yii\grid\GridView;
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\web\View;
	echo GridView::widget([
		'dataProvider' => $dataProveder,
		'columns' => ['resource_name', 'status',
			[
				'class' => 'yii\grid\actionColumn',
				'template' => '{edit} {delete}',
				'buttons' => [
					'edit' => function($url, $model, $key){
						return Html::a(
							'<i class="glyphicon glyphicon-pencil"></i>', Url::to(['/permission-resource/', 'id' => $model->id], true)
						);
					}
				],
			]
		]
	]);
?>