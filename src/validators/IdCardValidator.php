<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\validators;


use yii\validators\RegularExpressionValidator;

/**
 * yii-validator扩展验证数据是否是身份证号码
 *
 * Class IdCardValidator
 * @package YiiHelper\validators
 */
class IdCardValidator extends RegularExpressionValidator
{
    /**
     * @var string the regular expression to be matched with
     */
    public $pattern = '/(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        if (null === $this->message) {
            $this->message = \Yii::t('yii', '{attribute} 不是有效的身份证号');
        }

        parent::init();
    }
}