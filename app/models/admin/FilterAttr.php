<?php 

namespace app\models\admin;

use app\models\AppModel;

/**
 * модель для работы с атрибутами фильтров из Admin
 */
class FilterAttr extends AppModel {

    public $attributes = [
        'value' => '',
        'attr_group_id' => '',
    ];

    public $rules = [
        'required' => [
            ['value'],
            ['attr_group_id'],
        ],
        'integer' => [
            ['attr_group_id'],
        ],
    ];

}



?>