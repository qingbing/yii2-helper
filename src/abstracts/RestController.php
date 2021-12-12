<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\abstracts;

use Exception;
use yii\base\Event;
use yii\helpers\ArrayHelper;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\Response;
use YiiHelper\traits\TResponse;
use YiiHelper\traits\TValidator;
use Zf\Helper\Exceptions\CustomException;
use Zf\Helper\ReqHelper;

/**
 * web 基类
 * Class WebController
 * @package YiiHelper\abstracts
 */
abstract class RestController extends Controller
{
    /**
     * @var string 控制器服务类接口
     */
    public $serviceInterface;
    /**
     * @var string 控制器服务类名
     */
    public $serviceClass;
    /**
     * @var mixed 控制器服务器类
     */
    protected $service;

    // 使用响应片段
    use TResponse;
    // 使用参数验证片段
    use TValidator;
    /**
     * @var bool 采用默认的响应格式
     */
    protected $useDefaultResponse = true;

    /**
     * 控制器初始化后执行
     *
     * @throws CustomException
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        if ($this->useDefaultResponse) {
            // 在发送后端数据响应前规范响应格式
            \Yii::$app->getResponse()->on(Response::EVENT_BEFORE_SEND, function (Event $event) {
                $response = $event->sender;
                /* @var Response $response */
                if (!in_array($response->getStatusCode(), [200, 302])) {
                    // error
                    $response->format = Response::FORMAT_JSON;
                } elseif (is_array($response->data)) {
                    $response->format = Response::FORMAT_JSON;
                } elseif (is_string($response->data)) {
                    $response->format = Response::FORMAT_RAW;
                } elseif ($response->format !== Response::FORMAT_HTML) {
                    $response->format = Response::FORMAT_JSON;
                    $response->data   = \YiiHelper\helpers\Response::getInstance()
                        ->setMsg($response->statusText)
                        ->setCode(0)
                        ->output($response->data);
                }
                // 在响应中添加 trace-id
                $response->getHeaders()
                    ->add('x-trace-id', ReqHelper::getTraceId());
            });
        }
        if (null !== $this->serviceClass) {
            $this->service = \Yii::createObject($this->serviceClass);
            if (null !== $this->serviceInterface && !$this->service instanceof $this->serviceInterface) {
                $errMsg = replace('{controller}.serviceClass={serviceClass} 必须继承 {interfaceName}', [
                    '{serviceClass}'  => $this->serviceClass,
                    '{controller}'    => get_class($this),
                    '{interfaceName}' => $this->serviceInterface,
                ]);
                \Yii::error($errMsg, "custom.error");
                throw new CustomException($errMsg);
            }
        }
    }

    /**
     * @param $action
     * @return bool
     * @throws BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if ($this->service instanceof Service && !$this->service->beforeAction($action)) {
            return false;
        }
        return parent::beforeAction($action);
    }

    /**
     * 获取参数
     *
     * @param string $key
     * @param null|mixed $default
     * @return array|mixed|string|null
     * @throws Exception
     */
    protected function getParam(string $key, $default = null)
    {
        $subKey = '';
        if (false !== strpos($key, '.')) {
            list($key, $subKey) = explode('.', $key, 2);
        }
        $val = $this->request->post($key);
        if (null === $val) {
            $val = $this->request->get($key, $default);
        }
        if (is_string($val)) {
            $val = trim($val);
        }
        if (!empty($subKey)) {
            if (!is_array($val)) {
                return $default;
            }
            return ArrayHelper::getValue($val, $subKey, $default);
        }
        return $val;
    }

    /**
     * 分页参数校验
     *
     * @return array
     * @throws Exception
     */
    protected function pageRules()
    {
        // 返回分页参数校验规则
        return [
            ['pageNo', 'integer', 'label' => '页码', 'default' => 1, 'min' => 1],
            ['pageSize', 'integer', 'label' => '分页条数', 'default' => 10, 'min' => 1],
        ];
    }
}