<?php
 	use yii\grid\GridView;
	
	function genArrayIndex($model, $label, $attribute){
		return [
					'label' => Yii::t('app', $label),
					'format' => 'raw',
					'attribute' => $attribute,
					'value' => $attribute
		];
	}
	$genColumn[] = genArrayIndex($model, 'sku', 'sku');
	$genColumn[] = genArrayIndex($model, 'Name Product', 'name');
	foreach($list as $key => $value){
		$genColumn[] = genArrayIndex($model, $value['name'], $value['name']);
	}
	$genColumn[] = genArrayIndex($model, 'Quantity', 'quantity');
	$genColumn[] = genArrayIndex($model, 'Reserved', 'reserved');
	$genColumn[] = genArrayIndex($model, 'cost' ,'cost');
	echo GridView::widget([
		'dataProvider' => $model,
		'columns'=> $genColumn,
	]);
?>
