<?php

namespace App\Podm\Traits;

use Podm;
use RepositoryFactory;
use Request;

trait TraitList
{
    protected $list_actions = [];
    public function getListHtml($per_page = 10)
    {
        $columns = [];
        foreach ($this->fields as $key => $field) {
            if ($field->listable) {
                $columns[$key] = $field->getListLabel();
            }
        }
        $search = Request::get('search', '');
        $model_name = $this->getName();
        $repository = RepositoryFactory::create('Podm\Podm');
        $pagination = $repository->getList($model_name, $search, $per_page);
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

        return view('PodmView::model.list', [
            'admin_name' => $this->getAdminName(),
            'admin_description' => $this->getAdminDescription(),
            'model_name' => $model_name,
            'columns' => $columns,
            'actions' => $this->list_actions,
            'rows' => $rows,
            'pagination' => $pagination,
            'links' => (object) [
                'create_form' => route('model_create', [
                    'model_name' => $model_name,
                ]),
            ],
        ]);
    }
    protected function addListAction(array $params)
    {
        $this->list_actions[] = $params;

        return $this;
    }
}
