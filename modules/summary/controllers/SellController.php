<?php
	namespace app\modules\summary\controllers;
	use Yii;
	use yii\web\Controller;
	use yii\data\ArrayDataProvider;
	use yii\helpers\ArrayHelper;


	class SellController extends Controller{
		private $connection;
    	private $tenant;

    	private function selectBestProductSell(){
    		$sqlSelectTop = 'select product.name as name, sum(order_detail.quantity) as total from product INNER JOIN order_detail ON order_detail.product_id = product.id INNER JOIN `order` ON order_detail.order_id = `order`.id where product.tenant_id = '. $this->tenant.' and product.status = 1 group by order_detail.product_id order by total DESC';
    		$data = $this->connection->createCommand($sqlSelectTop)->queryAll();
    		return $data;
    	}

		private function bestSellProduct($tenant){
			$this->tenant = $tenant;
			$this->connection = Yii::$app->db;
			$data = $this->selectBestProductSell();
		}

		public function actionBestSeller(){
			$list = $this->bestSellProduct(26);

			$provider = new ArrayDataProvider([
			'allModels' => $list,
			]);
			return $this->render('bestSeller', ['model' => $provider]);
			}
	}
?>