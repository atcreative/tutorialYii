<?php

namespace app\modules\summary\controllers;
use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;


class SummaryInventoryController extends Controller
{
	private $connection;
    private $tenant;
	

#  position manage Summary Low Stock Start


	private function selectProductLowStock(){
		$data = $this->connection->createCommand('select id, sku, name, minimum_quantity, quantity  from product where minimum_quantity is not null and quantity <= minimum_quantity and product_type_id = 2 and  tenant_id = '. $this->tenant)->queryAll();
		foreach($data as $key => $value){	
			$sqlBalance = 'select * from stock_balance where  product_id = '. $value['id'];
			$sqlBalance = $this->connection->createCommand($sqlBalance)->queryOne();
			if(!empty($sqlBalance['warehouse_id'])){
				$sqlBalance['warehouse_id'] = $this->connection->createCommand('select id,name from warehouse where id = '. $sqlBalance['warehouse_id'])->queryOne();
				$data[$key]['balance'] = $sqlBalance;
			}
		}
		return $data;
	}


// call Method
	public function genArrayDataProviderLowStock($tenant){
		$this->tenant = $tenant;
		$this->connection = Yii::$app->db;
		$list = $this->selectProductLowStock();
        $provider = new ArrayDataProvider([
			'allModels' => $list,
			'sort' => [
				'attributes' => ['name', 'sku'],
			],
		]);

		return $provider;
	}


#	positon manage Summary Low Stock End 


#	position manage inventory status Start
	

	private function callWarehouse(){
		$data = $this->connection->createCommand('select id, name from warehouse where status = 1 and tenant_id = '. $this->tenant)->queryAll();
		return $data;
	}

	private function selectProductStatus(){
		$warehouse = $this->callWarehouse();
		$data = $this->connection->createCommand('select id, sku, name, price, cost, quantity from product where  product_type_id = 2 and status = 1 and tenant_id = '. $this->tenant)->queryAll();
		foreach($data as $key => $value){
			foreach($warehouse as $index => $item){
				$totalWarehouse = $this->connection->createCommand('select sum(quantity) as total from stock_balance where warehouse_id = '. $item['id']. ' and product_id = '.$value['id'])->queryOne();
				$data[$key][$item['name']] = $totalWarehouse['total'];	
			}
			$totalProduct = $this->connection->createCommand('select sum(onhand) as onhand, sum(reserved) as reserved from stock_balance where product_id = '. $value['id'])->queryOne();
			$data[$key]['onhand'] = $totalProduct['onhand'];
			$data[$key]['reserved'] = $totalProduct['reserved'];
		}
		return $data;
	}
// call Method	
	public function genInventoryStatus($tenant){
		$this->tenant = $tenant;
		$this->connection = Yii::$app->db;
		$list = $this->selectProductStatus();
		 $provider = new ArrayDataProvider([
			'allModels' => $list,
			'sort' => [
				'attributes' => ['name', 'sku'],
			],
		]);
		return $provider;
		
	}
#	position manage inventory status End

	

    public function actionIndex()
    {
		return $this->render('inventorystatus', ['model' => $this->genInventoryStatus(26)]);
    }
}
