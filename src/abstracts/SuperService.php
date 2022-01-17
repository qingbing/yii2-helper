<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\abstracts;

use yii\base\Action;
use YiiHelper\helpers\Req;
use Zf\Helper\Exceptions\ForbiddenHttpException;

/**
 * 超管服务基类
 *
 * Class SuperService
 * @package YiiHelper\abstracts
 */
abstract class SuperService extends Service
{
    protected $isSuper; // 是否超管

    /**
     * 在action前统一执行
     *
     * @param Action|null $action
     * @return bool
     */
    public function beforeAction(Action $action = null)
    {
        $this->isSuper = Req::getIsSuper();
        return parent::beforeAction($action);
    }

    /**
     * 必须是超管才能操作
     *
     * @throws ForbiddenHttpException
     */
    protected function superRequired()
    {
        if (!$this->isSuper) {
            throw new ForbiddenHttpException("您无权操作");
        }
    }
}