<?php
 	use yii\grid\GridView;
 	use yii\helpers\Html;
 	function setOption($title){
 		return [
 		'class' => 'form-control',
 		'prompt' => $title
 		];
 	}
 	echo Html::beginForm('?r=summary/summary-inventory/low-stock', 'get');
 ?>
 	<div class="row form-group">
 		<div class="col-md-6 col-xs-6 col-lg-6"></div>
	 	<div class="col-md-2 col-xs-2 col-lg-2">
			 <?php
			  echo	Html::dropDownList('warehouse', Yii::$app->request->get('warehouse'), $warehouseList, setOption('Select Warehouse'));
			 ?>
	 	</div>
	 	<div class="col-md-2 col-xs-2 col-lg-2">
			 <?php
			  echo	Html::dropDownList('category', Yii::$app->request->get('category'), $categoryList, setOption('Select Category'));
			 ?>
	 	</div>
	 	<div class="col-md-2 col-xs-2 col-lg-2">
			 <?php echo Html::submitButton('Search', ['class' => 'btn btn-success']) ?>
	 	</div>
 	</div>
 	<div class="row form-group">
 <?php
 	echo Html::endForm();
	echo GridView::widget([
		'dataProvider' => $model,
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
							 	$tag .= $value['warehouse_id']['name']. ' &nbsp;('. $value['quantity'].')'. '<br>';
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
</div>