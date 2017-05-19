<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

/**
 * Default controller for the `admin` module
 */
class AdminSummaryController extends Controller
{
	private $connection;

    /**
     * Renders the index view for the module
     * @return string
     */

    private  function groupDateInTable($table, $field){
    	$query = $this->connection->createCommand('select YEAR(FROM_UNIXTIME(('. $field.'))) as year from '. $table. ' group by year(FROM_UNIXTIME('. $field.')) ORDER BY '. $field .' DESC ')->queryAll();
    	return ArrayHelper::map($query, 'year', 'year');
    }

    private  function groupDateInTableByRun($table, $field){
    	$query = $this->connection->createCommand("select DATE_FORMAT(". $field.", '%Y') as year from ". $table. " group by DATE_FORMAT(". $field.", '%Y') ORDER BY ". $field ." DESC ")->queryAll();
    	return ArrayHelper::map($query, 'year', 'year');
    }

    private  function selectCountMonthInYear($table, $fieldDate, $where = null){
    	$month = [];
    	$total = 0;
		for($i = 1 ; $i <= 12; $i++ ){
			$amount = $this->connection->createCommand('select count(*) as amount from '. $table.' where  MONTH(FROM_UNIXTIME('. $fieldDate.')) = '. $i . $where)->queryOne();
			$month['month'][$i] = $amount['amount'];
			$total  += $amount['amount'];
		}
		$month['totalAmount'] = $total;
		return $month;
    }

    private  function selectCountInYearByRun($table, $fieldDate, $where = null){
    	$month = [];
    	$total = 0;
		for($i = 1 ; $i <= 12; $i++ ){
			$sql = "SELECT COUNT(*) AS amount from ". $table. " WHERE DATE_FORMAT(". $fieldDate.", '%m') = ". $i . $where;
			$amount = $this->connection->createCommand($sql)->queryOne();
			$month['month'][$i] = $amount['amount'];
			$total  += $amount['amount'];
		}
		$month['totalAmount'] = $total;
		return $month;
    }

    private function selectSumTotalInYear($table, $fieldDate, $fieldSum, $where = null){
    	$this->connection = Yii::$app->db;
    	if($where) $where = ' and ' . $where;
    	$month = [];
    	$total = 0;
		for($i = 1 ; $i <= 12; $i++ ){
			$amount = $this->connection->createCommand('select sum('.$fieldSum.') as total from '. $table.' where  MONTH(FROM_UNIXTIME('. $fieldDate.')) = '. $i . $where)->queryOne();
			$month['sumInMonth'][$i] = $amount['total'];
			$total  += $amount['total'];
		}
		$month['totalSum'] = $total;
		return $month;
    }

    public function selectCountDataAllRender($table, $fieldDate, $view, $dataView = null, $where = null){
    	$this->connection = Yii::$app->db;
    	if($where) $where = ' and ' . $where;
    	if(Yii::$app->request->get('year')){
			$where .= ' and year(FROM_UNIXTIME('. $fieldDate.')) = '. Yii::$app->request->get('year');
		}else  $where .= ' and year(FROM_UNIXTIME('. $fieldDate.')) = '. date('Y');
		$groupYear = $this->groupDateInTable($table, $fieldDate);
		$data = $this->selectCountMonthInYear($table, $fieldDate, $where);
		$arrView = [
			'totalAmount' => $data['totalAmount'],
			'totalInMonth' => $data['month'],
			'groupYear' => $groupYear
		];
		if($dataView != null){
			foreach($dataView as $key => $value){
				$arrView[$key] = $value;
			}
		}
		return $this->render($view, $arrView);
    }

    public function selectCountDataAllByRun($table, $fieldDate, $view, $dataView = null, $where = null){
    	$this->connection = Yii::$app->db;
    	if($where) $where = ' and ' . $where;
    	if(Yii::$app->request->get('year')){
			$where .= " and DATE_FORMAT(". $fieldDate .", '%Y') = ". Yii::$app->request->get('year');
		}

		$groupYear = $this->groupDateInTableByRun($table, $fieldDate);
		$data = $this->selectCountInYearByRun($table, $fieldDate, $where);
		$arrView = [
			'totalAmount' => $data['totalAmount'],
			'totalInMonth' => $data['month'],
			'groupYear' => $groupYear
		];
		if($dataView != null){
			foreach($dataView as $key => $value){
				$arrView[$key] = $value;
			}
		}
		
		return $this->render($view, $arrView);
    }

