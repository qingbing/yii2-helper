<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\proxy;

use YiiHelper\proxy\base\InnerProxy;
use Zf\Helper\DataStore;

/**
 * 系统代理: 配置系统代理
 *
 * Class ConfigureProxy
 * @package YiiHelper\proxy
 */
class ConfigureProxy extends InnerProxy
{
    const URL_FORM_SETTING    = '/inner/public/form-setting';
    const URL_REPLACE_SETTING = '/inner/public/replace-setting';
    const URL_TEST            = '/inner/test/index';

    /**
     * 获取配置系统中配置表单信息
     *
     * @param string $key
     * @param string|null $subKey
     * @param null $default
     * @return \yii\httpclient\Response
     */
    public function formSetting(string $key, ?string $subKey = null, $default = null)
    {
        $settings = DataStore::get(__CLASS__ . ':formSetting', function () use ($key) {
            return $this->send(self::URL_FORM_SETTING, [
                'key' => $key,
            ]);
        });
        if (empty($subKey)) {
            return $settings;
        }
        return $settings[$subKey] ?? $default;
    }

    /**
     * 获取配置系统中替换后配置内容
     *
     * @param string $code
     * @param array $fields
     * @return string
     * @throws \Exception
     */
    public function replaceSetting(string $code, array $fields = []): string
    {
        return $this->send(self::URL_REPLACE_SETTING, [
            'code'   => $code,
            'fields' => $fields,
        ]);
    }

    public function test()
    {
        return $this->send(self::URL_TEST);
    }
}