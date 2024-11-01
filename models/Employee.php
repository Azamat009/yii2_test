<?php

namespace app\models;

use DateTimeImmutable;
use app\enums\WeekDay;
use Yii;
use yii\db\ActiveRecord;

class Employee extends ActiveRecord
{
//    public string $first_name;
//    public string $last_name;
//    public ?string $middle_name = null;
//    public int $work_days = 0;
//    public int $part_work_days = 0;
//    public ?DateTimeImmutable $work_from = null;
//    public ?DateTimeImmutable $work_until = null;
//    public DateTimeImmutable $created_at;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name'], 'required'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'middle_name' => 'Отчество',
            'work_days' => 'Рабочие дни',
            'part_work_days' => 'Частично рабочие дни',
        ];
    }

    public function getLanguages()
    {
        return $this->hasMany(Language::class, ['id' => 'language_id'])
            ->viaTable('employee_language', ['employee_id' => 'id']);
    }

    /**
     * Работает ли человек в указанную дату
     */
    public function isWork(
        bool $partially = null,
        DateTimeImmutable $datetime = null,
    ): bool
    {
        $datetime ??= new DateTimeImmutable();
        $week_day = WeekDay::fromDateTime($datetime);

        if ($partially) {
            $work_days = $this->part_work_days;
        } elseif ($partially === false) {
            $work_days = $this->work_days;
        } else {
            $work_days = $this->part_work_days | $this->work_days;
        }

        if (($work_days & $week_day->value) !== $week_day->value) {
            return false;
        }

        return true;
    }

    /**
     * @return WeekDay[]
     */
    public function getWorkDays(): array
    {
        return $this->work_days ? WeekDay::getListFromByteSum($this->work_days) : [];
    }

    /**
     * @return WeekDay[]
     */
    public function getPartWorkDays(): array
    {
        return $this->part_work_days ? WeekDay::getListFromByteSum($this->part_work_days) : [];
    }

    public function getFullName(): string
    {
        return trim(implode(' ', [
            $this->last_name,
            $this->first_name,
            $this->middle_name ?? '',
        ]));
    }
}
