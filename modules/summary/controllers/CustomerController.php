<?php
	namespace app\modules\summary\controllers;
	use Yii;
	use yii\web\Controller;
	use yii\data\ArrayDataProvider;
	use yii\helpers\ArrayHelper;
	use yii\data\sort;
	class CustomerController extends Controller{
		private $connection;
		private $tenant;
		//top customer start
		private function selectTopCustomer($tenant){
			$this->tenant = $tenant;
			$this->connection = Yii::$app->db;
			$whereOrder = '';
			$fromDate = null;
			$toDate = null;
			if(Yii::$app->request->get('fromDate')){
				$fromDate = date('Y-m-d', strtotime(Yii::$app->request->get('fromDate')));

			}
			if(Yii::$app->request->get('toDate')){
				$toDate = date('Y-m-d', strtotime(Yii::$app->request->get('toDate')));
			}
			if($fromDate && $toDate){
				$whereOrder = 'and dt_created BETWEEN ' . $fromDate. ' and '. $toDate . ' ';
			}
			$sql = 'SELECT id, name, surname, email FROM customer WHERE tenant_id = '. $this->tenant . ' and status = 1';
			$customer = $this->connection->createCommand($sql)->queryAll();
			foreach($customer as $key => $value){
				$total = $this->connection->createCommand('SELECT COUNT(*) as amount FROM `order` WHERE order_status_id > 3 '. $whereOrder.' and customer_id = '. $value['id'])->queryOne();
				$totalBuy = $this->connection->createCommand('SELECT SUM(total) as total FROM `order` WHERE   order_status_id > 3 '. $whereOrder .' and  customer_id =  '. $value['id'])->queryOne();
				$customer[$key]['total'] = $total['amount'];
				$customer[$key]['totalBuy'] = $totalBuy['total'];
			}

			$provider = new ArrayDataProvider([
				'allModels' => $customer,
				'pagination' => [
					'pageSize' => 20
				],
				'sort' => [
					'attributes' => ['total', 'totalBuy'],
					'defaultOrder'=>['total' => SORT_DESC
					],
				]
			]);
			return	$this->render('topCustomer', ['model' => $provider]);
		}
		//top customer end 
		//new customer start
		private function newCustomer($tenant){
			$this->tenant = $tenant;
			$this->connection = Yii::$app->db;
			$fromDate = null;
			$toDate = null;
			$whereCustomer = '';
			if(Yii::$app->request->get('fromDate')){
				$fromDate = date('Y-n-d', strtotime(Yii::$app->request->get('fromDate')));

			}
			if(Yii::$app->request->get('toDate')){
				$toDate = date('Y-n-d', strtotime(Yii::$app->request->get('toDate')));
			}
			if($fromDate && $toDate){

				$whereCustomer = " and created_at between '". $fromDate."' and '". $toDate."'";
				
				$sql = 'select id, name, surname from customer where tenant_id = '. $this->tenant .' and status = 1'. $whereCustomer;
				$customer = $this->connection->createCommand($sql)->queryAll();
				foreach($customer as $key => $value){
					$total = $this->connection->createCommand('select count(id) as count, sum(total) as total from `order` where order_status_id > 3 and   status = 1 and customer_id = '. $value['id'])->queryOne();
					$customer[$key]['countOrder'] = $total['count'];
					$customer[$key]['total'] = $total['total']; 
				}
				$provider = new ArrayDataProvider([
					'allModels' => $customer,
					'sort' => [
					'attributes' => ['total', 'countOrder']],
				]);
				return $this->render('newCustomer', ['model' => $provider]);
			}else return $this->render('newCustomer', ['model' => null]);
			
		}
		//new customer end
		public function actionTopCustomer(){
			return $this->selectTopCustomer(17);
		}
		public function actionNewCustomer(){
			return $this->newCustomer(17);
		}
	}
?>