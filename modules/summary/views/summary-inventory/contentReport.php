<?php
 	use yii\grid\GridView;
 	use yii\helpers\Html;

 	$arrReport = [
 		'Inventory' => [
 			[
	 			'name' => 'Inventory status',
	 			'detail' => 'description',
	 			'link' => '',
	 		],	
	 		[
	 			'name' => 'Low Stock',
	 			'detail' => 'Low Stock Detail',
	 			'link' => '',
 			]
 		],
 		'Seller' =>[
 			[
	 			'name' => 'Product seller',
	 			'detail' => 'product seller',
	 			'link' => '',
 			],
 			[
	 			'name' => 'Product profit',
	 			'detail' => 'product profit',
	 			'link' => '',
 			],
 			[
	 			'name' => 'Sale summery',
	 			'detail' => 'Sale summery',
	 			'link' => '',
 			],
 			[
	 			'name' => 'Order status',
	 			'detail' => 'Order status',
	 			'link' => '',
 			],
 			[
	 			'name' => 'Product top sale',
	 			'detail' => 'Order status',
	 			'link' => '',
 			],
 		],
 		'Customer' =>[
 			[
	 			'name' => 'Top Customer',
	 			'detail' => 'Top customer',
	 			'link' => '',
 			],
 			[
	 			'name' => 'New customer',
	 			'detail' => 'New customer',
	 			'link' => '',
 			],
 		],
 		'Payment' =>[
 			[
	 			'name' => 'Top bank',
	 			'detail' => 'Top bank',
	 			'link' => '',
 			],
 			
 		]
 	];
 ?>
<div class="col-lg-12">
<?php foreach ($arrReport as $key => $value):?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<?php echo Yii::t('app', $key) ?>
		</div>
		<div class="panel body">
			<table class="table table-bordered">
				<tr>
					<th class="col-lg-3">Report Name</th>
					<th>Report Description</th>
				</tr>
				<?php foreach($value as $index => $item):?>
				<tr>
					<td><?php echo $item['name']?></td>
					<td><?php echo $item['detail']?></td>
				</tr>
				<?php endforeach?>
			</table>
		</div>
	</div>
<?php endforeach?>
</div>

