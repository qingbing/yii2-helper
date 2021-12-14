<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\logic;


use Yii;
use yii\db\Query;

/**
 * 逻辑: 配置的 key-value 的获取
 *
 * Class KeyValues
 * @package YiiHelper\logic
 */
class KeyValues
{
    /**
     * 获取配置的 key-value 数组数据
     *
     * @param string $group
     * @param bool $isAssoc
     * @return array
     */
    public static function data(string $group, bool $isAssoc = true): array
    {
        $data = Yii::$app->cacheHelper->get(__CLASS__ . ":data:{$group}", function () use ($group) {
            return (new Query())
                ->from('{{%key_value}}')
                ->select(['key', 'value'])
                ->andWhere(['=', 'is_enable', IS_YES])
                ->andWhere(['=', 'group', $group])
                ->orderBy('sort_order ASC')
                ->all();
        }, 600);
        if (!$isAssoc) {
            return $data;
        }
        return array_combine(array_column($data, 'key'), array_column($data, 'value'));
    }

    /**
     * 获取配置的 key-value 的某个value值
     *
     * @param string $group
     * @param string $key
     * @param mixed $default
     * @return mixed|null
     */
    public static function value(string $group, string $key, $default = null)
    {
        $data = static::data($group, true);
        return $data[$key] ?? $default;
    }
}