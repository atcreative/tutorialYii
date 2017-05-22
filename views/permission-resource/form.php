<?php 
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	$form = ActiveForm::begin();
	echo $form->field($model, 'resource_name');
	echo $form->field($model, 'status')->checkBox();
	echo HTML::submitButton('Save', ['class' => 'btn btn-primary']);
	ActiveForm::end();
?>