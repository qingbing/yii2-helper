<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\abstracts;


use yii\base\BaseObject;
use YiiHelper\traits\TQueryWhere;

/**
 * 服务基类
 *
 * Class Service
 * @package YiiHelper\abstracts
 */
abstract class Service extends BaseObject
{
    /**
     * Query 条件查询
     */
    use TQueryWhere;
}