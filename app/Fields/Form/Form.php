<?php

namespace App\Fields\Form;

use Validator;
use Field;

trait Form
{
    protected $_form_attributes = [];
    protected function _setFormAttributes(array $attributes)
    {
        $this->_form_attributes = $attributes;
    }
    public function getCreateForm(array $user_values = [])
    {
        $rows = [];
        foreach ($this->_fields as $name => $field) {
            $field->setName($name)
                ->setMode(0);
            if (isset($user_values[$name])) {
                $field->setValue($user_values[$name]);
            } elseif (isset($this->_values[$name])) {
                $field->setValue($this->_values[$name]);
            }
            $rows[$name] = $field;
        }
        $model_name = $this->getName();
        $hash = Field::cryptHash([
            'model_name' => $model_name,
        ]);
        $form = view('FieldsView::create_form', [
            'attributes' => $this->_form_attributes,
            'rows' => $rows,
            'hash' => $hash,
            'links' => (object) [
                'form_action' => route('model_store', [
                    'model_name' => $model_name,
                ]),
                'cancel' => route('model_list', [
                    'model_name' => $model_name,
                ]),
            ],
        ]);

        return $form;
    }
    public function getEditForm(array $user_values = [])
    {
        $rows = [];
        foreach ($this->_fields as $name => $field) {
            $field->setName($name)
                ->setMode(1);
            if (isset($user_values[$name])) {
                $field->setValue($user_values[$name]);
            } elseif (isset($this->_values[$name])) {
                $field->setValue($this->_values[$name]);
            }
            $rows[$name] = $field;
        }
        $model_name = $this->getName();
        $hash = Field::cryptHash([
            '_id' => $this->_id,
            'model_name' => $model_name,
        ]);
        $form = view('FieldsView::edit_form', [
            'attributes' => $this->_form_attributes,
            'rows' => $rows,
            'hash' => $hash,
            'links' => (object) [
                'form_action' => route('model_update', [
                    'model_name' => $model_name,
                ]),
                'cancel' => route('model_list', [
                    'model_name' => $model_name,
                ]),
            ],
        ]);

        return $form;
    }
    public function getRules()
    {
        $rules = [];
        foreach ($this->_fields as $name => $field) {
            $field_rules = $field->getRules();
            if (!empty($field_rules)) {
                $rules[$name] = implode('|', $field_rules);
            }
        }

        return $rules;
    }
    public function create($data)
    {
        $result = false;
        $validator = Validator::make($data, $this->getRules());
        if ($validator->fails()) {
            $this->_setErrors($validator->errors());
        } else {
            $result = Field::storage($this->getName())
                ->insert($data);
        }

        return $result;
    }
    public function update($data)
    {
        $result = false;
        $validator = Validator::make($data, $this->getRules());
        if ($validator->fails()) {
            $this->_setErrors($validator->errors());
        } else {
            $values = [];
            foreach ($this->_fields as $name => $field) {
                if (isset($data[$name]) && $field->isEditable()) {
                    $values[$name] = $data[$name];
                }
            }
            $result = Field::storage($this->getName())
                ->update($this->_id, $values);
        }

        return $result;
    }
}
