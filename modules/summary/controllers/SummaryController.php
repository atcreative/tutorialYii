<?php

namespace app\modules\summary\controllers;
use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;


class SummaryController extends Controller{
	public function actionIndex(){
		// $test  = $this->safe_b64encode('135581');
		// print_r($test . '<br>');
		// print_r($this->safe_b64decode($test));
		return $this->render('index');
    }

    public  function safe_b64encode($string) {
        $data = base64_encode($string);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return $data;
    }
    public function safe_b64decode($string) {
        $data = str_replace(array('-','_'),array('+','/'),$string);
        $mod4 = strlen($data) % 4;
        if($mod4){
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }
}
