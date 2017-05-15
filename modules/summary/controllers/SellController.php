<?php
	namespace app\modules\summary\controllers;
	use Yii;
	use yii\web\Controller;
	use yii\data\ArrayDataProvider;
	use yii\helpers\ArrayHelper;

	class SellController extends Controller{
		private $connection;
    	private $tenant;
    	private function getMapCategory(){
    		$data = $this->connection->createCommand('select * from category where tenant_id = '. $this->tenant. ' and status = 1')->queryAll();
    		return ArrayHelper::map($data, 'id', 'name');
    	}

//		start Product Profit
    	private function selectBestProductSell(){
    		$where = '';
    		if((Yii::$app->request->get('nameProduct'))){
    			$where  .= "and product.name like '%". Yii::$app->request->get('nameProduct'). "%' ";
    		}
    		if((Yii::$app->request->get('category'))){
    			$where .= 'and product.category_id = '. Yii::$app->request->get('category');
    		}
    		$sqlSelectTop = 'select product.name as name, round(product.price) as price, round(product.cost) as cost, sum(order_detail.quantity) as qty from product INNER JOIN order_detail ON order_detail.product_id = product.id INNER JOIN `order` ON order_detail.order_id = `order`.id where product.tenant_id = '. $this->tenant.' '. $where.' and order.status = 1 and product.product_type_id = 2 and product.status = 1 group by order_detail.product_id order by qty DESC';
    		$data = $this->connection->createCommand($sqlSelectTop)->queryAll();
    		return $data;
    	}

		private function bestSellProduct($tenant){
			$this->tenant = $tenant;
			$this->connection = Yii::$app->db;
			$totalPrice = 0;
			$totalQty = 0;
			$list = $this->selectBestProductSell();
			$listCategory = $this->getMapCategory();
			foreach($list as $key => $value){
				$profit = ($value['price'] - $value['cost']) * $value['qty'];
				$list[$key]['profit'] = $profit;
				$totalPrice += $profit;
				$totalQty += $value['qty'];
			}
			foreach($list as $key => $value){
				$list[$key]['QtyPrecent'] = number_format(($value['qty'] / $totalQty) * 100, 2, '.',''). '%';
				$list[$key]['PricePercent'] = number_format(($value['profit'] / $totalPrice) * 100, 2, '.', ''). '%';
			}
			$provider = new ArrayDataProvider([
				'allModels' => $list,
			]);
			return $this->render('productProfit', ['model' => $provider, 'listCategory' => $listCategory]);
		}

//		end Product Profit
//		start product month
		private function lastOrderInMonth($year){
			$sql = 'SELECT MAX(MONTH(FROM_UNIXTIME(dt_created))) as month FROM `order` where tenant_id = '. $this->tenant.' and YEAR(FROM_UNIXTIME(dt_created)) = '. $year;
			$data = $this->connection->createCommand($sql)->queryOne();
			return $data['month'];
		}

		private function listYearInOrder(){
			$sql = 'SELECT YEAR(FROM_UNIXTIME(dt_created)) as year FROM `order` where tenant_id = '. $this->tenant.' group by YEAR(FROM_UNIXTIME(dt_created))';
			$data = $this->connection->createCommand($sql)->queryAll();
			$data = ArrayHelper::map($data, 'year', 'year');
			return $data;
		}

		private function selectProduct($month, $year){
			$month = [
		 		'', 'JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG'
		 		, 'SEP', 'OCT', 'NOV', 'DEC'
		 	];

		 	$whereProduct = '';
    		if((Yii::$app->request->get('nameProduct'))){
    			$whereProduct  .= " and name like '%". Yii::$app->request->get('nameProduct'). "%' ";
    		}
    		if((Yii::$app->request->get('category'))){
    			$whereProduct .= ' and category_id = '. Yii::$app->request->get('category');
    		}


			$sql = 'SELECT id, name, sku FROM product WHERE status = 1  ' . $whereProduct .' AND tenant_id = '. $this->tenant . ' ORDER BY sku ';
			$data = $this->connection->createCommand($sql)->queryAll();
			foreach($data as $key => $value){
				$max = 0;
				for($i = 1 ; $i <= 12; $i++){
					
					$sql = 'SELECT SUM(order_detail.quantity) AS quantity FROM order_detail INNER JOIN `order` ON `order`.id = order_detail.order_id where `order`.status = 1 and MONTH(FROM_UNIXTIME(`order`.dt_created)) =  '. $i .' and YEAR(FROM_UNIXTIME(`order`.dt_created)) =  '. $year .' and product_id = '. $value['id'];
					$qty = $this->connection->createCommand($sql)->queryOne();
					if($qty['quantity'] < 1) $data[$key][$month[$i]] = 0;
					else {
						$max += $qty['quantity'];
						$data[$key][$month[$i]] = $qty['quantity'];
					}
				}
				$data[$key]['total'] = $max;
			}
			return $data;
		}

		private function productByMonth($tenant){
			$this->tenant = $tenant;
			$this->connection = Yii::$app->db;
			if((Yii::$app->request->get('year')))  $year = Yii::$app->request->get('year');
    		else $year = date('Y');
			$month = $this->lastOrderInMonth($year);
			$list = $this->selectProduct($month, $year);
			$listCategory = $this->getMapCategory();
			$listYear = $this->listYearInOrder();
			$provider = new ArrayDataProvider([
				'allModels' => $list,
			]);
			return $this->render('orderProductByMonth',[
				'model' => $provider,
				'month' => $month,
				'year' => $year,
				'listCategory' => $listCategory,
				'listYear' => $listYear,
			]);
		} 
//		end product month

//		start order status
		public function selectOrderStatus($tenant){
			$this->tenant = $tenant;
			$this->connection = Yii::$app->db;
			$orderStatus = $this->connection->createCommand('select id, name from order_status')->queryAll();
			unset($orderStatus[1]);
			unset($orderStatus[count($orderStatus)]);
			foreach($orderStatus as  $key => $value){
				$sumOrder = $this->connection->createCommand('select count(id)  as total from `order` where status = 1 and tenant_id = '. $this->tenant.' and order_status_id = '. $value['id'])->queryOne();
				$sumQuantity = $this->connection->createCommand('select count(*) as total from order_detail inner join `order` on `order`.id = order_detail.order_id where `order`.status = 1 and `order`.tenant_id = '. $this->tenant.' and order_status_id = '. $value['id'])->queryOne();
				$sumPrice = $this->connection->createCommand('select sum(total) as total from `order` where status = 1 and tenant_id = '. $this->tenant. ' and order_status_id = '. $value['id'])->queryOne();
				$orderStatus[$key]['total'] = $sumOrder['total'];
				$orderStatus[$key]['quantity'] = $sumQuantity['total'];
				if($sumPrice['total'] < 1) $orderStatus[$key]['price'] = 0;
				else $orderStatus[$key]['price'] = $sumPrice['total'];
			}
		
			return $this->render('orderStatus',['model' => $orderStatus]);
		}
//		end order status
//		start Top Bank
		public function payBank($tenant){
			$this->tenant = $tenant;
			$this->connection = Yii::$app->db;
			$bank = $this->connection->createCommand('select id, bank_name_en, bank_name_th from bank_account')->queryAll();
			foreach($bank as $key => $value){
				$listBank = $this->connection->createCommand('select * from tenant_bank_account where tenant_id = '. $this->tenant. ' and status = 1 and bank_account_id = '. $value['id'])->queryAll();
				if(count($listBank) > 0) {
					foreach($listBank as $index => $item){
						$totalPayMent = $this->connection->createCommand('SELECT sum(amount) AS total FROM payment WHERE tenant_bank_account_id = '. $item['id'])->queryOne();
						$listBank[$index]['total'] = $totalPayMent['total'];
					}
					$bank[$key]['list'] = $listBank;
				}else unset($bank[$key]);
			}
			// $provider = new ArrayDataProvider([
			// 	'allModels' => $bank,
			// ]);
			return $this->render('payBank', ['model' => $bank]);
		}
//		end Top Bank

		public function actionOrderStatus(){
			return $this->selectOrderStatus(17);
		}

		public function actionProductProfit(){
			return $this->bestSellProduct(17);
		}

		public function actionProductMonth(){
			return $this->productByMonth(17);
		}

		public function actionPayBank(){
			return $this->payBank(17);
		}
	}
?>