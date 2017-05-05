<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Book".
 *
 * @property integer $id
 * @property string $name
 * @property string $detail
 * @property double $price
 * @property integer $visible
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Book';
    }
	


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['detail'], 'string'],
            [['price'], 'number'],
            [['visible', 'category_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
			[['name', 'price'], 'required'], // varidate field
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'detail' => Yii::t('app', 'Detail'),
            'price' => Yii::t('app', 'Price'),
            'visible' => Yii::t('app', 'Visible'),
        ];
    }

	

	function getCategory(){
		return $this->hasOne(Category::className(), ['id' => 'category_id']);
	}
}
