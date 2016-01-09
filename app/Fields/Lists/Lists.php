<?php

namespace App\Fields\Lists;

use Field;

trait Lists
{
    public function getList($per_page = 10)
    {
        $columns = [];
        foreach ($this->_fields as $key => $field) {
            if ($field->listable) {
                $columns[$key] = $field->getListLabel();
            }
        }
        $model_name = $this->GetName();
        $pagination = Field::storage($model_name)
            ->getList($per_page);
//            $collection = $pagination->getCollection();
        $collection = $pagination->hack_items;
        $rows = collect();
        $rows = $collection->map(function ($item) use ($model_name) {
            $row = new $this($item->toArray());
            $row->links = (object) [
                'edit_form' => route('model_edit', [
                    'model_name' => $model_name,
                    'id' => $row->_id,
                ]),
                'remove' => '',
            ];

            return $row;
        });

        return view('fields.list', [
            'admin_name' => $this->getAdminName(),
            'admin_description' => $this->getAdminDescription(),
            'model_name' => $model_name,
            'columns' => $columns,
            'rows' => $rows,
            'pagination' => $pagination,
            'links' => (object) [
                'create_form' => route('model_create', [
                    'model_name' => $model_name,
                ]),
            ],
        ]);
    }
}