    private function selectCountChannel($type){
    	$where = '';
    	if(Yii::$app->request->get('year')){
			$where .= ' and year(FROM_UNIXTIME(dt_created)) = '. Yii::$app->request->get('year');
		}
    	$this->connection = Yii::$app->db;
    	$group = $this->connection->createCommand('select id, name from channel_type where status = 1 and ch_type =  '. $type)->queryAll();
    	foreach($group as $key => $value){
    		$data = $this->selectCountMonthInYear('`order`', 'dt_created', ' and channel_id  = '. $value['id']. $where);
    		$group[$key]['month'] = $data['month'];
    		$group[$key]['totalAmount'] = $data['totalAmount']; 
    	}
    	return $group;
    }

   	private function selectCountChannelUnsync(){
   		$data['channel'] = $this->selectCountChannel(2);
   		$data['groupYear'] = $this->groupDateInTable('`order`', 'dt_created');
   		return $this->render('summary-channel-unsync', $data);
   	}

   	private function selectCountChannelSync(){
   		$data['channel'] = $this->selectCountChannel(1);
   		$data['groupYear'] = $this->groupDateInTable('`order`', 'dt_created');
   		return $this->render('summary-channel-sync', $data);
   	}

    public function actionGrowSeller(){
    	return $this->selectCountDataAllRender('tenant' ,'created_at', 'grow-seller', null, 'is_protected = 0');
    }
    public function actionSummaryOrder(){
    	$total = $this->selectSumTotalInYear('`order`', 'dt_created', 'total', 'status = 1');
   		return $this->selectCountDataAllRender('`order`' ,'dt_created', 'summary-order',  $total, ' status = 1');
   	}

   	public function actionSummaryShipment(){
   		$this->connection = Yii::$app->db;
   		$where = '';
   		if(Yii::$app->request->get('year')){
   			$where .= ' and year(FROM_UNIXTIME(dt_created)) = '. Yii::$app->request->get('year');
   		}
   		$shipper = $this->connection->createCommand('SELECT id, name FROM shipper WHERE status = 1')->queryAll();
   		$month  = [];
   		foreach($shipper as $key => $value){
   			$total = 0 ;
   			for($i = 1 ; $i <= 12 ; $i++){
   				$dataCount = $this->connection->createCommand('SELECT COUNT(*) AS amount  FROM `order` INNER JOIN shipping_price on `order`.shipping_price_id = shipping_price.id  where `order`.status = 1 and MONTH(FROM_UNIXTIME(dt_created)) = '. $i.' and shipping_price.shipper_id = '. $value['id'].  $where)->queryOne();
   				$shipper[$key]['month'][$i] = $dataCount['amount'];
   				$total += $dataCount['amount'];
   			}
   			$shipper[$key]['totalAmount'] = $total;
   		}
   		$shipper['shipper'] = $shipper;
		$shipper['groupYear'] = $this->groupDateInTable('`order`', 'dt_created');
   		return $this->render('summary-shipment', $shipper);
   		
   	}

   	public function actionSummaryUser(){
   		return $this->selectCountDataAllRender('user', 'created_at', 'summary-user', null, '');
   	}

   	public function actionSummaryCustomer(){
   		return $this->selectCountDataAllByRun('customer', 'created_at', 'summary-customer', null, ' status = 1');
   	}

   	public function actionSummaryProduct(){
   		return $this->selectCountDataAllByRun('product', 'created_at', 'summary-product', null, ' status = 1');
   	}

   	public function actionSummaryChannelUnsync(){
   		return $this->selectCountChannelUnsync();
   	}

   	public function actionSummaryChannelSync(){
   		return $this->selectCountChannelSync();	
   	}

    public function actionIndex(){
        return $this->render('index');
    }
}
