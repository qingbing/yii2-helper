# 请求助手 ： Req
- 获取客户端 IP ： getUserIp()
    - 程序中多次请求 Yii::$app->getRequest()->getUserIp() 会每次从 header 或 $_SERVER 中寻找，这里缓存下来
    