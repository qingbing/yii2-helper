<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\features\system\interfaces;


use YiiHelper\services\interfaces\ICurdService;

/**
 * 接口 ： 接口系统管理
 *
 * Interface ISystemService
 * @package YiiHelper\features\system\interfaces
 */
interface ISystemService extends ICurdService
{
    /**
     * 系统类型map
     *
     * @return array
     */
    public function typeMap(): array;

    /**
     * 系统选项卡
     *
     * @return array
     */
    public function options(): array;
}