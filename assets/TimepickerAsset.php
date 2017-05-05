<?php
	namespace app\assets;

	use yii\web\AssetBundle;

	class TimepickerAsset extends AssetBundle{
		public $basePath = '@webroot/timepicker';
		public $baseUrl = '@web/timepicker';
		public $css = [
			'css/jquery.timepicker.css',
		];
		public $js = [
			'js/jquery.timepicker.min.js',
		];

		public $depends = [
			'yii\web\JqueryAsset',
		];
	}
?>
