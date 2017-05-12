<?php
 	use yii\grid\GridView;
 	use yii\helpers\Html;
 	use yii\helpers\Url;
 	$this->title = Yii::t('app', 'Product Sales By Months');
 	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Summary'), 'url' => Url::to(['summary/index'])];
 	$this->params['breadcrumbs'][] = $this->title;

 	$monthMap = [
 		'JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG'
 		, 'SEP', 'OCT', 'NOV', 'DEC'
 	];

 	function setOption($title){
 		return [
	 		'class' => 'form-control',
	 		'prompt' => $title
 		];
 	}
 	echo Html::beginForm( Url::to(['sell/product-month']), 'get');
 ?>
	<div class="col-lg-12">
		<div class="col-lg-2"></div>
 		<div class="col-lg-3">
 			<?php echo Html::TextInput('nameProduct',Yii::$app->request->get('nameProduct'),['class' => 'form-control', 'placeholder' => 'name']) ?>
		</div>
		<div class="col-lg-3">
			<?php echo Html::dropDownList('category', Yii::$app->request->get('category'), $listCategory, setOption('Select Category'))
			?>
		</div>
		<div class="col-lg-2">
			<?php echo Html::dropDownList('year', Yii::$app->request->get('year'), $listYear, setOption('Select Year'))
			?>
		</div>
		<div class="col-lg-2">
			<?php echo Html::submitButton('Search', ['class' => 'btn btn-success']) ?>
		</div>
 	</div>
 <?php 	echo Html::endForm()?>
  	<h3>product</h3>
 <?php
 	function genArrayIndex($model, $label, $attribute){
		return [
			'label' => Yii::t('app', $label),
			'format' => 'raw',
			'attribute' => $attribute,
			'value' => $attribute,
		          
		];
	}
	$genColumn[] = genArrayIndex($model, 'Sku', 'sku');
	$genColumn[] = genArrayIndex($model, 'Name', 'name');
	foreach($monthMap as $key => $value){
		$genColumn[] = genArrayIndex($model, $value, $value);
	}

	$genColumn[] = [
		'label' => Yii::t('app', "Average"),
		'format' => 'raw',
		'value' => function($model)use ($month){
			return round($model['total'] / $month);
		}
	];
 	echo GridView::widget([
		'dataProvider' => $model,
		'columns' => $genColumn
	]);

?>