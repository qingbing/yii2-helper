# 响应处理片段 TResponse

- 该片段适用于web-controller响应
- 可用方法
    - 获取响应处理类 ： getResponse()
    - 成功响应 ： success($data = null, ?string $msg = 'ok')
    - 失败响应 ： fail(int $code = -1, ?string $msg = 'ok', $data = null)
