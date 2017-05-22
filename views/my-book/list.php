<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use app\assets\TimepickerAsset;

TimepickerAsset::register($this);


#call javascript
#static::POS_END = down
#static::POS_POS_READY = ready
#ref. yii\web\view
$text = "Kerkkhai";

$js = <<< JS
	$('#my-time').timepicker();
JS;



$this->registerJS($js, VIEW::POS_END);
echo Html::textInput('my_time', '', ['class' => 'form-control', 'id' => 'my-time', 'placeholder' => 'myTime']);
echo GridView::widget([
	'dataProveder' => $dataProvider,
	'columns' =>[
		[
			'label' => 'Category', 
			'attribute' => 'category_id',
			'format' => 'raw',
			'value' =>  function($model){
				if(!empty($model->category_id)){
					return  $model->category->name;
				}
			}
		],
		'category.name',
		'name',
		[
			'label' => 'Price',
			'attribute' => 'price', 
			'format' => 'raw',
			'value' => function($model){
				return number_format($model->price, 2);
			}
		],
		[
			'class' => 'yii\grid\actionColumn',
			'template' => '{edit} {delete}',
			'buttons' => [
				'edit' => function($url, $model, $key){
					return Html::a(
						'<i class="glyphicon glyphicon-pencil"></i>', Url::to(['/my-book/form', 'id' => $model->id], true)
					);
				}
			],
		]
		
	]
]);
?>
