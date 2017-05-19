<?php
 	use yii\grid\GridView;
 	use yii\helpers\Html;
 	use yii\helpers\Url;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Summary'), 'url' => Url::to(['index'])];
 	$arrReport = [
 		'Inventory' => [
 			[
	 			'name' => 'Inventory status',
	 			'detail' => 'description',
	 			'link' => 'summary-inventory/inventory-status',
	 		],	
	 		[
	 			'name' => 'Low Stock',
	 			'detail' => 'Low Stock Detail',
	 			'link' => 'summary-inventory/low-stock',
 			],
 			[
 				'name' => 'Suck Product', 
 				'detail' => 'Suck Product',
 				'link' => 'summary-inventory/sunk-stock'
 			]
 		],
 		'Sell' =>[

 			[
 				'name' => 'Top Order',
 				'detail' => 'Top Order',
 				'link' => 'sell/top-order',
 			],
 			[
	 			'name' => 'Product profit',
	 			'detail' => 'product sell',
	 			'link' => 'sell/product-profit',
 			],
 			[
	 			'name' => 'Product sale by month',
	 			'detail' => 'Product sale by month',
	 			'link' => 'sell/product-month',
 			],
 			[
	 			'name' => 'Order status',
	 			'detail' => 'Order status',
	 			'link' => 'sell/order-status',
 			],
 			
 		],
 		'Customer' =>[
 			[
	 			'name' => 'Top Customer',
	 			'detail' => 'Top customer',
	 			'link' => 'customer/top-customer',
 			],
 			[
	 			'name' => 'New customer',
	 			'detail' => 'New customer',
	 			'link' => 'customer/new-customer',
 			],
 		],
 		'Payment' =>[
 			[
	 			'name' => 'Top bank',
	 			'detail' => 'Top bank',
	 			'link' => 'sell/pay-bank',
 			],
 			
 		],
 		// 'Shipment' => [
 		// 	[
 		// 		'name' => 'Summary Shipment',
 		// 		'detail' => 'Summary Shipment',
 		// 		'link' => 'sell/shipment'
 		// 	],
 		// ]
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
					<td><a href="<?php echo Url::to([$item['link']]) ?>"><?php echo $item['name']?></a></td>
					<td><?php echo $item['detail']?></td>
				</tr>
				<?php endforeach?>
			</table>
		</div>
	</div>
<?php endforeach?>
</div>

