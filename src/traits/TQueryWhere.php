<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\traits;


use yii\db\Query;
use Zf\Helper\Format;

/**
 * 片段: yii\db\Query的扩展处理
 *
 * Trait TQueryWhere
 * @package YiiHelper\traits
 */
trait TQueryWhere
{
    /**
     * 从参数中组件 "=" 条件
     * @param Query $query
     * @param array $params
     * @param array|string $fields
     * @return Query
     */
    protected function attributeWhere(Query $query, array $params, $fields): Query
    {
        if (empty($fields)) {
            return $query;
        }
        if (!is_array($fields)) {
            $fields = (array)$fields;
        }
        $where = [];
        foreach ($fields as $idx => $field) {
            $dbField = is_numeric($idx) ? $field : $idx;
            if (isset($params[$field]) && "" !== $params[$field] && null !== $params[$field]) {
                $where[$dbField] = $params[$field];
            }
        }
        if (empty($where)) {
            return $query;
        }
        return $query->andWhere($where);
    }

    /**
     * 从参数中组件 "like" 条件
     *
     * @param Query $query
     * @param array $params
     * @param array|string $fields
     * @return Query
     */
    protected function likeWhere(Query $query, array $params, $fields): Query
    {
        if (empty($fields)) {
            return $query;
        }
        if (!is_array($fields)) {
            $fields = (array)$fields;
        }
        foreach ($fields as $idx => $field) {
            $dbField = is_numeric($idx) ? $field : $idx;
            if (isset($params[$field]) && "" !== $params[$field] && null !== $params[$field]) {
                $query->andWhere(['like', $dbField, $params[$field]]);
            }
        }
        return $query;
    }

    /**
     * 时间有效和无效的SQL构建
     *
     * @param Query $query
     * @param int $isExpire 是否有效
     * @param string $beginField 生效时间/日期字段
     * @param string $endField 失效时间/日期字段
     */
    protected function expireWhere(Query $query, $isExpire = 1, $beginField = 'expire_begin_date', $endField = 'expire_end_date')
    {
        if ("" !== $isExpire && null !== $isExpire) {
            $nowDatetime = Format::datetime();
            if ($isExpire) {
                // 有效用户
                $query->andWhere([
                    'or',
                    [ // 未设置有效期的
                      'and',
                      "{$beginField} < :emptyDate AND {$endField} < :emptyDate"
                    ], [
                        'not', // 有效反转
                        [ // 有效期的
                          'or',
                          ['and', "{$endField} < :nowDatetime AND {$endField} > :emptyDate"],
                          ['and', "{$beginField} > :nowDatetime AND {$beginField} > :emptyDate"],
                        ]
                    ]
                ], [
                    ':nowDatetime' => $nowDatetime,
                    ':emptyDate'   => EMPTY_TIME_MIN,
                ]);
            } else {
                // 失效用户
                $query->andWhere([
                    'or',
                    [ // 已过期的
                      'and',
                      "{$endField} < :nowDatetime AND {$endField} > :emptyDate"
                    ],
                    [ // 未生效的
                      'and',
                      "{$beginField} > :nowDatetime AND {$beginField} > :emptyDate"
                    ],
                ], [
                    ':nowDatetime' => $nowDatetime,
                    ':emptyDate'   => EMPTY_TIME_MIN,
                ]);
            }
        }
    }
}