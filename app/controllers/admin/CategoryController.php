<?php 

namespace app\controllers\admin;

class CategoryController extends AppController {

    public function indexAction(){
        $this->setMeta('Список категорий');
    }

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

}



?>