<?php /** @noinspection ALL */

/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\behaviors;


use yii\base\Event;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;

/**
 * 默认值填充，eg
 *      '' => '1000-01-01'
 *      '' => '1000-01-01 01:01:01'
 *
 * Class DefaultDatetimeBehavior
 * @package YiiHelper\behaviors
 */
class DefaultBehavior extends AttributeBehavior
{
    const TYPE_DATE     = "date";
    const TYPE_DATETIME = "datetime";
    /**
     * @var 支持默认值的类型，目前只支持 date, 和 datetime
     */
    public $type;
    /**
     * @var bool 是否严格判断是否为空
     */
    public $strict = false;

    /**
     * Evaluates the attribute value and assigns it to the current attributes.
     * @param Event $event
     */
    public function evaluateAttributes($event)
    {
        if ($this->skipUpdateOnClean
            && $event->name == ActiveRecord::EVENT_BEFORE_UPDATE
            && empty($this->owner->dirtyAttributes)
        ) {
            return;
        }

        if (!empty($this->attributes[$event->name])) {
            $attributes = (array)$this->attributes[$event->name];
            foreach ($attributes as $attribute) {
                $value = $this->owner->$attribute;
                if (is_string($attribute) && (($this->strict && null === $value) || (!$this->strict && empty($value)))) {
                    $this->owner->$attribute = $this->getCustomValue($event, $value, $attribute);
                }
            }
        }
    }

    /**
     * 获取属性值
     *
     * @param Event $event
     * @param mixed $value
     * @param string $attrbute
     * @return mixed|string
     */
    protected function getCustomValue($event, $value, $attrbute)
    {
        if (null === $this->value) {
            if (self::TYPE_DATE === $this->type) {
                return "1000-01-01";
            } elseif (self::TYPE_DATETIME === $this->type) {
                return "1000-01-01 01:01:01";
            } else {
                return '';
            }
        }
        return parent::getValue($event);
    }
}