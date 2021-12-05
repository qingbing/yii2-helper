<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\abstracts;

use yii\db\ActiveRecord;
use YiiHelper\traits\TSave;

/**
 * db-model 基类
 *
 * Class Model
 * @package YiiHelper\abstracts
 */
abstract class Model extends ActiveRecord
{
    // 使用 保存片段
    use TSave;

    /**
     * 设置模型数据，过滤 null
     *
     * @param string $name
     * @param mixed $value
     */
    public function setFilterAttribute(string $name, $value)
    {
        if (null !== $value) {
            $this->setAttribute($name, $value);
        }
    }

    /**
     * 批量设置模型数据，过滤 null
     *
     * @param array $values
     * @param bool $safeOnly
     */
    public function setFilterAttributes(array $values, $safeOnly = true)
    {
        $attributes = [];
        foreach ($values as $attribute => $value) {
            if (is_bool($value)) {
                $attributes[$attribute] = (int)$value;
            } else if (null !== $value) {
                $attributes[$attribute] = $value;
            }
        }
        if (count($attributes) > 0) {
            $this->setAttributes($attributes, $safeOnly);
        }
    }

    /**
     * 获取模型属性标签
     *
     * @return array
     */
    public static function getAttributeLabels()
    {
        return (new static())->attributeLabels();
    }
}