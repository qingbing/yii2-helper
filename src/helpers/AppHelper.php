<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\helpers;


use Yii;
use YiiHelper\extend\Application;

/**
 * Yii-App 辅助类
 *
 * Class AppHelper
 * @package YiiHelper\helpers
 */
class AppHelper
{
    /**
     * 返回当前应用
     *
     * @return \yii\console\Application|Application
     */
    public static function app()
    {
        return Yii::$app;
    }

    /**
     * 获取配置的参数信息
     *
     * @param string $key
     * @param null $default
     * @return mixed
     */
    public static function getParam(string $key, $default = null)
    {
        return Yii::$app->params[$key] ?? $default;
    }

    /**
     * 判断使用的是否是yii的基础版
     *
     * @param string $vendorName
     * @return bool
     */
    public static function getIsBasicYii($vendorName = 'vendor')
    {
        $basePath = self::getBasePath();
        return is_dir("{$basePath}/{$vendorName}");
    }

    /**
     * 判断是否时控制台应用
     *
     * @return bool
     */
    public static function getIsConsole()
    {
        return Yii::$app->getRequest()->getIsConsoleRequest();
    }

    /**
     * 获取 Yii 的运行日志路径
     *
     * @return string
     */
    public static function getRuntimePath()
    {
        return Yii::$app->getRuntimePath();
    }

    /**
     * 获取项目基本路径
     *
     * @return string
     */
    public static function getBasePath()
    {
        return Yii::$app->getBasePath();
    }

    /**
     * 获取程序根目录
     *
     * @param string $vendorName
     * @return string
     */
    public static function getRootPath($vendorName = 'vendor')
    {
        $basePath = self::getBasePath();
        return self::getIsBasicYii($vendorName) ? $basePath : dirname($basePath);
    }

    /**
     * 获取配置文件目录
     *
     * @param string | null $module
     * @param string $vendorName
     * @return string
     */
    public static function getConfigPath($module = null, $vendorName = 'vendor')
    {
        if (self::getIsBasicYii($vendorName)) {
            return self::getBasePath() . "/config";
        }
        if (null === $module) {
            return self::getBasePath() . "/config";
        }
        return self::getRootPath() . "/{$module}/config";
    }

    /**
     * 获取 db 连接的 dsn 中的数据库名
     *
     * @param string | null $dsn
     * @return string
     */
    public static function getDatabaseName($dsn = null)
    {
        $dsn = $dsn ?? Yii::$app->getDb()->dsn;
        if (preg_match("#dbname=(\S*)#", strtolower($dsn), $ms)) {
            return trim($ms[1], "'");
        }
        return '';
    }
}