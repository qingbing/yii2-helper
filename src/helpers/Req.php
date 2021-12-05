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
    const USER_IP_KEY   = __CLASS__ . ":client-ip";
    const ACCESS_IP_KEY = __CLASS__ . ":access-ip";
    const IS_GUEST_KEY  = __CLASS__ . ':isGuest';
    const LOGIN_UID_KEY = __CLASS__ . ':loginUid';

    /**
     * 获取客户端 IP
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
     * 设置当前是否登录
     *
     * @param bool $isGuest
     */
    public static function setIsGuest($isGuest)
    {
        DataStore::set(self::IS_GUEST_KEY, $isGuest);
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
     * 设置当前登录用户id
     *
     * @param mixed $uid
     */
    public static function setUid($uid)
    {
        DataStore::set(self::LOGIN_UID_KEY, $uid);
    }
}