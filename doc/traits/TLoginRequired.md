# 片段: 用户登录状态判断

- 可用方法
    - (protected static)loginRequired(): 确保访问必须是登录状态
    - (protected static)isLoginUser($uid): 判断给出的用户ID是否是当前登录用户