<?php

namespace App\Fields;

use App\Fields\Types\Type as Type;
use App\Fields\Form\Form as Form;
use App\Fields\Lists\Lists as Lists;
use App\Fields\Traits\TraitData as Data;
use Illuminate\Support\MessageBag as MessageBag;

class Model
{
    use Lists,
        Form,
        Data;
    protected $name = '';
    protected $admin_name = '';
    protected $admin_description = '';
    protected $fields = [];
    protected $values = [];
    protected $extras = [];
    protected $errors = null;
    public static $menu_available = true;
    public function __construct(array $data = [])
    {
        $this->register();
        $class_name = class_basename(get_class($this));
        $this->name = strtolower(snake_case($class_name));
        $this->errors = new MessageBag();
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                if (isset($this->fields[$key])) {
                    $this->fields[$key]->setValue($value);
                    $this->values[$key] = $value;
                } else {
                    $this->extras[$key] = $value;
                }
            }
        }
    }
    protected function register()
    {
    }
    protected function add($key, Type $type)
    {
        $this->fields[$key] = $type;
        return $this;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getAdminName()
    {
        if (empty($this->admin_name)) {
            $this->admin_name = strtr(':name Management', [
                ':name' => studly_case($this->name),
            ]);
        }

        return $this->admin_name;
    }
    public function getAdminDescription()
    {
        return $this->admin_description;
    }
    protected function addError($message)
    {
        $this->errors->add('key', $message);
    }
    protected function setErrors(MessageBag $message_bag)
    {
        $this->errors = $message_bag;
    }
    public function getErrors()
    {
        return $this->errors;
    }
    public function hasError()
    {
        return !$this->errors->isEmpty();
    }
    public function __get($key)
    {
        if (isset($this->fields[$key])) {
            return $this->fields[$key];
        } elseif (isset($this->extras[$key])) {
            return $this->extras[$key];
        }

        return;
    }
    public function __set($key, $value)
    {
        if (isset($this->fields[$key])) {
            $this->values[$key] = $value;
        } else {
            $this->extras[$key] = $value;
        }
    }
}
