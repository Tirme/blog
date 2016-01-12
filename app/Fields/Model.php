<?php

namespace App\Fields;

use App\Fields\Types\Type as Type;
use App\Fields\Form\Form as Form;
use App\Fields\Lists\Lists as Lists;
use Illuminate\Support\MessageBag as MessageBag;

class Model
{
    use Lists,
        Form;
    protected $_name = '';
    protected $_admin_name = '';
    protected $_admin_description = '';
    protected $_fields = [];
    protected $_values = [];
    protected $_extras = [];
    protected $_errors = null;
    public static $_menu_available = true;
    public function __construct(array $data = [])
    {
        $this->_register();
        $class_name = class_basename(get_class($this));
        $this->_name = strtolower(snake_case($class_name));
        $this->_errors = new MessageBag();
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                if (isset($this->_fields[$key])) {
                    $this->_fields[$key]->setValue($value);
                    $this->_values[$key] = $value;
                } else {
                    $this->_extras[$key] = $value;
                }
            }
        }
    }
    protected function _register()
    {
    }
    protected function _add($key, Type $type)
    {
        $this->_fields[$key] = $type;
    }
    public function getName()
    {
        return $this->_name;
    }
    public function getAdminName()
    {
        if (empty($this->_admin_name)) {
            $this->_admin_name = strtr(':name Management', [
                ':name' => studly_case($this->_name),
            ]);
        }

        return $this->_admin_name;
    }
    public function getAdminDescription()
    {
        return $this->_admin_description;
    }
    protected function _addError($message)
    {
        $this->_errors->add('key', $message);
    }
    protected function _setErrors(MessageBag $message_bag)
    {
        $this->_errors = $message_bag;
    }
    public function getErrors()
    {
        return $this->_errors;
    }
    public function hasError()
    {
        return !$this->_errors->isEmpty();
    }
    public function __get($key)
    {
        if (isset($this->_fields[$key])) {
            return $this->_fields[$key];
        } elseif (isset($this->_extras[$key])) {
            return $this->_extras[$key];
        }

        return;
    }
    public function __set($key, $value)
    {
        if (isset($this->_fields[$key])) {
            $this->_values[$key] = $value;
        } else {
            $this->_extras[$key] = $value;
        }
    }
}
