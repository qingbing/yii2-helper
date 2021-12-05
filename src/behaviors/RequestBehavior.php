<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\behaviors;


use yii\base\Behavior;

/**
 * 行为 : web 请求的附加行为
 *
 * Class RequestBehavior
 * @package YiiHelper\behaviors
 *
 * @property \yii\web\Request $owner
 */
class RequestBehavior extends Behavior
{
    /**
     * 获取请求的内容方法
     *
     * @return null|string
     */
    public function getShortContentType()
    {
        $rawContentType = $this->owner->getContentType();
        if ($rawContentType && ($pos = strpos($rawContentType, ';')) !== false) {
            // e.g. text/html; charset=UTF-8
            return substr($rawContentType, 0, $pos);
        }
        return $rawContentType;
    }

    /**
     * 判断是否是 form-data， form-data 表示可以上传文件
     *
     * @return bool
     */
    public function isFormData()
    {
        return $this->getShortContentType() === 'multipart/form-data';
    }

    /**
     * 获取所有请求参数
     *
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function getParams()
    {
        return array_merge($this->owner->getQueryParams(), $this->owner->getBodyParams());
    }

    /**
     * 获取传递参数的值
     *
     * @param string $name
     * @param null $default
     * @return mixed|null
     * @throws \yii\base\InvalidConfigException
     */
    public function getParam(string $name, $default = null)
    {
        $params = $this->getParams();
        return $params[$name] ?? $default;
    }
}