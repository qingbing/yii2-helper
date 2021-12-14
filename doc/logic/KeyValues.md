# 逻辑: 配置的 key-value 的获取
- 需要 [prefix_key_value.sql](./../../sql/prefix_key_value.sql) 的支持
- 提供方法
    - (static)data(string $group, bool $isAssoc = true): 获取配置的 key-value 数组数据
    - (static)value(string $group, string $key, $default = null): 获取配置的 key-value 的某个value值
