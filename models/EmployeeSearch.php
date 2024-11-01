<?php

declare(strict_types=1);

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class EmployeeSearch extends Model
{
    public function rules()
    {
        return [
            ['work_days', 'integer'],
        ];
    }

    public function search($params)
    {
        $query = Employee::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 30,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        if (!empty($this->work_days)) {
            $query->andWhere(['=', "(work_days | {$this->work_days})", $this->work_days]);
        }

        return $dataProvider;
    }
}