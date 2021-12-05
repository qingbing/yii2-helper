<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\validators;


use yii\validators\RegularExpressionValidator;

/**
 * yii-validator扩展验证数据是否是座机号码
 *
 * Class PhoneValidator
 * @package YiiHelper\validators
 */
class PhoneValidator extends RegularExpressionValidator
{
    /**
     * @var string the regular expression to be matched with
     */
    public $pattern = '/^0[1-9]\d{1,2}-[1-9]\d{6,7}(-\d{1,4})?$/';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        if (null === $this->message) {
            $this->message = \Yii::t('yii', '{attribute} 不是有效的座机号码');
        }

        parent::init();
    }
}