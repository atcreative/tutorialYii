<?php
 	use yii\grid\GridView;
 	use yii\helpers\Html;
 	use yii\helpers\Url;
 	use kartik\date\DatePicker;
 	$this->title = Yii::t('app', 'Sunk Stock');
 	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Summary'), 'url' => Url::to(['summary/index'])];
 	$this->params['breadcrumbs'][] = $this->title;
 	echo Html::beginForm(Url::to(['sunk-stock']), 'get');
 ?>
 	<div class="col-lg-3"></div>
 	<div class="col-lg-1">from:</div>
 	<div class="col-lg-2">
 		<?php echo DatePicker::widget([
		    'name' => 'formDate',
		    'type' => DatePicker::TYPE_INPUT,
		    'value' => date('d-M-Y'),
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
		    'value' => date('d-M-Y') ,
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
