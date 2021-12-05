<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\validators;


use yii\validators\RegularExpressionValidator;

/**
 * yii-validator扩展验证数据是否是姓名
 *
 * Class NameValidator
 * @package YiiHelper\validators
 */
class NameValidator extends RegularExpressionValidator
{
    /**
     * @var string the regular expression to be matched with
     * 中文开头 + [中文|.] + 中文结束[ + 数字]
     */
    public $pattern = '/^[\x{4e00}-\x{9fa5}]([\x{4e00}-\x{9fa5}\.]{0,8})?[\x{4e00}-\x{9fa5}]?\d*$/u';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        if (null === $this->message) {
            $this->message = \Yii::t('yii', '{attribute} 不是有效的姓名');
        }

        parent::init();
    }
}