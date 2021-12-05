# 行为(RetryBehavior): 为实例附加重试计算功能

- 目前主要用于附加于client请求访问上
- 附加方法
    - getRetry(): 获取重试次数
    - setRetry(int $retry): 设置重试次数
