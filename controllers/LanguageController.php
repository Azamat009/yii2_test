<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\Language;
use yii\rest\ActiveController;

class LanguageController extends ActiveController
{
    public $modelClass = Language::class;
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'corsFilter'  => [
                'class' => \yii\filters\Cors::class,
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