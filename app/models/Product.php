<?php

namespace app\models;

/**
 * модель карточки продуктов
 */
class Product extends AppModel {

    /**
     * добавляет просмотренный товар в cookies
     */
    public function setRecentlyViewed($id){
        $recentlyViewed = $this->getAllRecentlyViewed();//получаем все просмотренные товары из cookies
        if(!$recentlyViewed){
            setcookie('recentlyViewed', $id, time() + 3600*24, '/');// если в куках ничего нет - записываем данный товар в куки
        }else{
            $recentlyViewed = explode('.', $recentlyViewed);
            if(!in_array($id, $recentlyViewed)){
                $recentlyViewed[] = $id;//Array ([0] => 2 [1] => 6)
                $recentlyViewed = implode('.', $recentlyViewed);//2.6
                setcookie('recentlyViewed', $recentlyViewed, time() + 3600*24, '/');
            }
            // debug($recentlyViewed);
        }
    }

    /**
     * получаем количество просмотренных товаров
     */
    public function getRecentlyViewed(){
        if(!empty($_COOKIE['recentlyViewed'])){
            $recentlyViewed = $_COOKIE['recentlyViewed'];
            $recentlyViewed = explode('.', $recentlyViewed);
            return array_slice($recentlyViewed, -3);//из массива просмотренных товаров вернем только три последних новых(уникальных)
        }
        return false;
    }

    /**
     * получаем все просмотренные товары из cookies
     */
    public function getAllRecentlyViewed(){
        if(!empty($_COOKIE['recentlyViewed'])){
            return $_COOKIE['recentlyViewed'];
        }
        return false;
    }

}