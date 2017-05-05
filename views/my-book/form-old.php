<?php
use yii\widgets\ActiveForm;

	use yii\helpers\html;
	echo Html::beginForm();
?>

	<?php echo Html::errorSummary($model) ?>
	<div class="form-gorup">
		<?php echo Html::label(Yii::t('app', 'Category Id')) ?>
		<?php echo Html::activeDropDownList($model , 'category_id', $categoryList, ['class' => 'form-control', 'prompt' => 'Select Category'])?>
	</div>
	<div class="form-gorup">
		<?php echo Html::label(Yii::t('app', 'Name')) ?>
		<?php echo Html::activeTextInput($model , 'name', ['class' => 'form-control'])?>
		<?php echo Html::error($model, 'name') ?>
	</div>
	<div class="form-group">
		<?php echo html::label(Yii::t('app', 'Detail'))?>
		<?php echo Html::activeTextInput($model ,'detail', ['class' => 'form-control']) ?>
		<?php echo Html::error($model, 'detail') ?>
		
	</div>
	<div class="form-group">
		<?php echo html::label(Yii::t('app', 'Price'))?>
		<?php echo Html::activeTextInput($model ,'price', ['class' => 'form-control']) ?>
		<?php echo Html::error($model, 'price') ?>
		
	</div>
	<div class="form-group">
		<?php echo Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
	</div>

<?
	echo Html::endForm();
?>
