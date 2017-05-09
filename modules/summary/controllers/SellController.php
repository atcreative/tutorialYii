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
			return $this->render('bestSeller', ['model' => $provider, 'listCategory' => $listCategory]);
		}

//		end Product Profit
//		start product month
		private function lastOrderInMonth($year){
			$sql = 'SELECT MAX(MONTH(FROM_UNIXTIME(dt_created))) as month FROM `order` where tenant_id = '. $this->tenant.' and YEAR(FROM_UNIXTIME(dt_created)) = '. $year;
			$data = $this->connection->createCommand($sql)->queryOne();
			return $data['month'];
		}

		private function selectProduct($month, $year){
			$sql = 'SELECT id, name, sku FROM product WHERE status = 0 AND tenant_id = '. $this->tenant;
			$data = $this->connection->createCommand($sql)->queryAll();
			foreach($data as $key => $value){
				for($i = 1 ; $i <= $month; $i++){
					$sql = 'SELECT SUM(order_detail.id) AS quantity FROM order_detail INNER JOIN `order` ON `order`.id = order_detail.order_id where `order`.status = 1 and MONTH(FROM_UNIXTIME(`order`.dt_created)) =  '. $i .' and YEAR(FROM_UNIXTIME(`order`.dt_created)) =  '. $year .' and product_id = '. $value['id'];
					$qty = $this->connection->createCommand($sql)->queryOne();
					$data[$key][$i] = $qty['quantity'];
				}
			}
			print_r($data);
		}

		private function productByMonth($tenant){
			$this->tenant = $tenant;
			$this->connection = Yii::$app->db;
			$year = date('Y');
			$month = $this->lastOrderInMonth($year);
			$this->selectProduct($month, $year);
		} 
//		end product month
		public function actionBestSeller(){
			return $this->bestSellProduct(17);
		}

		public function actionProductMonth(){
			return $this->productByMonth(26);
		}
	}
?>