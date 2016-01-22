<?php

namespace App\Fields\Types;

use App\Fields\Types\Parameters\Column;
use Closure;

abstract class Type
{
    use Column;
    const CREATE_MODE = 0;
    const EIDT_MODE = 1;
    protected $mode = 0;
    protected $id = null;
    protected $label = 'New Label';
    protected $form_label = '';
    protected $list_label = '';
    protected $name = null;
    protected $default = null;
    protected $value = null;
    protected $listable = true;
    protected $sortable = false;
    protected $editable = true;
    protected $is_required = false;
    protected $is_index = false;
    protected $rules = [];
    protected $customize_rules = [];
    protected $list_content = null;
    public function __construct($params)
    {
        foreach ($params as $name => $value) {
            $setter = 'set'.studly_case($name);
            $property = snake_case($name);
            if (method_exists($this, $setter)) {
                $this->$setter($value);
            } elseif (property_exists($this, $property)) {
                $this->$property = $value;
            }
        }
    }
    public function setMode($mode)
    {
        $this->mode = $mode === self::CREATE_MODE ? self::CREATE_MODE : self::EIDT_MODE;
    }
    public function isCreateMode()
    {
        return $this->mode === self::CREATE_MODE;
    }
    public function isEditMode()
    {
        return $this->mode === self::EIDT_MODE;
    }
    public function setName($name)
    {
        if (empty($this->name)) {
            $this->name = $name;
        }

        return $this;
    }
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }
    public function setDefault($default)
    {
        $this->value = $default;

        return $this;
    }
    public function setIndex($is_index = true)
    {
        $this->is_index = $is_index || false;

        return $this;
    }
    public function setRequired($is_required = true)
    {
        $this->is_required = $is_required || false;

        return $this;
    }
    public function setEditable($editable)
    {
        $this->editable = $editable !== false;

        return $this;
    }
    public function setRules(array $rules = [])
    {
        $this->rules = array_merge($this->rules, $rules);
    }
    public function setContent(Closure $closure)
    {
        $this->getContent = $closure;
    }
    public function isIndex()
    {
        return $this->is_index;
    }
    public function isRequired()
    {
        return in_array('required', $this->rules);
    }
    public function isEditable($allow_empty = true)
    {
        $editable = !($this->isEditMode() && !$this->editable());
        if (empty($this->value)) {
            $editable = true;
        }

        return $editable;
    }
    public function getFormLabel()
    {
        $label = $this->label;
        if (!empty($this->form_label)) {
            $label = $this->form_label;
        }

        return $label;
    }
    public function getListLabel()
    {
        $label = $this->label;
        if (!empty($this->list_label)) {
            $label = $this->list_label;
        }

        return $label;
    }
    public function getRules()
    {
        return $this->rules;
    }
    public function __get($name)
    {
        $key = $name;
        $getter = 'get'.studly_case($name);
        if (method_exists($this, $getter)) {
            return $this->$getter();
        } elseif (isset($this->$key)) {
            return $this->$key;
        } else {
            return;
        }
    }
    public function __call($name, $arguments)
    {
        $key = snake_case($name);
        if (isset($this->$key)) {
            return $this->$key;
        } else {
            return;
        }
    }
    abstract public function getContent();
    abstract public function getFormHtml();
}
