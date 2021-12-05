<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\proxy;

use YiiHelper\proxy\base\InnerProxy;

/**
 * 系统代理 : portal 代理
 *
 * Class PortalProxy
 * @package YiiHelper\proxy
 */
class PortalProxy extends InnerProxy
{
    const URL_SYSTEM_OPTIONS = '/inner/options/system'; // 系统代码选项
    const URL_USER_INFO      = '/inner/user/info'; // 获取用户信息

    /**
     * 获取系统代码选项
     *
     * @return \yii\httpclient\Response
     * @throws \Exception
     */
    public function systemOptions()
    {
        return $this->send(self::URL_SYSTEM_OPTIONS);
    }

    /**
     * 通过uid获取用户信息
     *
     * @param string $uid
     * @return \yii\httpclient\Response
     * @throws \Exception
     */
    public function userInfo($uid)
    {
        return $this->send(self::URL_USER_INFO, [
            'uid' => $uid,
        ]);
    }
}