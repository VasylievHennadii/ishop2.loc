<?php 

namespace app\controllers\admin;


/**
 * главный контроллер Admin
 */

class MainController extends AppController{

    public function indexAction(){
        $this->setMeta('Панель управления');
    }

}



?>