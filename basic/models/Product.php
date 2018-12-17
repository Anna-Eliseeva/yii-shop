<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018-12-14
 * Time: 21:58
 */

namespace app\models;
use yii\db\ActiveRecord;


class Product extends ActiveRecord
{
    public static function tableName()
    {
        return 'product';
    }

    public function getCategory(){
        return $this->hasOne(Category::class(), ['id' => 'category_id']);
    }
}