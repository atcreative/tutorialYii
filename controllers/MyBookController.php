<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\models\Book;
use yii\data\ActiveDataProvider;
use app\models\Category;
use yii\helpers\ArrayHelper;
use yii\db\Query;

class MyBookController extends Controller{
	public function actionIndex($name=null, $age=20 ){
		return 'Hello '. $name;
	}
	
	public function actionAddCalc($a=2, $b=3){
		// return $a+$b;
		return $this->add(2, 4);
	}
	
	protected function add($a, $b){
		return $a + $b;
	}
	
	public function actionShowView($name=null, $age=null){
		$name = 'kerkkhai';
		$age = 20;
		$category = Book::find()->all();

		$connection = Yii::$app->db;
		$select = $connection->createCommand('select * from book')->queryAll();
		
		$categories = new Category();
		$select = $categories->find()->all();
		foreach($select as $select){
			if(!empty($select->books)){
				foreach($select->books as $index){
					print_r($index->name);
				}
			}
		}
#		foreach($category as $category){
#			if(!empty($category->category->name)) print_r($category->category->name);
#		}
		return $this->render('index', ['name'=>$name, 'age'=>$age]);
	}

	public function actionForm($id = null){
		$book = [];
		$categories = Category::find()->where(['visible' => 1])->all();
		$categoryList = ArrayHelper::map($categories, 'id', 'name');
	
		if($id != null){
			$book = Book::find()->where(['id' => $id])->one();
		}else{
			$book = new Book();
		}
	
#		if(!empty(Yii::$app->request->post())){
##			$book = new Book();
##			$name = Yii::$app->request->post('name');
##			$detail = Yii::$app->request->post('detail');
##			$price = Yii::$app->request->post('price');
##			$book->name = $name;
##			$book->detail = $detail;
##			$book->price = $price;
##			$book->visible = 1;
#			if($book->load(Yii::$app->request->post())&& $book->save()){
#				return 'Success';
#			}
#		}

		if($book->load(Yii::$app->request->post())&& $book->save()){
			Yii::$app->session->setFlash('success', 'Save success !');
			return $this->redirect(['my-book/list']);
		}
		return $this->render('form', ['model' => $book, 'categoryList' => $categoryList]);
	}

	public function actionDelete($id = null){
		$book = Book::find()->where(['id' => $id])->one();
		if($book->delete()){
			return $this->redirect(['my-book/list']);
		}
	}

	public function actionList(){
		//where ('name' => 'value')
		//where('name = 1')
		//where('!=', 'name', 'value')
		//where('name = :name', [':name'=>'value'])
#		$query = Book::find()->where(['visible' => [1,3]]);
		$query = Book::find();
		$dataProvider = new ActiveDataProvider([
			'query' => $query
		]);
		return $this->render('list', ['dataProvider' => $dataProvider]);
	}

	function actionNewForm(){
		return 'new form';
	}
	
}
?>
