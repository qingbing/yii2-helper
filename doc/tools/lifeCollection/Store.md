# 抽象工具类 : 生命周期数据管理(Store) LifeCollection 的信息存储器
- 提供属性
    - colName: 集合名称
    - expireTtl: 有效期,秒
    - dataTransfer: 数据转换类型，serialize,json,base64
- 对外提供方法
    - getAllData(): 获取所有有效的数据
    - pushData($data): 新增数据
    - isExpireData($data): 判断数据是否有效
- 需要实现的抽象方法
    - pop(int $count): 从头部移除有效数据(移除个数)
    - getCount(): 获取有效数据数量
    - clearOverdue(): 清理过期数据
    - (protected)push(string $data): 新增字符串数据
    - (protected)getAll(): 获取所有有效的字符串数据
    - (protected)isExpire(string $data): 判断一个字符串数据是否有效

## coding 实现
- 参考实现类[\YiiHelper\tools\lifeCollection\drivers\DbStore](drivers/DbStore.md)
- 参考实现类[\YiiHelper\tools\lifeCollection\drivers\RedisStore](drivers/RedisStore.md)
