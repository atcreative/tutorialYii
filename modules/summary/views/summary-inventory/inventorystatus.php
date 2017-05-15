<?php
 	use yii\grid\GridView;
 	use yii\helpers\Html;
 	use yii\helpers\Url;
 	function setOption($title){
 		return [
 		'class' => 'form-control',
 		'prompt' => $title
 		];
 	}
 	$this->title = Yii::t('app', 'Inventory Status');
 	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Summary'), 'url' => Url::to(['summary/index'])];
 	$this->params['breadcrumbs'][] = $this->title;
	function genArrayIndex($model, $label, $attribute){
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
	echo Html::beginForm(Url::to(['inventory-status']), 'get');
	?>
		<div class="row form-group">
	 		<div class="col-md-6 col-xs-6 col-lg-6"></div>
	 		<div class="col-md-2 col-xs-2 col-lg-2">
	 			<?php
	 				echo Html::textInput('name', Yii::$app->request->get('name'), ['class'=> 'form-control',
	 					'placeholder' => 'name, sku']); 
	 			?>
	 		</div>
		 	<div class="col-md-2 col-xs-2 col-lg-2">
				 <?php
				  echo	Html::dropDownList('warehouse', Yii::$app->request->get('warehouse'), $listWarehouse, setOption('Select Warehouse'));
				 ?>
		 	</div>
		 	
		 	<div class="col-md-2 col-xs-2 col-lg-2">
				 <?php echo Html::submitButton('Search', ['class' => 'btn btn-success']) ?>
		 	</div>
	 	</div>
	 	<div class="row form-group">
	<?
	echo Html::endForm();
	echo GridView::widget([
		'dataProvider' => $model,
		'columns'=> $genColumn,
		'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
	]);
?>
