<?php
 	use yii\grid\GridView;
	function genArrayIndex($model, $label, $attribute){
		return [
					'label' => Yii::t('app', $label),
					'format' => 'raw',
					'attribute' => $attribute,
					
		];
	}
	echo GridView::widget([
		'dataProvider' => $model,
		'columns'=> [
			genArrayIndex($model, 'Id', 'id'),
			genArrayIndex($model, 'name', 'name')
		]
	]);
?>
