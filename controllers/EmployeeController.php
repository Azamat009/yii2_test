<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\Employee;
use app\models\EmployeeSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\Cors;
use yii\rest\ActiveController;

class EmployeeController extends ActiveController
{
    public $modelClass = Employee::class;
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        $searchModel = new EmployeeSearch();
        return $searchModel->search(Yii::$app->request->queryParams);
    }

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'corsFilter'  => [
                'class' => Cors::class,
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['*'],
                    'Access-Control-Allow-Credentials' => false,
                    'Access-Control-Max-Age' => 3600,
                ],
            ],
        ]);
    }
}