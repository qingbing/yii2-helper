<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\validators;


use yii\validators\RegularExpressionValidator;

/**
 * yii-validator扩展验证数据是否是密码格式
 *
 * Class PasswordValidator
 * @package YiiHelper\validators
 */
class PasswordValidator extends RegularExpressionValidator
{
    /**
     * @var string the regular expression to be matched with
     */
    public $pattern = '/(?!^\d+$)(?!^[A-Za-z]+$)(?!^[^A-Za-z0-9]+$)^\S{6,20}$/';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        if (null === $this->message) {
            $this->message = \Yii::t('yii', '{attribute} 必须包含 数字、字母、特殊字符 中至少两种');
        }

        parent::init();
    }
}