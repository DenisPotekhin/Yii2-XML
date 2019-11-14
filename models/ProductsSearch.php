<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Products;

/**
 * ProductsSearch represents the model behind the search form of `app\models\Products`.
 */
class ProductsSearch extends Products
{
    public $categoriesName;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'categories_id', 'price', 'hidden'], 'integer'],
            [['categoriesName'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Products::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->setSort([
            'attributes' => [
                'id',

                'categoriesName' => [
                    'asc' => ['categories.name' => SORT_ASC],
                    'desc' => ['categories.name' => SORT_DESC],
                    'label' => 'Категория'
                ],

                'price',
                'hidden',
            ]
        ]);
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            $query->joinWith(['categories']);
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'products.id' => $this->id,
            'products.categories_id' => $this->categories_id,
            'products.price' => $this->price,
            'products.hidden' => $this->hidden,
        ]);

        $query->joinWith(['categories' => function ($q) {
            $q->where('categories.name LIKE "%' . $this->categoriesName . '%"');
        }]);

        return $dataProvider;
    }
}
