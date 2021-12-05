# 基础的配置常量
- 几个规范的常量前缀
    - YII原有的常量前缀: YII_
    - yii框架非常通用的配置: CONF_
    - 各个系统可能配置的组件: COM_
    - params中配置: PARAM_
    - 其它自定的配置常量前缀: CUSTOM_

```php

/**
 * yii 环境定义
 */
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

/**
 * 应用相关通用配置
 */
defined('CONF_APP_ID') or define('CONF_APP_ID', 'portal');
defined('CONF_CONSOLE_ID') or define('CONF_CONSOLE_ID', 'console-portal');

// db 组件配置
defined("CONF_DB_DSN") or define("CONF_DB_DSN", "mysql:host=192.168.1.8;dbname=yii_portal");
defined("CONF_DB_USER") or define("CONF_DB_USER", "root");
defined("CONF_DB_PASS") or define("CONF_DB_PASS", "123456");
defined("CONF_DB_TABLE_PREFIX") or define("CONF_DB_TABLE_PREFIX", "portal_");

// redis 组件配置
defined("CONF_REDIS_HOST") or define("CONF_REDIS_HOST", "192.168.1.7");
defined("CONF_REDIS_PORT") or define("CONF_REDIS_PORT", 6379);
defined("CONF_REDIS_PASS") or define("CONF_REDIS_PASS", 'iapass');
defined("CONF_REDIS_DB") or define("CONF_REDIS_DB", 0);

// cacheHelper 组件配置
defined('CONF_CACHE_HELPER_OPEN_CACHE') or define('CONF_CACHE_HELPER_OPEN_CACHE', true); // 是否开启cacheHelper的缓存，默认true，开启

// urlManager 组件配置
defined('CONF_URL_MANAGER_ENABLE_PRETTY_URL') or define('CONF_URL_MANAGER_ENABLE_PRETTY_URL', true); // 美化URL
defined('CONF_URL_MANAGER_SHOW_SCRIPT_NAME') or define('CONF_URL_MANAGER_SHOW_SCRIPT_NAME', false); // 展示入口文件

/**
 * 组件配置
 */
 
/**
 * params 参数
 */

/**
 * 自定义各种配置
 */
```