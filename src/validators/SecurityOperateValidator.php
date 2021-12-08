<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\validators;


use Yii;
use yii\validators\Validator;
use Zf\Helper\Exceptions\ForbiddenHttpException;
use Zf\Helper\Exceptions\ProgramException;

/**
 * 安全操作验证，需要用户输入安全密码
 *
 * Class SecurityOperateValidator
 * @package YiiHelper\validators
 */
class SecurityOperateValidator extends Validator
{
    /**
     * @var callable 验证回调函数，返回 bool，优先级高于 method
     */
    public $callable;
    /**
     * @var string 用户模型方法验证
     */
    public $method = 'validateSecurityPassword';

    /**
     * {@inheritdoc}
     *
     * @throws ForbiddenHttpException
     */
    public function init()
    {
        parent::init();

        if (null === $this->message) {
            $this->message = Yii::t('yii', '{attribute}不正确');
        }

        if (Yii::$app->getUser()->getIsGuest()) {
            throw new ForbiddenHttpException("您无权操作，请先登录");
        }
    }

    /**
     * {@inheritdoc}
     *
     * @param mixed $value
     * @return array|null|void
     * @throws \Throwable
     */
    public function validateValue($value)
    {
        $user = Yii::$app->getUser()->getIdentity();
        if (is_callable($this->callable)) {
            $res = call_user_func_array($this->callable, [$user, $value]);
        } elseif (method_exists($user, $this->method)) {
            $res = call_user_func_array([$user, $this->method], [$value]);
        } else {
            throw new ProgramException('安全操作密码未指定验证器');
        }
        if (!$res) {
            return [$this->message, []];
        }
    }
}