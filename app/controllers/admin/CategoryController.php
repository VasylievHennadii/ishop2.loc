<?php 

namespace app\controllers\admin;

use app\models\AppModel;
use app\models\Category;

class CategoryController extends AppController {

    public function indexAction(){
        $this->setMeta('Список категорий');
    }

    /**
     * метод удаления категорий
     */
    public function deleteAction(){
        $id = $this->getRequestID();
        $children = \R::count('category', 'parent_id = ?', [$id]);
        $errors = '';
        if($children){
            $errors .= '<li>Удаление невозможно, в категории есть вложенные категории</li>';
        }
        $products = \R::count('product', 'category_id = ?', [$id]);
        if($products){
            $errors .= '<li>Удаление невозможно, в категории есть товары</li>';
        }
        if($errors){
            $_SESSION['error'] = "<ul>$errors</ul>";
            redirect();
        }
        $category = \R::load('category', $id);//получаем данную категорию для удаления
        \R::trash($category); //удаляем эту категорию
        $_SESSION['success'] = 'Категория удалена';
        redirect();
    }

    /**
     * метод добавления категорий
     */
    public function addAction(){
        if(!empty($_POST)){
            $category = new Category();
            $data = $_POST;
            $category->load($data);
            if(!$category->validate($data)){
                $category->getErrors();
                redirect();
            }
            if($id = $category->save('category')){
                $alias = AppModel::createAlias('category', 'alias', $data['title'], $id);
                $cat = \R::load('category', $id);
                $cat->alias = $alias;
                \R::store($cat);
                $_SESSION['success'] = 'Категория добавлена';
            }
            redirect();
        }
        $this->setMeta('Новая категория');
    }

}



?>