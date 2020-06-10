<?php

namespace app\widgets\currency;

use ishop\App;

/**
 * класс для виджета выбора валют
 */
class Currency {

    /**
     * свойство отвечает за шаблон вывода выпадающего списка валют
     */
    protected $tpl;

    /**
     * список всех доступных валют
     */
    protected $currencies;

    /**
     * активная для пользователя валюта
     */
    protected $currency;

    /**
     * определяет путь к шаблону
     */
    public function __construct(){
        $this->tpl = __DIR__ . '/currency_tpl/currency.php';
        $this->run();
    }

    /**
     * метод получает список доступных валют и текущую валюту из контейнера,
     * и на основе этих данных вызывает метод, который строит html код
     */
    protected function run(){
        $this->currencies = App::$app->getProperty('currencies');
        $this->currency = App::$app->getProperty('currency');
        echo $this->getHtml();
    }

    /**
     * метод получает список валют из БД по полям 'code, title, symbol_left, symbol_right, value, base',
     * сортируя по base в обратном порядке(DESC). Для того, чтобы первым был элемент с base=1(т.е. базовая валюта)
     */
    public static function getCurrencies(){
        return \R::getAssoc("SELECT code, title, symbol_left, symbol_right, value, base FROM currency ORDER BY base DESC");
    }

    /**
     * метод получает активную валюту, которая записана в Cookies
     */
    public static function getCurrency($currencies){
        //если выбранная валюта существует и есть в наших Cookies, то мы выбираем её. Если нет - выбираем базовую
        if(isset($_COOKIE['currency']) && array_key_exists($_COOKIE['currency'], $currencies)){
            $key = $_COOKIE['currency'];
        }else{
            $key = key($currencies);//key() - возвращает текущий элемент массива, т.е. базовый [USD]
        }
        $currency = $currencies[$key];// [USD] => Array ([title] => доллар,[symbol_left] => $,[symbol_right] => ,  [value] => 1.00,[base] => 1)
        $currency['code'] = $key;//добавляем в массив $currency новый элемент ['code'] = USD||UAH||EUR
        return $currency;//возвращаем массив с активной валютой
    }

    /**
     * метод формирует Html разметку, подключаеи шаблон из '/currency_tpl/currency.php'
     */
    protected function getHtml(){
        ob_start();
        require_once $this->tpl;//подключаем шаблон, используем буферизацию, чтобы он не выводился
        return ob_get_clean();
    }



}