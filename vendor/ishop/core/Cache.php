<?php

namespace ishop;

/**
 * класс для кеширования,
 * реализует паттерн Singletone,
 * создаем объект кеша только один раз
 */
class Cache {

    use TSingletone;

    /**
     * метод записывыает в кеш,
     * 3600с=1ч храним кешированные данные
     */
    public function set($key, $data, $seconds = 3600){
        if($seconds) {
            $content['data'] = $data;
            $content['end_time'] = time() + $seconds;
            //записываем данные в кеш
            if(file_put_contents(CACHE . '/' . md5($key) . '.txt', serialize($content))){
                return true;
            }
        }
        return false;
    }

    /**
     * метод получает из кеша
     */
    public function get($key){
        $file = CACHE . '/' . md5($key) . '.txt';
        //проверяем есть ли файл кеша
        if(file_exists($file)){
            $content = unserialize(file_get_contents($file));
            //проверяем не устарел ли кеш
            if(time() <= $content['end_time']){
                return $content; //возвращаем кеш, если он не устарел
            }
            unlink($file); //удаляем кеш, если он устарел
        }
        return false;
    }

    /**
     * удаляем кеш
     */
    public function delete($key){
        $file = CACHE . '/' . md5($key) . '.txt';
        //проверяем есть ли файл кеша
        if(file_exists($file)){          
            unlink($file); //удаляем кеш
        }
    }



}