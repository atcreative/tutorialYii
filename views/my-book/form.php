<?php 
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use marqu3s\summernote\Summernote;
	$form = ActiveForm::begin();
	echo $form->field($model, 'category_id')->dropDownList($categoryList);
	echo $form->field($model, 'name');
	echo $form->field($model, 'price');
	echo $form->field($model, 'detail')->widget(Summernote::className());
	echo HTML::submitButton('Save', ['class' => 'btn btn-primary']);
	ActiveForm::end();
?>

