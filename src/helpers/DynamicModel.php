<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\helpers;


use yii\base\InvalidConfigException;
use yii\base\UnknownPropertyException;
use yii\helpers\ArrayHelper;
use yii\validators\Validator;

/**
 * 动态数据验证模型
 *
 * Class DynamicModel
 * @package YiiHelper\helpers
 */
class DynamicModel extends \yii\base\DynamicModel
{
    /**
     * @var array 保存验证规则字段的值
     */
    public $values = [];

    /**
     * 根据动态给定规则验证数据
     *
     * @param array $data
     * @param array $rules
     * @return $this
     * @throws InvalidConfigException
     */
    public static function validateData(array $data, $rules = [])
    {
        $model  = new static($data);
        $values = $labels = [];
        if (!empty($rules)) {
            $validators = $model->getValidators();
            foreach ($rules as $rule) {
                if ($rule instanceof Validator) {
                    $validators->append($rule);
                } elseif (is_array($rule) && isset($rule[0], $rule[1])) { // attributes, validator type
                    $fields = (array)$rule[0];
                    self::getLabelValue($data, $fields, $rule, $values, $labels);
                    $validator = Validator::createValidator($rule[1], $model, $fields, array_slice($rule, 2));
                    $validators->append($validator);
                } else {
                    throw new InvalidConfigException('Invalid validation rule: a rule must specify both attribute names and validator type.');
                }
            }
        }
        $model->setAttributeLabels($labels);
        $model->validate();
        $model->values = $values;
        return $model;
    }

    /**
     * 获取规则中的label，提取数据中的规则字段值，若无，则返回规则中的default或null
     *
     * @param array $data
     * @param array $names
     * @param array $rule
     * @param array $values
     * @param array $labels
     */
    protected static function getLabelValue(array $data, array $names, array &$rule, array &$values, array &$labels)
    {
        foreach ($names as $name) {
            // label 获取
            if (isset($rule['label'])) {
                $labels[$name] = $rule['label'];
                unset($rule['label']);
            }
            // defaultValue 获取
            if (isset($rule['default'])) {
                if (false !== strpos($name, '.')) {
                    list($prefix, $key) = explode('.', $name, 2);
                    $values[$prefix][$key] = isset($data[$prefix][$key]) ? $data[$prefix][$key] : $rule['default'];
                } else {
                    $values[$name] = isset($data[$name]) ? $data[$name] : $rule['default'];
                }
            } else {
                if (false !== strpos($name, '.')) {
                    list($prefix, $key) = explode('.', $name, 2);
                    $values[$prefix][$key] = isset($data[$prefix][$key]) ? $data[$prefix][$key] : null;
                } else {
                    $values[$name] = isset($data[$name]) ? $data[$name] : null;
                }
            }
            unset($rule['default']);
        }
    }

    /**
     * 增加魔术方法中，数组用键"."的方式获取。eg：people.name 实际访问的是 [people][name]
     *
     * @param string $name
     * @return mixed|null
     * @throws \Exception
     */
    public function __get($name)
    {
        try {
            if (false !== strpos($name, '.')) {
                list($prefix, $key) = explode('.', $name, 2);
                $data = $this->{$prefix};

                if (!is_array($data)) {
                    throw new UnknownPropertyException('获取的"' . get_class($this) . '->' . $prefix . '"不是数组');
                }
                return ArrayHelper::getValue($data, $key);
            } else {
                return parent::__get($name);
            }
        }
        catch (UnknownPropertyException $e) {
            return null;
        }
    }

    /**
     * 增加魔术方法中，数组用键"."的方式设置
     *
     * @param string $name
     * @param mixed $value
     * @return mixed|void|null
     * @throws UnknownPropertyException
     */
    public function __set($name, $value)
    {
        if (false !== strpos($name, '.')) {
            list($prefix, $key) = explode('.', $name, 2);

            if (null === $this->{$prefix}) {
                $this->{$prefix} = [];
            }
            $data = $this->{$prefix};
            if (!is_array($data)) {
                throw new UnknownPropertyException('设置的"' . get_class($this) . '->' . $prefix . '"不是数组');
            }
            ArrayHelper::setValue($data, $key, $value);
            $this->{$prefix} = $data;
        } else {
            parent::__set($name, $value);
        }
    }

    /**
     * 获取属性标签
     *
     * @param string $attribute
     * @return string
     */
    public function getAttributeLabel($attribute)
    {
        $labels = $this->attributeLabels();
        if (isset($labels[$attribute])) {
            return $labels[$attribute];
        }

        if (false !== strpos($attribute, '.')) {
            list($prefix, $key) = explode('.', $attribute, 2);
            if (isset($labels[$prefix][$key])) {
                return $labels[$prefix][$key];
            }
        }
        return parent::getAttributeLabel($attribute);
    }

    /**
     * 获取验证失败信息
     *
     * @param null|string $attribute
     * @return array
     */
    public function getErrors($attribute = null)
    {
        $errors = parent::getErrors();
        if (0 === count($errors)) {
            return [];
        }
        if (null === $attribute) {
            return $errors;
        }
        if (isset($errors[$attribute])) {
            return $errors[$attribute];
        }

        foreach ($errors as $attr => $error) {
            if (false === ($pos = strpos($attr, '.'))) {
                continue;
            }
            $prefix = substr($attr, 0, $pos);
            if ($prefix == $attribute) {
                return $error;
            }
        }
        return [];
    }

    /**
     * 判断[属性]是否含有错误验证信息
     *
     * @param null|string $attribute
     * @return bool
     */
    public function hasErrors($attribute = null)
    {
        $errors = parent::getErrors();
        if (0 === count($errors)) {
            return false;
        }
        if (null === $attribute) {
            return !empty($errors);
        }
        if (isset($errors[$attribute])) {
            return true;
        }
        foreach ($errors as $attr => $error) {
            if (false === ($pos = strpos($attr, '.'))) {
                continue;
            }
            $prefix = substr($attr, 0, $pos);
            if ($prefix == $attribute) {
                return true;
            }
        }
        return false;
    }
}