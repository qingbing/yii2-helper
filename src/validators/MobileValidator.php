<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\validators;


use yii\validators\RegularExpressionValidator;

/**
 * yii-validator扩展验证数据是否是手机号码
 *
 * Class MobileValidator
 * @package YiiHelper\validators
 */
class MobileValidator extends RegularExpressionValidator
{
    /**
     * @var string the regular expression to be matched with
     */
    public $pattern = '/^((\(\d{2,3}\))|(\d{3}\-))?1(3|4|5|7|8|9)\d{9}$/';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        if (null === $this->message) {
            $this->message = \Yii::t('yii', '{attribute} 不是有效的手机号码');
        }

        parent::init();
    }
}