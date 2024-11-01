<?php

declare(strict_types=1);

namespace app\commands;

use app\models\Employee;
use app\enums\WeekDay;
use app\models\Language;
use Faker\Factory;
use yii\console\Controller;

class InitDataController extends Controller
{
    private const array LANGUAGES = [
        'ab' => 'Абхазский',
        'av' => 'Аварский',
        'ae' => 'Авестийский',
        'az' => 'Азербайджанский',
        'ay' => 'Аймара',
        'ak' => 'Акан',
        'sq' => 'Албанский',
        'am' => 'Амхарский',
        'en' => 'Английский',
        'ar' => 'Арабский',
        'hy' => 'Армянский',
        'as' => 'Ассамский',
        'aa' => 'Афарский',
        'af' => 'Африкаанс',
        'bm' => 'Бамбара',
        'eu' => 'Баскский',
        'ba' => 'Башкирский',
        'be' => 'Белорусский',
        'bn' => 'Бенгальский',
        'my' => 'Бирманский',
        'bi' => 'Бислама',
        'bg' => 'Болгарский',
        'bs' => 'Боснийский',
        'br' => 'Бретонский',
        'cy' => 'Валлийский',
        'hu' => 'Венгерский',
        've' => 'Венда',
        'vo' => 'Волапюк',
        'wo' => 'Волоф',
        'vi' => 'Вьетнамский',
        'gl' => 'Галисийский',
        'lg' => 'Ганда',
        'hz' => 'Гереро',
        'kl' => 'Гренландский',
        'el' => 'Греческий (новогреческий)',
        'ka' => 'Грузинский',
        'gn' => 'Гуарани',
        'gu' => 'Гуджарати',
        'gd' => 'Гэльский',
        'da' => 'Датский',
        'dz' => 'Дзонг-кэ',
        'dv' => 'Дивехи (Мальдивский)',
        'zu' => 'Зулу',
        'he' => 'Иврит',
        'ig' => 'Игбо',
        'yi' => 'Идиш',
        'id' => 'Индонезийский',
        'ia' => 'Интерлингва',
        'ie' => 'Интерлингве',
        'iu' => 'Инуктитут',
        'ik' => 'Инупиак',
        'ga' => 'Ирландский',
        'is' => 'Исландский',
        'es' => 'Испанский',
        'it' => 'Итальянский',
        'yo' => 'Йоруба',
        'kk' => 'Казахский',
        'kn' => 'Каннада',
        'kr' => 'Канури',
        'ca' => 'Каталанский',
        'ks' => 'Кашмири',
        'qu' => 'Кечуа',
        'ki' => 'Кикуйю',
        'kj' => 'Киньяма',
        'ky' => 'Киргизский',
        'zh' => 'Китайский',
        'kv' => 'Коми',
        'kg' => 'Конго',
        'ko' => 'Корейский',
        'kw' => 'Корнский',
        'co' => 'Корсиканский',
        'xh' => 'Коса',
        'ku' => 'Курдский',
        'km' => 'Кхмерский',
        'lo' => 'Лаосский',
        'la' => 'Латинский',
        'lv' => 'Латышский',
        'ln' => 'Лингала',
        'lt' => 'Литовский',
        'lu' => 'Луба-катанга',
        'lb' => 'Люксембургский',
        'mk' => 'Македонский',
        'mg' => 'Малагасийский',
        'ms' => 'Малайский',
        'ml' => 'Малаялам',
        'mt' => 'Мальтийский',
        'mi' => 'Маори',
        'mr' => 'Маратхи',
        'mh' => 'Маршалльский',
        'me' => 'Мерянский',
        'mo' => 'Молдавский',
        'mn' => 'Монгольский',
        'gv' => 'Мэнский (Мэнкский)',
        'nv' => 'Навахо',
        'na' => 'Науру',
        'nd' => 'Ндебеле северный',
        'nr' => 'Ндебеле южный',
        'ng' => 'Ндунга',
        'de' => 'Немецкий',
        'ne' => 'Непальский',
        'nl' => 'Нидерландский (Голландский)',
        'no' => 'Норвежский',
        'ny' => 'Ньянджа',
        'nn' => 'Нюнорск (новонорвежский)',
        'oj' => 'Оджибве',
        'oc' => 'Окситанский',
        'or' => 'Ория',
        'om' => 'Оромо',
        'os' => 'Осетинский',
        'pi' => 'Пали',
        'pa' => 'Пенджабский',
        'fa' => 'Персидский',
        'pl' => 'Польский',
        'pt' => 'Португальский',
        'ps' => 'Пушту',
        'rm' => 'Ретороманский',
        'rw' => 'Руанда',
        'ro' => 'Румынский',
        'rn' => 'Рунди',
        'ru' => 'Русский',
        'sm' => 'Самоанский',
        'sg' => 'Санго',
        'sa' => 'Санскрит',
        'sc' => 'Сардинский',
        'ss' => 'Свази',
        'sr' => 'Сербский',
        'si' => 'Сингальский',
        'sd' => 'Синдхи',
        'sk' => 'Словацкий',
        'sl' => 'Словенский',
        'so' => 'Сомали',
        'st' => 'Сото южный',
        'sw' => 'Суахили',
        'su' => 'Сунданский',
        'tl' => 'Тагальский',
        'tg' => 'Таджикский',
        'th' => 'Тайский',
        'ty' => 'Таитянский',
        'ta' => 'Тамильский',
        'tt' => 'Татарский',
        'tw' => 'Тви',
        'te' => 'Телугу',
        'bo' => 'Тибетский',
        'ti' => 'Тигринья',
        'to' => 'Тонганский',
        'tn' => 'Тсвана',
        'ts' => 'Тсонга',
        'tr' => 'Турецкий',
        'tk' => 'Туркменский',
        'uz' => 'Узбекский',
        'ug' => 'Уйгурский',
        'uk' => 'Украинский',
        'ur' => 'Урду',
        'fo' => 'Фарерский',
        'fj' => 'Фиджи',
        'fl' => 'Филиппинский',
        'fi' => 'Фински',
        'fr' => 'Французский',
        'fy' => 'Фризский',
        'ff' => 'Фулах',
        'ha' => 'Хауса',
        'hi' => 'Хинди',
        'ho' => 'Хиримоту',
        'hr' => 'Хорватский',
        'cu' => 'Церковнославянски',
        'ch' => 'Чаморро',
        'ce' => 'Чеченский',
        'cs' => 'Чешский',
        'za' => 'Чжуанский',
        'cv' => 'Чувашский',
        'sv' => 'Шведский',
        'sn' => 'Шона',
        'ee' => 'Эве',
        'eo' => 'Эсперанто',
        'et' => 'Эстонский',
        'jv' => 'Яванский',
        'ja' => 'Японский',
    ];

