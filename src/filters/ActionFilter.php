<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\filters;


use yii\base\Exception;

/**
 * Action 过滤器
 *
 * Class ActionFilter
 * @package YiiHelper\filters
 */
class ActionFilter extends \yii\base\ActionFilter
{
    /**
     * @var array|callable|null 在 beforeAction 前需要执行的回调函数
     */
    public $beforeActionCallback;
    /**
     * @var array|callable|null 在 afterAction 前需要执行的回调函数
     */
    public $afterActionCallback;

    /**
     * 在开始一个 action 之前调用
     *
     * @param \yii\base\Action $action
     * @return bool
     * @throws Exception
     */
    public function beforeAction($action)
    {
        $callbacks = [];
        // filter 中的 beforeActionCallback
        if (is_callable($this->beforeActionCallback)) {
            $callbacks[] = $this->beforeActionCallback;
        } elseif (is_array($this->beforeActionCallback)) {
            foreach ($this->beforeActionCallback as $callback) {
                if (!is_callable($callback)) {
                    throw new Exception('\YiiHelper\filters\ActionFilter->beforeActionCallback[]需要配置成callable', 1020001001);
                }
                $callbacks[] = $callback;
            }
        } elseif (null !== $this->beforeActionCallback) {
            throw new Exception('\YiiHelper\filters\ActionFilter->beforeActionCallback需要配置成callable', 1020001002);
        }
        // owner(controller) 中的 beforeActionCallback
        if (property_exists($this->owner, 'beforeActionCallback')) {
            if (is_string($this->owner->beforeActionCallback) && is_callable([$this->owner, $this->owner->beforeActionCallback])) {
                $callbacks[] = [$this->owner, $this->owner->beforeActionCallback];
            } elseif (is_callable($this->owner->beforeActionCallback)) {
                $callbacks[] = $this->owner->beforeActionCallback;
            } elseif (is_array($this->owner->beforeActionCallback)) {
                foreach ($this->owner->beforeActionCallback as $callback) {
                    if (!is_callable($callback)) {
                        throw new Exception(get_class($this->owner) . '->beforeActionCallback[]需要配置成callable', 1020001003);
                    }
                    $callbacks[] = $callback;
                }
            } elseif (null !== $this->owner->beforeActionCallback) {
                throw new Exception(get_class($this->owner) . '->beforeActionCallback需要配置成callable', 1020001004);
            }
        }
        // 执行 filter 中的 beforeAction 回调
        foreach ($callbacks as $callback) {
            $status = call_user_func_array($callback, [$action]);
            if (true !== $status) {
                return false;
            }
        }
        return parent::beforeAction($action);
    }

    /**
     * 结束入一个 action 之后调用
     *
     * @param \yii\base\Action $action
     * @param mixed $result
     * @return mixed
     * @throws Exception
     */
    public function afterAction($action, $result)
    {
        $callbacks = [];
        // filter 中的 afterActionCallback
        if (is_callable($this->afterActionCallback)) {
            $callbacks[] = $this->afterActionCallback;
        } elseif (is_array($this->afterActionCallback)) {
            foreach ($this->afterActionCallback as $callback) {
                if (!is_callable($callback)) {
                    throw new Exception('\YiiHelper\filters\ActionFilter->afterActionCallback[]需要配置成callable', 1020001005);
                }
                $callbacks[] = $callback;
            }
        } elseif (null !== $this->afterActionCallback) {
            throw new Exception('\YiiHelper\filters\ActionFilter->afterActionCallback需要配置成callable', 1020001006);
        }
        // owner(controller) 中的 afterActionCallback
        if (property_exists($this->owner, 'afterActionCallback')) {
            if (is_string($this->owner->afterActionCallback) && is_callable([$this->owner, $this->owner->afterActionCallback])) {
                $callbacks[] = [$this->owner, $this->owner->afterActionCallback];
            } elseif (is_callable($this->owner->afterActionCallback)) {
                $callbacks[] = $this->owner->afterActionCallback;
            } elseif (is_array($this->owner->afterActionCallback)) {
                foreach ($this->owner->afterActionCallback as $callback) {
                    if (!is_callable($callback)) {
                        throw new Exception(get_class($this->owner) . '->afterActionCallback[]需要配置成callable', 1020001007);
                    }
                    $callbacks[] = $callback;
                }
            } elseif (null !== $this->owner->afterActionCallback) {
                throw new Exception(get_class($this->owner) . '->afterActionCallback需要配置成callable', 1020001008);
            }
        }

        // 执行 filter 中的 afterAction 回调
        foreach ($callbacks as $callback) {
            $result = call_user_func_array($callback, [$action, $result,]);
        }
        return parent::afterAction($action, $result);
    }
}