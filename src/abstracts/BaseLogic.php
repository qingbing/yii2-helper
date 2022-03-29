<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\abstracts;


use Zf\Helper\Abstracts\Factory;

/**
 * 抽象类 : 逻辑基类
 *
 * Class BaseLogic
 * @package YiiHelper\abstracts
 */
abstract class BaseLogic extends Factory
{
    /**
     * @var array 逻辑参数
     */
    protected $params = [];

    /**
     * 设置逻辑参数
     *
     * @param array $params
     * @return $this
     */
    public function setParams(array $params)
    {
        $this->params = $params;
        return $this;
    }

    /**
     * 获取逻辑数据
     *
     * @return mixed
     */
    abstract public function getData();
}