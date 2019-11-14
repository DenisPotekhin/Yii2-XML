<?php

namespace app\controllers;

use app\models\Categories;
use app\models\ProductsSearch;
use DOMDocument;
use DOMXPath;
use Yii;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class ProductsController extends Controller
{

    public function actionIndex()
    {
        //парсинг двух XML файлов в 2 массива
        $xmlURLCategories = "../categories.xml";
        $xmlCategories = simplexml_load_file($xmlURLCategories);
        $jsonCategories = json_encode($xmlCategories);
        $arrayCategories = json_decode($jsonCategories,TRUE);

        $xmlURLProducts = "../products.xml";
        $xmlProducts = simplexml_load_file($xmlURLProducts);
        $jsonProducts = json_encode($xmlProducts);
        $arrayProducts = json_decode($jsonProducts,TRUE);

     //соединение 2 массива в один массив products

        $categories=$arrayCategories['item'];
        $products=$arrayProducts['item'];

        for ($i = 0; $i < count($products); $i++) {
            $catName = $categories[array_search($products[$i]['categoryId'], array_column($categories, 'id'))]['name'];
            $products[$i]['category'] = $catName;
            unset($products[$i]['categoryId']);
        }


     //передаем полученный результат на фильтрацию
        $resultData=$products;

        $filteredresultData_price = array_filter($resultData, [$this,'filter_price']);

        $filteredresultData_hidden = array_filter($filteredresultData_price,  [$this,'filter_hidden']);

        $filteredresultData_category = array_filter($filteredresultData_hidden, [$this,'filter_category']);

        $filteredresultData = array_filter($filteredresultData_category, [$this,'filterid']);

        $pricefilter = Yii::$app->request->getQueryParam('filtereprice', '');
        $categoryfilter = Yii::$app->request->getQueryParam('filtercategory', '');
        $hiddenfilter = Yii::$app->request->getQueryParam('filterhidden', '');

        $searchModel = ['id' => null, 'category' => $categoryfilter, 'price' => $pricefilter, 'hidden' => $hiddenfilter];

        $dataProvider = new \yii\data\ArrayDataProvider([
            'key'=>'id',
            'allModels' => $filteredresultData,
            'sort' => [
                'attributes' => ['id', 'category', 'price','hidden'],
            ],
        ]);





        return $this->render('index', [
           'dataProvider' => $dataProvider,
            'searchModel' =>   $searchModel,

        ]);
    }

    public function filter_price($item) {
    $pricefilter = (String)Yii::$app->request->getQueryParam('filtereprice', '');

    if ((strlen($pricefilter) > 0))
    {
        if (strpos($item['price'], $pricefilter) !== false)
        {
            return true;
        } else {
            return false;
        }
    } else {
        return true;
    }
}
    public  function filter_hidden($item) {
    $hiddenfilter = (String)Yii::$app->request->getQueryParam('filterehidden', '');

    if ((strlen($hiddenfilter) > 0))
    {
        if (strpos($item['hidden'], $hiddenfilter) !== false)
        {
            return true;
        } else {
            return false;
        }
    } else {
        return true;
    }
}
    public function filter_category($item) {
        $categoryfilter = (String)Yii::$app->request->getQueryParam('filterecategory', '');

        if ((strlen($categoryfilter) > 0))
        {
            if (strpos($item['category'], $categoryfilter) !== false)
            {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    public function filterid($item) {
        $idfilter = (String)Yii::$app->request->getQueryParam('filtereid', '');

        if ((strlen($idfilter) > 0))
        {
            if (strpos($item['id'], $idfilter) !== false)
            {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }
}
