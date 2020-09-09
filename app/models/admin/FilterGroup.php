<?php 

namespace app\models\admin;

use app\models\AppModel;

/**
 * модель для работы с группами фильтров из Admin
 */
class FilterGroup extends AppModel {

    public $attributes = [
        'title' => '',
    ];

    public $rules = [
        'required' => [
            ['title'],
        ],
    ];

}






?>