<?php
 	use yii\grid\GridView;
 	use yii\Helper;
 	
	function genArrayIndex($model, $label, $attribute){
		$test = 'test';
		return [
					'label' => Yii::t('app', $label),
					'format' => 'raw',
					'attribute' => $attribute,
					'value' => $attribute,
		          
		];
	}
	$genColumn[] = genArrayIndex($model, 'sku', 'sku');
	$genColumn[] = genArrayIndex($model, 'Name Product', 'name');
	foreach($list as $key => $value){
		$genColumn[] = genArrayIndex($model, $value['name'], $value['name']);
	}
	$genColumn[] = [
					'label' => Yii::t('app' , 'Status'),
					'format' => 'raw',
					'attribute' => 'status',
					'value' => function($model){
						if($model['status'] == 0){
							return '<span class="label label-danger" >'. Yii::t('app','Low Stock') . '</span>';
						}else{
							return '<span class="label label-primary" >'. Yii::t('app','In Stock') . '</span>';
						}
						
					}
	];
	$genColumn[] = genArrayIndex($model, 'Quantity', 'quantity');
	$genColumn[] = genArrayIndex($model, 'Reserved', 'reserved');
	$genColumn[] = genArrayIndex($model, 'cost' ,'cost');
	echo GridView::widget([
		'dataProvider' => $model,
		'columns'=> $genColumn,
	]);
?>
