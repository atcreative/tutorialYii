<?php
	use yii\grid\GridView;
 	use yii\helpers\Html;
 	use yii\helpers\Url;
 	use kartik\date\DatePicker;
 	$this->title = Yii::t('app', 'New Customer');
 	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Summary'), 'url' => Url::to(['summary/index'])];
 	$this->params['breadcrumbs'][] = $this->title;
 	echo Html::beginForm(Url::to(['new-customer']), 'get');

 	$fromDate = date('d-M-Y');
 	$toDate = date('d-M-Y');
 	if(Yii::$app->request->get('fromDate')) $fromDate = Yii::$app->request->get('fromDate');
 	if(Yii::$app->request->get('toDate'))$toDate = Yii::$app->request->get('toDate');

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
?>