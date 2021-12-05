<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\traits;


use Yii;
use Zf\Helper\Exceptions\CustomException;

/**
 * 判断 : 用户登录状态判断
 *
 * Trait TLoginRequired
 * @package YiiHelper\traits
 */
trait TLoginRequired
{
    /**
     * 确保访问必须是登录状态
     *
     * @throws CustomException
     */
    protected static function loginRequired()
    {
        if (Yii::$app->user->getIsGuest()) {
            throw new CustomException("您无权访问该接口，请先登录");
        }
    }

    /**
     * 判断给出的用户ID是否是当前登录用户
     *
     * @param int $uid
     * @return bool
     */
    protected static function isLoginUser($uid)
    {
        if (Yii::$app->user->getIsGuest()) {
            return false;
        }
        return Yii::$app->user->getId() == $uid;
    }
}