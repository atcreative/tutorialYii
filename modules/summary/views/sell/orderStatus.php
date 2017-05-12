<?php
 	use yii\grid\GridView;
 	use yii\helpers\Html;
 	use yii\helpers\Url;
 	
 	$this->title = Yii::t('app', 'Orders Status');
 	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Summary'), 'url' => Url::to(['summary/index'])];
 	$this->params['breadcrumbs'][] = $this->title;


 	
?>
<table class="table table-bordered">
	<thead>
		<th></th>
		<?php foreach($model as $key => $value):?>
			<th align="center"><?php echo $value['name'] ?></th>
		<?php endforeach ?>
	</thead>
	<tbody>
		<tr>
			<th>จำนวนรายการ</th>
			<?php foreach($model as $key => $value):?>
				<td><?php echo $value['total'] ?></td>
			<?php endforeach?>
		</tr>
		<tr>
			<th>จำนวนรายการสั่งซื้อ</th>
			<?php foreach($model as $key => $value):?>
				<td><?php echo $value['quantity']?></td>
			<?php endforeach?>
		</tr>
		<tr>
			<th>ราคาขายรวม</th>
			<?php foreach($model as $key => $value):?>
				<td><?php echo number_format($value['price']) ?></td>
			<?php endforeach?>
		</tr>
	</tbody>
</table>