<?php
	namespace app\controllers;
	use Yii;
	use app\models\PermissionResource;
	use yii\data\ActiveDataProvider;
	use yii\web\Controller;
	use yii\web\NotFoundHttpException;
	use yii\filters\VerbFilter;


	class PermissionResourceController extends Controller{
		function actionIndex(){
			$permissionResource = new PermissionResource();
			if($permissionResource->load(Yii::$app->request->post())&& $permissionResource->save()){
				Yii::$app->session->setFlash('success', 'Save success !');
				return $this->redirect(['permission-resource/list']);
			}
			return $this->render('form', ['model' => $permissionResource]);
		}

		function actionList(){
			$query = PermissionResource::find();
			$dataProvider = new ActiveDataProvider([
				'query' => $query
			]);
			return $this->render('list',['dataProveder' => $dataProvider]);
		}

		public function actionDelete($id = null){
		$permissionResource = PermissionResource::find()->where(['id' => $id])->one();
		if($permissionResource->delete()){
			return $this->redirect(['permission-resource/list']);
		}
	}
	}
?>