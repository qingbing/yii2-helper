<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\traits;


use yii\db\Query;

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
}