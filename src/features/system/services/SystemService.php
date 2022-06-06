<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\features\system\services;


use Exception;
use yii\base\Action;
use YiiHelper\abstracts\Service;
use YiiHelper\features\system\interfaces\ISystemService;
use YiiHelper\features\system\models\Systems;
use YiiHelper\helpers\Pager;
use YiiHelper\helpers\Req;
use Zf\Helper\Exceptions\BusinessException;
use Zf\Helper\Exceptions\ForbiddenHttpException;

/**
 * 服务 : 系统管理
 *
 * Class SystemService
 * @package YiiHelper\features\system\services
 */
class SystemService extends Service implements ISystemService
{
    /**
     * 在action前统一执行
     *
     * @param Action|null $action
     * @return bool
     * @throws ForbiddenHttpException
     */
    public function beforeAction(Action $action = null)
    {
        if (Req::getIsSuper() || in_array($action->id, [
                'type-map',
                'options',
            ])) {
            return true;
        }
        throw new ForbiddenHttpException("您无权操作该界面");
    }

    /**
     * 系统类型map
     *
     * @return array
     */
    public function typeMap(): array
    {
        return Systems::types();
    }

    /**
     * 系统选项卡
     *
     * @return array
     */
    public function options(): array
    {
        return Systems::getOptions();
    }

    /**
     * 系统列表
     *
     * @param array|null $params
     * @return array
     */
    public function list(array $params = []): array
    {
        $query = Systems::find()
            ->orderBy('sort_order ASC');
        // 等于查询
        $this->attributeWhere($query, $params, [
            'type',
            'is_enable',
            'is_allow_new_interface',
            'is_record_field',
            'is_open_validate',
            'is_strict_validate'
        ]);
        // like 查询
        $this->likeWhere($query, $params, ['code', 'name']);
        return Pager::getInstance()->pagination($query, $params['pageNo'], $params['pageSize']);
    }

    /**
     * 添加系统
     *
     * @param array $params
     * @return bool
     * @throws Exception
     */
    public function add(array $params): bool
    {
        $model = new Systems();
        $model->setFilterAttributes($params);
        return $model->saveOrException();
    }

    /**
     * 编辑系统
     *
     * @param array $params
     * @return bool
     * @throws Exception
     */
    public function edit(array $params): bool
    {
        $model = $this->getModel($params);
        unset($params['id']);
        $model->setFilterAttributes($params);
        return $model->saveOrException();
    }

    /**
     * 删除系统
     *
     * @param array $params
     * @return bool
     * @throws \Throwable
     * @throws Exception
     */
    public function del(array $params): bool
    {
        $model = $this->getModel($params);
        return $model->delete();
    }

    /**
     * 查看系统详情
     *
     * @param array $params
     * @return mixed
     * @throws Exception
     */
    public function view(array $params)
    {
        return $this->getModel($params);
    }

    /**
     * 获取当前操作模型
     *
     * @param array $params
     * @return Systems
     * @throws BusinessException
     */
    protected function getModel(array $params): Systems
    {
        $model = Systems::findOne([
            'id' => $params['id'] ?? null
        ]);
        if (null === $model) {
            throw new BusinessException("系统不存在");
        }
        return $model;
    }
}