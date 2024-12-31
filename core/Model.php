<?php

namespace app\core;

abstract class Model extends DBModel
{
    protected const RULE_REQUIRED = 'required';
    protected const RULE_EMAIL = 'email';
    protected const RULE_MIN = 'min';
    protected const RULE_MAX = 'max';
    protected const RULE_MATCH = 'match';

    private $errors = [];

    protected static $MESSAGE = [
        self::RULE_REQUIRED => 'Value is required',
        self::RULE_MIN => 'Value should be greater than {min}'
    ];

    public function loadData(array $data)
    {
        foreach ($data as $key=>$value)
        {
            if(property_exists($this, $key)){
                $this->{$key} = $value;
            }
        }
    }

    public function validate()
    {
        foreach ($this->rules() as $attribute=>$rules)
        {
            foreach ($rules as $rule)
            {
                $ruleName = $rule;
                $ruleValue = null;

                if(strpos($rule, ':')){
                    list($ruleName, $ruleValue) = explode(':', $rule);
                }
                $propertyValue = $this->{$attribute};

                switch($ruleName) {
                    case self::RULE_REQUIRED:
                        if($propertyValue == null || $propertyValue == ''){
                            $this->errors[$attribute][] = $this->getValidationMessage(self::RULE_REQUIRED);
                        }
                        break;
                    case self::RULE_MIN:
                        if(strlen($propertyValue) < $ruleValue){
                            $this->errors[$attribute][] = str_replace('{min}', ''.$ruleValue, $this->getValidationMessage(self::RULE_MIN));
                        }
                    case self::RULE_EMAIL:
                        if (!filter_var($propertyValue, FILTER_VALIDATE_EMAIL)) {
                            $this->errors[$attribute][] = "Email is invalid";
                        }
                        break;
                    default:
                        break;
                }
            }
        }

        return count($this->errors) > 0 ? $this->errors: true;
    }

    public function setValidationMessage($attribute, $message)
    {
        self::$MESSAGE[$attribute] = $message;
    }

    public function getValidationMessage($attribute)
    {
        return self::$MESSAGE[$attribute];
    }

    protected function hasError(string $attribute)
    {
         return array_key_exists($attribute, $this->errors) ? true:false;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getFirstError(string $attribute)
    {
        return $this->hasError($attribute) ? $this->getErrors()[$attribute][0] : '';
    }
}
