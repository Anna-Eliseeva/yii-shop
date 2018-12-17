<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018-12-14
 * Time: 21:58
 */

namespace app\models;
use yii\db\ActiveRecord;


class Category extends ActiveRecord
{
    public static function tableName()
    {
        return 'category';
    }

    public function getProducts(){
        return $this->hasMany(Product::class(), ['category_id' => 'id']);
    }
}