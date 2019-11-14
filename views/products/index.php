<?php

use yii\grid\GridView;

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,

    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'id',
            'filter' => '<input class="form-control" name="filtereid" value="'. $searchModel['id'] .'" type="text">',
            'value' => 'id',
        ],

        [
            'attribute' => 'category',
            'filter' => '<input class="form-control" name="filterecategory" value="'. $searchModel['category'] .'" type="text">',
            'value' => 'category',
        ],
        [
            "attribute" => "price",
            'filter' => '<input class="form-control" name="filtereprice" value="'. $searchModel['price'] .'" type="text">',
            'value' => 'price',
        ],
        [
            'attribute' => 'hidden',
            'filter' => '<input class="form-control" name="filterehidden" value="'. $searchModel['hidden'] .'" type="text">',
            'value' => 'hidden',
        ],

    ]
]);
