<?php

namespace App\Core\Pickers;

use Jsadways\LaravelSDK\Http\Validation\Unit\Operator;

class MeditationCreatePicker extends BasePicker
{
    public function get_create_relations(): array
    {
        $meditation_category = $this->_make_validation_relation(
            relation: 'meditation_category_list',
            operator_list: [
                new Operator(option: 'create', ignore: ['id', 'meditation_id'])
            ]
        );

        return [$meditation_category];
    }
}
