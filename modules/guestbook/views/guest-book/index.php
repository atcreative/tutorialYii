<?php
 	use yii\grid\GridView;
	echo GridView::widget([
		'dataProvider' => $provider,
		'columns' =>[
				'name',
				'price',
				[
					'label' => 'Created',
					'format' => 'raw',
					'attribute' => 'created',
					'value' => function ($model){
						return Yii::$app->formatter->asDate($model['created'], 'php:d/m/Y H:i:s');
					}
				],
				[
					'label' => 'wareHouse',
					'format' => 'raw',
					'attribute' => 'warehouse',
					'value'=> function($model){
						$tag = '';
						foreach($model['warehouse']  as $key => $value){
							$tag .=  $value .'<br>';
						}
						return $tag;
					}
				]

			]
		]);
?>

<div class="guestbook-default-index">
    <h1><?= $this->context->action->uniqueId ?></h1>
    <p>
        This is the view content for action "<?= $this->context->action->id ?>".
        The action belongs to the controller "<?= get_class($this->context) ?>"
        in the "<?= $this->context->module->id ?>" module.
    </p>
    <p>
        You may customize this page by editing the following file:<br>
        <code><?= __FILE__ ?></code>
    </p>
</div>
