<?php

namespace app\modules\summary\controllers;
use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;


class SummaryInventoryController extends Controller
{
	private $connection;
    private $tenant;

    private function getWarehouseInTenant($where = null){
		$data = $this->connection->createCommand('select id, name from warehouse where status = 1 and tenant_id = '. $this->tenant . ' '. $where)->queryAll();
		return $data;
	}

	public function getCategoryProductIntenant($where = null){
		$data = $this->connection->createCommand('select id, name from category where status = 1 and tenant_id = '. $this->tenant. ' '. $where)->queryAll();
		return $data;
	}
	
#  position manage  Low Stock Start
	private function selectProductLowStock(){
		$whereCategory = '';
		$whereWarehouse = '';
		if(!empty(Yii::$app->request->get('warehouse'))) $whereWarehouse = 'and warehouse_id = '.Yii::$app->request->get('warehouse');
		if(!empty(Yii::$app->request->get('category'))) $whereCategory = 'and category_id = '.Yii::$app->request->get('category');
		$data = $this->connection->createCommand('select id, sku, name, minimum_quantity, round(quantity) as quantity  from product where minimum_quantity is not null '. $whereCategory.' and quantity <= minimum_quantity and product_type_id = 2 and  tenant_id = '. $this->tenant)->queryAll();
		foreach($data as $key => $value){	
			$sqlBalance = 'select warehouse_id, round(quantity) as quantity from stock_balance where  product_id = '. $value['id'] .' '. $whereWarehouse;
			$sqlBalance = $this->connection->createCommand($sqlBalance)->queryOne();
			if(!empty($sqlBalance['warehouse_id'])){
				$sqlBalance['warehouse_id'] = $this->connection->createCommand('select id,name from warehouse where id = '. $sqlBalance['warehouse_id'])->queryOne();
				$data[$key]['balance'] = $sqlBalance;
			}else{
				unset($data[$key]);
			}
		}
		return $data;
	}


// call Method
	public function genLowStock($tenant){
		$this->tenant = $tenant;
		$this->connection = Yii::$app->db;
		$warehouse = $this->getWarehouseInTenant();
		$warehouseList = ArrayHelper::map($warehouse, 'id', 'name');
		$category = $this->getCategoryProductIntenant();
		$categoryList = ArrayHelper::map($category, 'id', 'name');
		$list = $this->selectProductLowStock();
        $provider = new ArrayDataProvider([
			'allModels' => $list,
			'sort' => [
				'attributes' => ['name', 'sku'],
			],
		]);
		return $this->render('lowstock', ['model' => $provider, 'warehouseList' => $warehouseList, 'categoryList' => $categoryList]);
	}


#	positon manage Low Stock End 


#	position manage inventory status Start

	private function selectCountProduct(){
		$data = $this->connection->createCommand('select count(*) as productAmount from product where product_type_id = 2 and status = 1 and tenant_id = '. $this->tenant)->queryOne();
		return $data['productAmount'];
	}

	private function selectProductStatus(){
		$perPage = 20;
		$page = 1;
		$whereCategory = '';
		$whereWarehouse = '';
		if(!empty(Yii::$app->request->get('page'))) $page = Yii::$app->request->get('page');
		$page--;
		if(!empty(Yii::$app->request->get('warehouse'))) $whereWarehouse = 'and warehouse_id = '.Yii::$app->request->get('warehouse');
		if(!empty(Yii::$app->request->get('category'))) $whereCategory = 'and category_id = '.Yii::$app->request->get('category');
		$warehouse = $this->getWarehouseInTenant();
		echo 'select id, sku, name, price, cost, minimum_quantity, quantity from product where  product_type_id = 2 and status = 1 and tenant_id = '. $this->tenant. ' limit '.($page * $perPage). ', '. (($page * $perPage) + $perPage);
		$data = $this->connection->createCommand('select id, sku, name, price, cost, minimum_quantity, quantity from product where  product_type_id = 2 and status = 1 and tenant_id = '. $this->tenant. ' limit '.($page * $perPage). ', '. (($page * $perPage) + $perPage))->queryAll();
		foreach($data as $key => $value){
			foreach($warehouse as $index => $item){
				$totalWarehouse = $this->connection->createCommand('select sum(quantity) as total from stock_balance where warehouse_id = '. $item['id']. ' and product_id = '.$value['id'])->queryOne();
				$data[$key][$item['name']] = $totalWarehouse['total'];	
			}
			$totalProduct = $this->connection->createCommand('select sum(onhand) as onhand, sum(reserved) as reserved from stock_balance where product_id = '. $value['id'])->queryOne();
			if($value['minimum_quantity'] > $value['quantity']) $data[$key]['status'] = 0;
			else $data[$key]['status'] = 1;
			$data[$key]['onhand'] = $totalProduct['onhand'];
			$data[$key]['reserved'] = $totalProduct['reserved'];
		}
		return $data;
	}
// call Method	
	public function genInventoryStatus($tenant){
		$this->tenant = $tenant;
		$this->connection = Yii::$app->db;
		$perPage = Yii::$app->request->get('per-page');
		$list = $this->selectProductStatus();
		 $provider = new ArrayDataProvider([
			'allModels' => $list,
			'totalCount' => $this->selectCountProduct(),
			'pagination' => [
				'pageSize' => 20
			],
			'sort' => [
				'attributes' => ['name', 'sku'],
			],
		]);
		$listWarehouse = $this->getWarehouseInTenant();
		return $this->render('inventorystatus', ['model' => $provider , 'list' => $listWarehouse]);
	}
#	position manage inventory status End
	// sunk stock start
	public function selectSunkStock(){
		
	}
	// sunk stock end 
	public function actionLowStock(){
		return $this->genLowStock(17);
	}

	public function actionInventoryStatus(){
		return $this->genInventoryStatus(17);
	}
    public function actionIndex(){
		return $this->render('contentReport');
    }

    public function actionSunkStock(){
    	return $this->render('sunkStock');
    }
}
