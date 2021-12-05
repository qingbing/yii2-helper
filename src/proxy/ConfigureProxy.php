<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\proxy;

use YiiHelper\proxy\base\InnerProxy;

class ConfigureProxy extends InnerProxy
{
    const URL_TEST = '/inner/test/index';

    public function test()
    {
        return $this->send(self::URL_TEST);
    }
}