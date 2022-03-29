# 请求助手 ： Req
- 对于同一种类型的请求，每次从 header 或 $_SERVER 中寻找，并在当前请求缓存下来
- 提供的请求种类
    - getUserIp(): 获取客户端IP
    - getAccessIp(): 获取直接访问的IP(refer-client-ip)
    - getIsGuest(): 获取当前是否登录
    - getUid(): 获取当前登录用户id
    - getIsSuper(): 获取登录用户是否超管
    - getAccount(): 获取当前登录用户账户
    - getNickname(): 获取当前登录用户昵称
