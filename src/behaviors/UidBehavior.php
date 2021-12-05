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
 * 模型中用户ID自动填充行为
 *
 * Class UidBehavior
 * @package YiiHelper\behaviors
 */
class UidBehavior extends AttributeBehavior
{
    /**
     * @var array 操作事件及字段定义
     */
    public $attributes = [
        ActiveRecord::EVENT_BEFORE_INSERT => 'uid',
        ActiveRecord::EVENT_BEFORE_UPDATE => 'uid',
    ];

    /**
     * 获取登录用户ID
     *
     * @param \yii\base\Event $event
     * @return int|mixed|string
     */
    protected function getValue($event)
    {
        if (null === $this->value) {
            return Req::getUid();
        }
        return parent::getValue($event);
    }
}