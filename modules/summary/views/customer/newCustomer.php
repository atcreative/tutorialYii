<?php
	use yii\grid\GridView;
 	use yii\helpers\Html;
 	use yii\helpers\Url;
 	use kartik\date\DatePicker;
 	$this->title = Yii::t('app', 'New Customer');
 	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Summary'), 'url' => Url::to(['summary/index'])];
 	$this->params['breadcrumbs'][] = $this->title;
 	echo Html::beginForm(Url::to(['new-customer']), 'get');

 	$fromDate = '';
 	$toDate = '';
 	if(Yii::$app->request->get('fromDate')) $fromDate = Yii::$app->request->get('fromDate');
 	if(Yii::$app->request->get('toDate'))$toDate = Yii::$app->request->get('toDate');
 	function genArrayIndex($model, $label, $attribute){
		return [
					'label' => Yii::t('app', $label),
					'format' => 'raw',
					'attribute' => $attribute,
					'value' => $attribute,
		          
		];
	}
 ?>
 	<div class="col-lg-4"></div>
 	<div class="col-lg-1">from:</div>
 	<div class="col-lg-2">
 		<?php echo DatePicker::widget([
		    'name' => 'fromDate',
		    'type' => DatePicker::TYPE_INPUT,
		    'value' => $fromDate,
		    'pluginOptions' => [
		        'autoclose'=>true,
		        'format' => 'dd-M-yyyy'
		    ]
			]);
 		?>
 	</div>

 	<div class="col-lg-1">to:</div>
 	<div class="col-lg-2">
 		<?php echo DatePicker::widget([
		    'name' => 'toDate',
		    'type' => DatePicker::TYPE_INPUT,
		    'value' => $toDate ,
		    'pluginOptions' => [
		        'autoclose'=>true,
		        'format' => 'dd-M-yyyy'
		    ]
			]);
 		?>
 	</div>
 	<div class="col-md-2 col-xs-2 col-lg-2">
		 <?php echo Html::submitButton('Search', ['class' => 'btn btn-success']) ?>
 	</div>
<?php
	echo Html::endForm();
	if(strlen($fromDate) > 0 && strlen($toDate) > 0){
		$genColumns[] = genArrayIndex($model, 'Name', 'name');
		$genColumns[] = genArrayIndex($model, 'Surname', 'surname');
		$genColumns[] = genArrayIndex($model, 'Count order', 'countOrder');
		$genColumns[] = genArrayIndex($model, 'Total', 'total');
		echo GridView::widget([
			'dataProvider' => $model,
			'columns' => $genColumns,
			'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
		]);
	}
?>