<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace {

    class Yii
    {
        /**
         * @var MyApplication
         */
        public static $app;
    }

    class MyApplication
    {
        /**
         * @var string
         */
        public $systemAlias;
        /**
         * @var \YiiBackendUser\components\User
         */
        public $user;
        /**
         * @var \yii\redis\Connection
         */
        public $redis;
        /**
         * @var \YiiHelper\components\CacheHelper
         */
        public $cacheHelper;
        /**
         * @var \YiiInnerSystem\components\OauthTokenManager
         */
        public $oauthTokenManager;
        /**
         * @var \YiiHelper\proxy\ConfigureProxy::class
         */
        public $proxyConfigure;
        /**
         * @var \YiiHelper\proxy\PortalProxy::class
         */
        public $proxyPortal;
        /**
         * @var \Zf\PhpUpload\base\IUpload::class
         */
        public $upload;
    }
}

namespace yii\base {
    class Action
    {
        /**
         * @var \YiiHelper\abstracts\RestController
         */
        public $controller;
    }
}