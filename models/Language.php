<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Язык
 *
 * @property string $code
 * @property string $name_ru Наименование на русском
 */
class Language extends ActiveRecord
{
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['code', 'name_ru'], 'required'],
            [['code'], 'unique'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'code' => 'Код языка',
            'name_ru' => 'Наименование на русском',
        ];
    }
}
