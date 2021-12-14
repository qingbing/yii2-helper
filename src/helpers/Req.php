<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\helpers;


use Yii;
use Zf\Helper\DataStore;

/**
 * 请求助手
 *
 * Class Req
 * @package YiiHelper\helpers
 */
class Req
{
    const USER_IP_KEY        = __CLASS__ . ":client-ip";
    const USER_HOST_INFO_KEY = __CLASS__ . ":host-info";
    const ACCESS_IP_KEY      = __CLASS__ . ":access-ip";
    const IS_GUEST_KEY       = __CLASS__ . ':isGuest';
    const LOGIN_UID_KEY      = __CLASS__ . ':loginUid';
    const IS_SUPER_KEY       = __CLASS__ . ':isSuper';

    /**
     * 获取客户端IP
     * @return mixed|null
     */
    public static function getUserIp()
    {
        return DataStore::get(self::USER_IP_KEY, function () {
            return Yii::$app->getRequest()->getUserIP();
        });
    }

    /**
     * 获取直接访问的IP(refer-client-ip)
     *
     * @return mixed|null
     */
    public static function getUserHostInfo()
    {
        return DataStore::get(self::USER_HOST_INFO_KEY, function () {
            if (Yii::$app->getRequest()->getHeaders()->has('x-portal-host-info')) {
                return Yii::$app->getRequest()->getHeaders()->get('x-portal-host-info');
            }
            return Yii::$app->getRequest()->getHostInfo();
        });
    }

    /**
     * 获取直接访问的IP(refer-client-ip)
     *
     * @return mixed|null
     */
    public static function getAccessIp()
    {
        return DataStore::get(self::ACCESS_IP_KEY, function () {
            if (isset($_SERVER['REMOTE_ADDR'])) {
                return $_SERVER['REMOTE_ADDR'];
            }
            return Yii::$app->getRequest()->getUserIP();
        });
    }

    /**
     * 获取当前是否登录
     *
     * @return mixed|null
     */
    public static function getIsGuest()
    {
        return DataStore::get(self::IS_GUEST_KEY, function () {
            if (Yii::$app->getRequest()->getHeaders()->has('x-portal-is-guest')) {
                return Yii::$app->getRequest()->getHeaders()->get('x-portal-is-guest');
            }
            return Yii::$app->getUser()->getIsGuest();
        });
    }

    /**
     * 获取当前登录用户id
     *
     * @return mixed|null
     */
    public static function getUid()
    {
        return DataStore::get(self::LOGIN_UID_KEY, function () {
            if (Yii::$app->getRequest()->getHeaders()->has('x-portal-uid')) {
                return Yii::$app->getRequest()->getHeaders()->get('x-portal-uid');
            }
            return Yii::$app->getUser()->getIsGuest() ? 0 : Yii::$app->getUser()->getId();
        });
    }

    /**
     * 获取登录用户是否超管
     *
     * @return mixed|null
     */
    public static function getIsSuper()
    {
        return DataStore::get(self::IS_SUPER_KEY, function () {
            if (Yii::$app->getRequest()->getHeaders()->has('x-portal-is-super')) {
                return Yii::$app->getRequest()->getHeaders()->get('x-portal-is-super');
            }
            $userComponent = Yii::$app->getUser();
            if (method_exists($userComponent, 'getIsSuper')) {
                return $userComponent->getIsSuper();
            }
            return false;
        });
    }
}