<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\extend;


use yii\base\InvalidRouteException;
use YiiBackendUser\components\User;
use YiiHelper\components\CacheHelper;
use Zf\Helper\DataStore;

/**
 * 扩展功能
 *
 * Class Application
 * @package YiiHelper\extend
 *
 * @property-read CacheHelper $cacheHelper
 * @property-read User $user
 * @property-read string $systemAlias
 *
 * @method User getUser()
 */
class Application extends \yii\web\Application
{
    /**
     * @var string 默认中转传输路由
     */
    public $transmitRoute = 'transmit/index';

    /**
     * 获取当前请求的系统标记
     *
     * @return string
     */
    public function getSystemAlias()
    {
        return DataStore::get(__CLASS__ . ":system", function () {
            $system = $this->getRequest()->getHeaders()->get('x-system');
            if (null === $system) {
                return $this->id;
            }
            return $system;
        });
    }

    /**
     * 获取配置的 params 参数
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getParam(string $key, $default = null)
    {
        return $this->params[$key] ?? $default;
    }

    /**
     * @inheritDoc
     *
     * @throws InvalidRouteException
     */
    public function runAction($route, $params = [])
    {
        if ($this->getSystemAlias() == $this->id) {
            return parent::runAction($route, $params);
        }
        return parent::runAction($this->transmitRoute, $params);
    }
}