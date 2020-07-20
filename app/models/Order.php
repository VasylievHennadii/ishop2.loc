<?php 

namespace app\models;


/**
 * модель для работы с заказом
 */
class Order extends AppModel {

    /**
     * сохраняем сам заказ в таблицу order
     */
    public static function saveOrder($data){

    }

    /**
     * сохраняем продукт заказа в таблицу
     */
    public static function saveOrderProduct($order_id){

    }

    /**
     * метод отправляет письмо администратору магазина и клиенту
     */
    public static function mailOrder($order_id, $user_email){

    }

}














?>