# 数据分页类 Pager
- 继承 \Zf\Helper\Abstracts\Factory
- 外部设置数据总数量 setTotalCount(int $count)，如果不设置，将自动通过SQL获取
- 设置返回为数组列表 setAsArray(bool $asArray = true)，默认返回对象列表
- *数据分页查询* pagination(ActiveQuery $query, $pageNo = null, $pageSize = null)
