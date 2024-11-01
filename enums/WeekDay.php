<?php

declare(strict_types=1);

namespace app\enums;

use DateTimeInterface;

/**
 * Дни недели
 */
enum WeekDay: int
{
    case Monday = 1;
    case Tuesday = 2;
    case Wednesday = 4;
    case Thursday = 8;
    case Friday = 16;
    case Saturday = 32;
    case Sunday = 64;

    /**
     * Получение списка дней недели из суммы байтов
     *
     * @return self[]
     */
    public static function getListFromByteSum(int $byte_sum): array
    {
        $result = [];

        foreach (self::cases() as $week_day) {
            if (($byte_sum & $week_day->value) === $week_day->value) {
                $result[] = $week_day;
            }
        }

        return $result;
    }

    public static function getRandomBinarySum(): int
    {
        return rand(0, 127);
    }

    /**
     * Получение русского наименования
     */
    public function getNameRussian(): string
    {
        return match ($this) {
            self::Monday => 'Понедельник',
            self::Tuesday => 'Вторник',
            self::Wednesday => 'Среда',
            self::Thursday => 'Четверг',
            self::Friday => 'Пятница',
            self::Saturday => 'Суббота',
            self::Sunday => 'Воскресенье',
        };
    }

    public static function fromDateTime(DateTimeInterface $date_time): self
    {
        return match ($date_time->format('N')) {
            '1' => self::Monday,
            '2' => self::Tuesday,
            '3' => self::Wednesday,
            '4' => self::Thursday,
            '5' => self::Friday,
            '6' => self::Saturday,
            '7' => self::Sunday,
        };
    }
}