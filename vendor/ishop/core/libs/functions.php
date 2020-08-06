<?php
/**
 * файл для служебных функций, доступных для всего проекта
 */


 /**
  * функция для распечатки, в первую очередь массивов
  */
 function debug($arr, $die = false){
    echo '<pre>' . print_r($arr, true) . '</pre>';
    if($die) die;
 }

 /**
  * функция принимает параметром некий адрес и перенаправляет на него,
  * иначе - обновляет страницу(либо отправляет на главную)
  */
  function redirect($http = false){
     if($http){
        $redirect = $http;
     }else{
        $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PATH;
     }
     header("Location: $redirect");
     exit;
  }

  /**
   * функция для замены функции htmlspecialchars()
   */
  function h($str){
   return htmlspecialchars($str, ENT_QUOTES);
  }

