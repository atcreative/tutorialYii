<?php
 	use yii\grid\GridView;
	echo GridView::widget([
		'dataProvider' => $provider,
		'columns' => [
				[
					'label' => Yii::t('app', 'sku'),
					'format' => 'raw',
					'attribute' => 'sku',
					'value' => function($model){
						return $model['sku'];
					},
				],
				[
					'label' => Yii::t('app', 'name'),
					'format' => 'raw',
					'attribute' => 'name',
					'value' => function($model){
						return $model['name'];
					},
				],
				[
					'label' => Yii::t('app', 'Warehouse'),
					'format' => 'raw',
					'attribute' => 'warehouse',
					'value' => function($model){
						$tag = '';
						foreach( $model as $key => $value){
							if(!empty($value['warehouse_id'])){
							 	$tag .= $value['warehouse_id']['name']. '('. $value['quantity'].')'. '<br>';
							}
						}
						return $tag;
					},
				],
				[
					'label' => Yii::t('app', 'Minimum Quantity'),
					'format' => 'raw',
					'attribute' => 'minimum_quantity',
					'value' => function($model){
						return $model['minimum_quantity'];
					},
				],
				[
					'label' => Yii::t('app', 'quantity'),
					'format' => 'raw',
					'attribute' => 'quantity',
					'value' => function($model){
						return $model['quantity'];
					},
				],
			]
		]);
?>
