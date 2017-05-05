<?php

namespace app\modules\guestbook\controllers;

use yii\web\Controller;
use yii\data\ArrayDataProvider;

/**
 * Default controller for the `guestbook` module
 */
class GuestBookController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
		$data = [
			[
				'id' => 1,
				'name' => 'name1',
				'price' => 200,
				'warehouse' => [
					'name1' => 1,
					'name2' => 2,
					'name3' => 3
				],
				'created' => time(),
			],
			[
				'id' => 2,
				'name' => 'name2',
				'price' => 421,
				'warehouse' => [
					'name1' => 1,
					'name2' => 2
				],
				'created' => time(),
			],
			[
				'id' => 3,
				'name' => 'name3',
				'price' => 70,
				'warehouse' => [
					'name1' => 1
				],
				'created' => time(),
			],
		];
		// array Data Provider Sort This Only
		$provider = new ArrayDataProvider([
			'allModels' => $data,
			'sort' => [
				'attributes' => ['name', 'price'],
			],
		]);
        return $this->render('index', ['provider' => $provider]);
    }
}
