# 片段: yii\db\Query的扩展处理

- 可用方法
    - (protected)attributeWhere(Query $query, array $params, $fields): 从参数中组件 "=" 条件
    - (protected)likeWhere(Query $query, array $params, $fields): 从参数中组件 "like" 条件
    - (protected)expireWhere(Query $query, $isExpire = 1, $beginField = 'expire_begin_date', $endField = 'expire_end_date'): 时间有效和无效的SQL构建
