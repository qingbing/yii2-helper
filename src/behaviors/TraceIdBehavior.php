<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\behaviors;


use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use Zf\Helper\Id;
use Zf\Helper\ReqHelper;

/**
 * 模型中客户端日志ID自动填充行为
 *
 * Class TraceIdBehavior
 * @package YiiHelper\behaviors
 */
class TraceIdBehavior extends AttributeBehavior
{
    /**
     * @var array 操作事件及字段定义
     */
    public $attributes = [
        ActiveRecord::EVENT_BEFORE_INSERT => 'trace_id',
    ];

    /**
     * 获取客户端日志ID
     *
     * @param \yii\base\Event $event
     * @return int|mixed|string
     */
    protected function getValue($event)
    {
        if (null === $this->value) {
            return ReqHelper::getTraceId();
        }
        return parent::getValue($event);
    }
}