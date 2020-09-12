<?php  

namespace app\models\admin;

use app\models\AppModel;

/**
 * модель для работы с валютами в Admin
 */
class Currency extends AppModel {

    public $attributes = [
        'title' => '',
        'code' => '',
        'symbol_left' => '',
        'symbol_right' => '',
        'value' => '',
        'base' => '',
    ];

    public $rules = [
        'required' => [
            ['title'],
            ['code'],
            ['value'],
        ],
        'numeric' => [
            ['value'],
        ],
    ];

}




?>