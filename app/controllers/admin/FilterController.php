<?php  

namespace app\controllers\admin;

use app\models\admin\FilterGroup;

/**
 * контроллер для работы с фильтрами из Admin
 */
class FilterController extends AppController {

    /**
     * метод для удаления групп фильтров
     */
    public function groupDeleteAction(){
        $id = $this->getRequestID();
        $count = \R::count('attribute_value', 'attr_group_id = ?', [$id]);
        if($count){
            $_SESSION['error'] = 'Удаление невозможно, в группе есть атрибуты';
            redirect();
        }
        \R::exec('DELETE FROM attribute_group WHERE id = ?', [$id]);
        $_SESSION['success'] = 'Удалено';
        redirect();
    }

    /**
     * метод для добавления групп фильтров
     */
    public function groupAddAction(){
        if(!empty($_POST)){
            $group = new FilterGroup();
            $data = $_POST;
            $group->load($data);
            if(!$group->validate($data)){
                $group->getErrors();
                redirect();
            }
            if($group->save('attribute_group', false)){
                $_SESSION['success'] = 'Группа добавлена';
                redirect();
            }
        }
        $this->setMeta('Новая группа фильтров');
    }

    /**
     * метод отвечает за работу с группами фильтров
     */
    public function attributeGroupAction(){
        $attrs_group = \R::findAll('attribute_group');
        $this->setMeta('Группы фильтров');
        $this->set(compact('attrs_group'));
    }

    /**
     * метод отвечает за работу с атрибутами фильтров
     */
    public function attributeAction(){

    }

}











?>