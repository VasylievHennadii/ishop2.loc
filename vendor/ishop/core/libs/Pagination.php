<?php 

namespace ishop\libs;

/**
 * класс пагинации
 */
class Pagination {

    /**
     * текущая страница
     */
    public $currentPage;

    /**
     * количество записей товара на странице
     */
    public $perpage;

    /**
     * общее количество записей товара(получаем из БД)
     */
    public $total;

    /**
     * общее количество страниц, зависит от $perpage и $total
     */
    public $countPages;
    
    public $uri;    


    public function __construct($page, $perpage, $total){
        $this->perpage = $perpage;
        $this->total = $total;
        $this->countPages = $this->getCountPages();
        $this->currentPage = $this->getCurrentPage($page);
        $this->uri = $this->getParams();
    }


    /**
     * метод формирует пагинацию
     */
    public function getHtml(){
        $back = null; // ссылка НАЗАД
        $forward = null; // ссылка ВПЕРЕД
        $startpage = null; // ссылка В НАЧАЛО
        $endpage = null; // ссылка В КОНЕЦ
        $page2left = null; // вторая страница слева
        $page1left = null; // первая страница слева
        $page2right = null; // вторая страница справа
        $page1right = null; // первая страница справа

        //переход на одну страницу назад
        if( $this->currentPage > 1 ){
            $back = "<li><a class='nav-link' href='{$this->uri}page=" .($this->currentPage - 1). "'>&lt;</a></li>";
        }
        //переход на одну страницу вперед
        if( $this->currentPage < $this->countPages ){
            $forward = "<li><a class='nav-link' href='{$this->uri}page=" .($this->currentPage + 1). "'>&gt;</a></li>";
        }
        //перход в начало
        if( $this->currentPage > 3 ){
            $startpage = "<li><a class='nav-link' href='{$this->uri}page=1'>&laquo;</a></li>";
        }
        //переход в конец
        if( $this->currentPage < ($this->countPages - 2) ){
            $endpage = "<li><a class='nav-link' href='{$this->uri}page={$this->countPages}'>&raquo;</a></li>";
        }
        if( $this->currentPage - 2 > 0 ){
            $page2left = "<li><a class='nav-link' href='{$this->uri}page=" .($this->currentPage-2). "'>" .($this->currentPage - 2). "</a></li>";
        }
        if( $this->currentPage - 1 > 0 ){
            $page1left = "<li><a class='nav-link' href='{$this->uri}page=" .($this->currentPage-1). "'>" .($this->currentPage-1). "</a></li>";
        }
        if( $this->currentPage + 1 <= $this->countPages ){
            $page1right = "<li><a class='nav-link' href='{$this->uri}page=" .($this->currentPage + 1). "'>" .($this->currentPage+1). "</a></li>";
        }
        if( $this->currentPage + 2 <= $this->countPages ){
            $page2right = "<li><a class='nav-link' href='{$this->uri}page=" .($this->currentPage + 2). "'>" .($this->currentPage + 2). "</a></li>";
        }

        return '<ul class="pagination">' . $startpage.$back.$page2left.$page1left.'<li class="active"><a>'.$this->currentPage.'</a></li>'.$page1right.$page2right.$forward.$endpage . '</ul>';
    }


    /**
     * метод переводит объект к строке
     */
    public function __toString(){
        return $this->getHtml();
    }


    /**
     * метод получает общее кол-во страниц
     */
    public function getCountPages(){
        return ceil($this->total / $this->perpage) ?: 1;
    }


    /**
     * метод получает текущую страницу
     */
    public function getCurrentPage($page){
        //если пользователь вводит несуществующий номер страницы(отрицательный или больше максимума), мы задаем соответственно либо $page = 1, либо номер последней страницы
        if(!$page || $page < 1) $page = 1;
        if($page > $this->countPages) $page = $this->countPages;
        return $page;
    }


    /**
     * метод вычисляет номер нужной страницы, с учетом общего количества записей и количества записей на странице
     */
    public function getStart(){
        return ($this->currentPage -1) * $this->perpage;
    }


    /**
     * метод получает $uri без параметра page=
     */
    public function getParams(){
        $url = $_SERVER['REQUEST_URI']; // "/category/men?page=2&sort=name"
        $url = explode('?', $url); //  Array ([0] => /category/men  [1] => page=2&sort=name)
        $uri = $url[0] . '?'; //  "/category/men?"
        if(isset($url[1]) && $url[1] != ''){
            $params = explode('&', $url[1]); // Array ([0] => page=2  [1] => sort=name)
            foreach($params as $param){
                if(!preg_match("#page=#", $param)) $uri .= "{$param}&amp;"; //  "/category/men?sort=name&"
            }
        }        
        return urldecode($uri); // urldecode() - декодирование URL-кодированной строки
    }


}




?>