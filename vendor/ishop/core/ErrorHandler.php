<?php

namespace ishop;

/**
 * Класс обработчик ошибок
 *
 * @author user
 */

class ErrorHandler {

    /**
     * конструктор узнает состояние kонстанты DEBUG,
     * по умолчанию стоит "1".
     */
    public function __construct(){
        if(DEBUG){
            error_reporting(-1);//показываем все ошибки
        }else{
            error_reporting(0);//выключить показ ошибок
        }
        //обрабатываем все ошибки(исключения) и назначаем свою функцию для обработки исключений - exceptionHandler()
        set_exception_handler([$this, 'exceptionHandler']);
    }

    /**
     * метод обрабатывает перехваченные исключения
     */
    public function exceptionHandler($e) {
        //вызываем метод logErrors(), который запишет ошибку в log. Мы обращаемся к объекту выброшенного исключения(getMessage(), getFile(), getLine() - это методы объекта исключений)
        $this->logErrors($e->getMessage(), $e->getFile(), $e->getLine());

        //выводим ошибку
        $this->displayError('Исключение', $e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode());
    }

    /**
     * метод для логирования ошибок.
     * $message - сообщение об ошибке.
     * $file - файл, в котором произошла ошибка.
     * $line - строка, в которой произошла ошибка
     */
    protected function logErrors($message = '', $file = '', $line = ''){
        error_log("[" . date('Y-m-d H:i:s') ."] Текст ошибки: {$message} | Файл: {$file} | Строка: {$line}\n====================\n", 3, ROOT . '/tmp/errors.log'); //3-запись ошибки в файл errors.log (если 2- то отправляется по емайл)
    }

    /**
     * метод для вывода ошибок.
     * $errno - номер ошибки,
     * $errstr - текст ошибки,
     * $errfile - файл ошибки,
     * $errline - строка ошибки
     * $responce - http код, который мы отправляем браузеру(по умолчанию - 404)
     */
    protected function displayError($errno, $errstr, $errfile, $errline, $responce = 404){
        http_response_code($responce);//отправляем заголовок

        //подключаем некий шаблон по условию, если код ответа=404 и выключен показ ошибок(DEBUG выставлена в 0), дабы видеть полный текст ошибки во время разработки
        if($responce == 404 && !DEBUG){
            require WWW . '/errors/404.php';
            die;
        }
        if(DEBUG){
            require WWW . '/errors/dev.php';//если DEBUG=1, то подключаем dev.php
        }else{
            require WWW . '/errors/prod.php';//если DEBUG=0, то подключаем prod.php
        }
        die;
    }

}