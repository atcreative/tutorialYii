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
 	echo Html::beginForm( Url::to(['sell/best-seller']), 'get');
 ?>
 	<div class="col-lg-12">
		<div class="col-lg-4"></div>
 		<div class="col-lg-3">
 			<?php echo Html::TextInput('nameProduct',Yii::$app->request->get('nameProduct'),['class' => 'form-control', 'placeholder' => 'name']) ?>
		</div>
		<div class="col-lg-3">
			<?php echo Html::dropDownList('category', Yii::$app->request->get('category'), $listCategory, setOption('Select Category'))
			?>
		</div>
		<div class="col-lg-2">
			<?php echo Html::submitButton('Search', ['class' => 'btn btn-success']) ?>
		</div>
 	</div>
 <?php 	echo Html::endForm()?>
 	<h3>Best product sell</h3>
 <?php
 	function genArrayIndex($model, $label, $attribute){
		return [
			'label' => Yii::t('app', $label),
			'format' => 'raw',
			'attribute' => $attribute,
			'value' => $attribute,
		          
		];
	}
	$genColumn[] = genArrayIndex($model, 'Name', 'name');
	$genColumn[] = genArrayIndex($model, 'Price', 'price');
	$genColumn[] = genArrayIndex($model, 'Cost', 'cost');
	$genColumn[] = genArrayIndex($model, 'Qty', 'qty');
	$genColumn[] = genArrayIndex($model, 'QtyPrecent', 'QtyPrecent');

	$genColumn[] = genArrayIndex($model, 'Profit', 'profit');
 	$genColumn[] = genArrayIndex($model, 'PricePercent', 'PricePercent');
 	echo GridView::widget([
		'dataProvider' => $model,
		'columns' => $genColumn
	]);

?>