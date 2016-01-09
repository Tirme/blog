<?php

namespace App\Fields\Types;

use App\Fields\Types\Parameters\Column;
use Closure;

abstract class Type
{
    use Column;
    const CREATE_MODE = 0;
    const EIDT_MODE = 1;
    protected $_mode = 0;
    protected $_id = null;
    protected $_label = 'New Label';
    protected $_form_label = '';
    protected $_list_label = '';
    protected $_name = null;
    protected $_default = null;
    protected $_value = null;
    protected $_listable = true;
    protected $_sortable = false;
    protected $_editable = true;
    protected $_is_required = false;
    protected $_is_index = false;
    protected $_rules = [];
    protected $_customize_rules = [];
    protected $_getContent = null;
    public function __construct($params)
    {
        foreach ($params as $name => $value) {
            $setter = 'set'.studly_case($name);
            $property = '_'.snake_case($name);
            if (method_exists($this, $setter)) {
                $this->$setter($value);
            } elseif (property_exists($this, $property)) {
                $this->$property = $value;
            }
        }
    }
    public function setMode($mode)
    {
        $this->_mode = $mode === self::CREATE_MODE ? self::CREATE_MODE : self::EIDT_MODE;
    }
    public function isCreateMode()
    {
        return $this->_mode === self::CREATE_MODE;
    }
    public function isEditMode()
    {
        return $this->_mode === self::EIDT_MODE;
    }
    public function setName($name)
    {
        if (empty($this->_name)) {
            $this->_name = $name;
        }

        return $this;
    }
    public function setValue($value)
    {
        $this->_value = $value;

        return $this;
    }
    public function setDefault($default)
    {
        $this->_value = $default;

        return $this;
    }
    public function setIndex($is_index = true)
    {
        $this->_is_index = $is_index || false;

        return $this;
    }
    public function setRequired($is_required = true)
    {
        $this->_is_required = $is_required || false;

        return $this;
    }
    public function setEditable($editable)
    {
        $this->_editable = $editable !== false;

        return $this;
    }
    public function setRules(array $rules = [])
    {
        $this->_rules = array_merge($this->_rules, $rules);
    }
    public function setContent(Closure $closure)
    {
        $this->_getContent = $closure;
    }
    public function isIndex()
    {
        return $this->_is_index;
    }
    public function isRequired()
    {
        return in_array('required', $this->_rules);
    }
    public function isEditable($allow_empty = true)
    {
        $editable = !($this->isEditMode() && !$this->editable());
        if (empty($this->_value)) {
            $editable = true;
        }

        return $editable;
    }
    public function getFormLabel()
    {
        $label = $this->_label;
        if (!empty($this->_form_label)) {
            $label = $this->_form_label;
        }

        return $label;
    }
    public function getListLabel()
    {
        $label = $this->_label;
        if (!empty($this->_list_label)) {
            $label = $this->_list_label;
        }

        return $label;
    }
    public function getRules()
    {
        return $this->_rules;
    }
    public function __get($name)
    {
        $key = '_'.$name;
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
        $key = '_'.snake_case($name);
        if (isset($this->$key)) {
            return $this->$key;
        } else {
            return;
        }
    }
    abstract public function getContent();
    abstract public function getFormHtml();
}
