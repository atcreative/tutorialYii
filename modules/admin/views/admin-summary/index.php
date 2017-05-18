<?php
    use yii\grid\GridView;
    use yii\helpers\Html;
    use yii\helpers\Url;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Admin'), 'url' => Url::to(['index'])];
    $arrReport = [
        'Summary' => [
            [
                'name' => 'Grow Seller',
                'detail' => 'Grow Seller',
                'link' => 'admin-summary/grow-seller',
            ],  
            [
                'name' => 'Summary Orders',
                'detail' => 'Summary Orders',
                'link' => 'admin-summary/summary-order',
            ],
            [
                'name' => 'Summary Shipments', 
                'detail' => 'Summary Shipments',
                'link' => 'admin-summary/summary-shipment'
            ],
            [
                'name' => 'Summary Customers', 
                'detail' => 'Summary Customers',
                'link' => 'admin-summary/summary-customer'
            ],
            [
                'name' => 'Summary Users', 
                'detail' => 'Summary Users',
                'link' => 'admin-summary/summary-user'
            ],
            [
                'name' => 'Summary Products', 
                'detail' => 'Summary Products',
                'link' => 'admin-summary/summary-product'
            ],
            [
                'name' => 'Summary Channel Unsync', 
                'detail' => 'Summary Channel Unsync',
                'link' => 'admin-summary/summary-channel-unsync'
            ],
            [
                'name' => 'Summary Channel Sync', 
                'detail' => 'Summary Channel Sync',
                'link' => 'admin-summary/summary-channel-sync'
            ]
        ],
    ];
 ?>
<div class="col-lg-12">
<?php foreach ($arrReport as $key => $value):?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <?php echo Yii::t('app', $key) ?>
        </div>
        <div class="panel body">
            <table class="table table-bordered">
                <tr>
                    <th class="col-lg-3">Report Name</th>
                    <th>Report Description</th>
                </tr>
                <?php foreach($value as $index => $item):?>
                <tr>
                    <td><a href="<?php echo Url::to([$item['link']]) ?>"><?php echo $item['name']?></a></td>
                    <td><?php echo $item['detail']?></td>
                </tr>
                <?php endforeach?>
            </table>
        </div>
    </div>
<?php endforeach?>
</div>

