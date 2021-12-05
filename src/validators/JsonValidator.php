<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\validators;


use yii\validators\Validator;

/**
 * yii-validator扩展验证数据类型为json字符串
 *
 * Class JsonValidator
 * @package YiiHelper\validators
 */
class JsonValidator extends Validator
{
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        if (null === $this->message) {
            $this->message = \Yii::t('yii', '{attribute} 必须是有效的json字符串');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function validateValue($value)
    {
        return is_json($value) ? null : [$this->message, []];
    }
}