<?php 

namespace app\models;


/**
 * модель для работы с заказом
 */
class Order extends AppModel {

    /**
     * сохраняем сам заказ в таблицу БД order
     */
    public static function saveOrder($data){
        $order = \R::dispense('order');
        $order->user_id = $data['user_id'];
        $order->note = $data['note'];
        $order->currency = $_SESSION['cart.currency']['code'];
        $order_id = \R::store($order);
        self::saveOrderProduct($order_id);
        return $order_id;
    }

    /**
     * сохраняем продукт заказа в таблицу БД order_product
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