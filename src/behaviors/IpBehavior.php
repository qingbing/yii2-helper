<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\behaviors;


use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use YiiHelper\helpers\Req;

/**
 * 模型中客户端IP自动填充行为
 *
 * Class IpBehavior
 * @package YiiHelper\behaviors
 */
class IpBehavior extends AttributeBehavior
{
    /**
     * @var array 操作事件及字段定义
     */
    public $attributes = [
        ActiveRecord::EVENT_BEFORE_INSERT => 'ip',
        ActiveRecord::EVENT_BEFORE_UPDATE => 'ip',
    ];

    /**
     * 获取客户端IP
     *
     * @param \yii\base\Event $event
     * @return int|mixed|string
     */
    protected function getValue($event)
    {
        if (null === $this->value) {
            return Req::getUserIp();
        }
        return parent::getValue($event);
    }
}