    public function actionIndex()
    {
        $faker = Factory::create();

        /** @var array<string, Language> $languages */
        $languages = [];

        foreach (self::LANGUAGES as $language_code => $language_name_ru) {
            $language = new Language();
            $language->setIsNewRecord(true);
            $language->code = $language_code;
            $language->name_ru = $language_name_ru;
            if ($language->save()) {
                $languages[$language_code] = $language;
                printf(
                    "Language %d. [%s] %s\n",
                    $language->id,
                    $language->code,
                    $language->name_ru,
                );
            }
        }

        for ($i = 0; $i < 100; $i++) {
            $employee = new Employee();
            $employee->setIsNewRecord(true);
            $employee->first_name = $faker->firstName;
            $employee->last_name = $faker->lastName;
            $employee->middle_name = rand(0, 1) === 1
                ? $faker->firstName
                : null;
            $employee->work_days = WeekDay::getRandomBinarySum();
            $employee->part_work_days = WeekDay::getRandomBinarySum();

            if ($employee->save()) {
                printf(
                    "Employee %d. %s %s %s\n",
                    $employee->id,
                    $employee->first_name,
                    $employee->last_name,
                    $employee->middle_name,
                );

                $languages_max = rand(3, 6);

                /** @var string[] $selected_language_codes */
                $selected_language_codes = [];

                for ($l = 0; $l < $languages_max; $l++) {
                    do {
                        $rand_lang_code = array_rand($languages);
                    } while (in_array($rand_lang_code, $selected_language_codes));

                    $selected_language_codes[] = $rand_lang_code;

                    $employee->link('languages', $languages[$rand_lang_code]);
                }
            }
        }
    }
}