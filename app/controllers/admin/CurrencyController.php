<?php  

namespace app\controllers\admin;
use app\models\admin\Currency;

/**
 * контроллер валют в Admin
 */
class CurrencyController extends AppController {

    /**
     * метод для просмотра списка доступных валют в Admin
     */
    public function indexAction(){
        $currencies = \R::findAll('currency');
        $this->setMeta('Валюты магазины');
        $this->set(compact('currencies'));
    }

    /**
     * метод для удаления валют из Admin
     */
    public function deleteAction(){
        $id = $this->getRequestID();
        $currency = \R::load('currency', $id);
        \R::trash($currency);
        $_SESSION['success'] = "Изменения сохранены";
        redirect();
    }

    /**
     * метод для редактирования валют из Admin
     */
    public function editAction(){
        if(!empty($_POST)){
            $id = $this->getRequestID(false);
            $currency = new Currency();
            $data = $_POST;
            $currency->load($data);
            $currency->attributes['base'] = $currency->attributes['base'] ? '1' : '0';
            if(!$currency->validate($data)){
                $currency->getErrors();
                redirect();
            }
            if($currency->update('currency', $id)){
                $_SESSION['success'] = "Изменения сохранены";
                redirect();
            }
        }

        $id = $this->getRequestID();
        $currency = \R::load('currency', $id);
        $this->setMeta("Редактирование валюты {$currency->title}");
        $this->set(compact('currency'));
    }

    /**
     * метод добавления валют из Admin
     */
    public function addAction(){
        if(!empty($_POST)){
            $currency = new Currency();
            $data = $_POST;
            $currency->load($data);
            $currency->attributes['base'] = $currency->attributes['base'] ? '1' : '0';
            if(!$currency->validate($data)){
                $currency->getErrors();
                redirect();
            }
            if($currency->save('currency')){
                $_SESSION['success'] = 'Валюта добавлена';
                redirect();
            }
        }
        $this->setMeta('Новая валюта');
    }

}


?>