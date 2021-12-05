<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\services\interfaces;


interface ICurdService extends IService
{
    /**
     * 项目列表
     *
     * @param array|null $params
     * @return array
     */
    public function list(array $params = []): array;

    /**
     * 添加项目
     *
     * @param array $params
     * @return bool
     */
    public function add(array $params): bool;

    /**
     * 编辑项目
     *
     * @param array $params
     * @return bool
     */
    public function edit(array $params): bool;

    /**
     * 删除项目
     *
     * @param array $params
     * @return bool
     */
    public function del(array $params): bool;

    /**
     * 查看项目详情
     *
     * @param array $params
     * @return mixed
     */
    public function view(array $params);
}