<?php
	use yii\helpers\Html;
 	use yii\helpers\Url;
	$this->title = Yii::t('app', 'Summary Channel Sync');
 	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Admin'), 'url' => Url::to(['admin-summary/index'])];
 	$this->params['breadcrumbs'][] = $this->title;

 	$month = [
 		'', 'JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG'
 		, 'SEP', 'OCT', 'NOV', 'DEC'
 	];

 	function setOption($title){
 		return [
	 		'class' => 'form-control',
	 		'prompt' => $title
 		];
 	}
 	echo Html::beginForm( Url::to(['admin-summary/summary-shipment']), 'get');
?>
	<div class="row">
		<div class="form-group col-lg-12">
			<div class="col-lg-7"></div>
			<div class="col-lg-3">
				<?php echo Html::dropDownList('year', Yii::$app->request->get('year'), $groupYear, setOption('Select Year'))
				?>
			</div>
			<div class="col-lg-2">
				<?php echo Html::submitButton('Search', ['class' => 'btn btn-success']) ?>
			</div>
		</div>
	</div>
<?php echo Html::endForm()?>
		<div class="from-group row">
			
			<div class="col-lg-4">
				<?php if(Yii::$app->request->get('year')):?>
					<h4><?php echo Yii::t('app', 'Year') ?>  <?php echo Yii::$app->request->get('year') ?></h4>
				<?php endif?>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-lg-12">
				<table class="table table-bordered">
					<thead>
						<tr>
							<?php for($i = 0 ; $i <= 12 ; $i ++):?>
								<th><?php echo Yii::t('app', $month[$i]) ?></th>
							<?php endfor?>
							<th><?php echo Yii::t('app', 'Total') ?></th>
						</tr>
						<?php foreach($shipper as $key => $value):?>
							<tr>
								<th><?php echo $value['name'] ?></th>
								<?php foreach($value['month'] as $index => $item):?>
									<td><?php echo $item ?></td>
								<?php endforeach ?>
								<th>
									<?php echo $value['totalAmount'] ?>
								</th>
							</tr>
						<?php endforeach?>
					</thead>
				</table>
			</div>
		</div>
