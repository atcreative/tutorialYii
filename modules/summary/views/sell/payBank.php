<?php
 	use yii\grid\GridView;
 	use yii\helpers\Html;
 	use yii\helpers\Url;
 	
 	$this->title = Yii::t('app', 'Top Bank');
 	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Summary'), 'url' => Url::to(['summary/index'])];
 	$this->params['breadcrumbs'][] = $this->title;
?>
<?php foreach($model as $key => $value):?>
	<table class="table table-bordered">
		<tr>
			<th class="col-lg-9"><?php echo $value['bank_name_th']?></th>
			<th>total</th>
		</tr>
		<?php foreach($value['list'] as $index => $item):?>
		<tr>
			<td><?php echo $item['nickname'] ?></td>
			<td><?php echo number_format($item['total']) ?></td>
		</tr>
		<?php endforeach ?>
	</table>
<?php endforeach ?>