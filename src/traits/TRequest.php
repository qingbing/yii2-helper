<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\traits;


use Exception;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * 片段: 请求
 *
 * Trait TRequest
 * @package YiiHelper\traits
 */
trait TRequest
{
    /**
     * 获取请求处理类
     *
     * @return \yii\console\Request|\yii\web\Request
     */
    public function getRequest()
    {
        return Yii::$app->getRequest();
    }

    /**
     * 获取所有 $_GET 和 $_POST 参数
     *
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function getParams()
    {
        // 数据获取
        $request = Yii::$app->getRequest();
        return array_merge($request->getQueryParams(), $request->getBodyParams());
    }

    /**
     * 获取参数
     *
     * @param string $key
     * @param null|mixed $default
     * @return array|mixed|string|null
     * @throws Exception
     */
    public function getParam(string $key, $default = null)
    {
        $subKey = '';
        if (false !== strpos($key, '.')) {
            list($key, $subKey) = explode('.', $key, 2);
        }
        $val = $this->getRequest()->post($key);
        if (null === $val) {
            $val = $this->getRequest()->get($key, $default);
        }
        if (is_string($val)) {
            $val = trim($val);
        }
        if (!empty($subKey)) {
            if (!is_array($val)) {
                return $default;
            }
            return ArrayHelper::getValue($val, $subKey, $default);
        }
        return $val;
    }

    /**
     * 获取单个上传实例
     *
     * @param string $name
     * @return UploadedFile
     */
    public function getUploadInstanceByName($name)
    {
        return UploadedFile::getInstanceByName($name);
    }

    /**
     * 获取上传实例组
     *
     * @param string $name
     * @return UploadedFile[]
     */
    public function getUploadInstancesByName($name)
    {
        return UploadedFile::getInstancesByName($name);
    }
}