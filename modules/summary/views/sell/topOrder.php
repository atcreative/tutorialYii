<?php
 	use yii\grid\GridView;
 	use yii\helpers\Html;
 	use yii\helpers\Url;
 	use kartik\date\DatePicker;

 	$fromDate = '';
 	$toDate = '';
 	if(Yii::$app->request->get('fromDate')) $fromDate = Yii::$app->request->get('fromDate');
 	if(Yii::$app->request->get('toDate'))$toDate = Yii::$app->request->get('toDate');
 	$this->title = Yii::t('app', 'Top Order');
 	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Summary'), 'url' => Url::to(['summary/index'])];
 	$this->params['breadcrumbs'][] = $this->title;
 	echo Html::beginForm( Url::to(['sell/top-order']), 'get');
 	?>
	<div class="row">
		<div class="col-lg-12">
			<div class="col-lg-1">total</div>
			<div class="col-lg-2">
				<?php echo Html::Textinput('minTotal', Yii::$app->request->get('minTotal'), ['class' => 'form-control', 'placeholder' => 'Min total']) ?>
			</div>
			<div class="col-lg-2">
				<?php echo Html::Textinput('maxTotal', Yii::$app->request->get('maxTotal'), ['class' => 'form-control', 'placeholder' => 'Max total']) ?>
			</div>
			<div class="col-lg-1">date</div>
			<div class="col-lg-2">
				<?php echo DatePicker::widget([
					    'name' => 'fromDate',
					    'type' => DatePicker::TYPE_INPUT,
					    'value' => $fromDate ,
					    'pluginOptions' => [
					        'autoclose'=>true,
					        'format' => 'dd-M-yyyy'
					    ]
						]);
			 		?>
			</div>
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
			<div class="col-lg-1">
				<?php echo Html::submitButton('Search', ['class' => 'btn btn-success']) ?>
			</div>
		</div>
	</div>
	<div class="row">
 	<?php
	 	echo Html::endForm();
	 	echo GridView::widget([
			'dataProvider' => $model,
		]);
 	?>
	</div>