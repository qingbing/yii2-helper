# 数据验证片段 TValidator
- 该片段只提供 protected 方法
- 只要验证失败，将跑出参数异常
- 根据提供规则验证页面参数 validateParams($rules = [], $labels = [])
- 提供数据、规则、属性标签验证 validate(array $data, $rules = [], $labels = [])
