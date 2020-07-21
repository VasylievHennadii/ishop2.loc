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
        $sql_part = '';
        foreach($_SESSION['cart'] as $product_id => $product){
            $product_id = (int)$product_id;
            $sql_part .= "($order_id, $product_id, {$product['qty']}, '{$product['title']}', {$product['price']}),";
        }
        $sql_part = rtrim($sql_part, ',');
        \R::exec("INSERT INTO order_product (order_id, product_id, qty, title, price) VALUES $sql_part");
    }

    /**
     * метод отправляет письмо администратору магазина и клиенту
     */
    public static function mailOrder($order_id, $user_email){

    }

}














?>