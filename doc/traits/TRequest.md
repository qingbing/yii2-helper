# 请求获取片段 TRequest

- 该片段适用于请求参数的获取
- 可用方法
    - 获取请求处理类 ： getRequest()
    - 获取所有 $_GET 和 $_POST 参数 ： getParams()
    - 获取参数 ： getParam(string $key, $default = null)
    - 获取单个上传实例 ： getUploadInstanceByName($name)
    - 获取上传实例组 ： getUploadInstancesByName($name)
