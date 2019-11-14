<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property int $categories_id
 * @property int $price
 * @property int $hidden
 *
 * @property Categories $categories
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['categories_id', 'price', 'hidden'], 'required'],
            [['categories_id', 'price', 'hidden'], 'integer'],
         //   [['categories_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['categories_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'categories_id' => 'Категория',
            'categoriesName' => 'Категория',
            'price' => 'Цена',
            'hidden' => 'В наличии',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasOne(Categories::className(), ['id' => 'categories_id']);
    }

    /* Геттер для наименования категории */
    public function getCategoriesName() {
        return $this->Categories->name;
    }
}
