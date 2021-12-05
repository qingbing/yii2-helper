<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\helpers\client\exceptions;


use Exception;
use yii\httpclient\Request;
use yii\httpclient\Response;

/**
 * 异常 : 请求异常
 *
 * Class RequestException
 * @package YiiHelper\helpers\client\exceptions
 */
class RequestException extends TransferException
{
    /**
     * RequestException constructor.
     * @param $message
     * @param Request $request
     * @param Response|null $response
     * @param Exception|null $previous
     * @throws Exception
     */
    public function __construct($message, Request $request, Response $response = null, Exception $previous = null)
    {
        // Set the code of the exception if the response is set and not future.
        $code = $response ? $response->getStatusCode() : 0;
        parent::__construct($message, $code, $request, $response, $previous);
    }


    /**
     * 创建一个常规异常
     *
     * @param Request $request
     * @param Response|null $response
     * @param Exception|null $previous
     * @return RequestException
     * @throws Exception
     */
    public static function create(Request $request, Response $response = null, Exception $previous = null)
    {
        if (!$response) {
            return new self('Error completing request', $request, null, $previous);
        }

        $level = (int)floor(intval($response->getStatusCode()) / 100);
        if ($level === 4) {
            $label     = 'Client error';
            $className = ClientException::class;
        } elseif ($level === 5) {
            $label     = 'Server error';
            $className = ServerException::class;
        } else {
            $label     = 'Unsuccessful request';
            $className = __CLASS__;
        }

        $uri = $request->getFullUrl();

        // Client Error: `GET /` resulted in a `404 Not Found` response:
        // <html> ... (truncated)
        $message = sprintf(
            '%s: `%s %s` resulted in a `%s` response',
            $label,
            $request->getMethod(),
            $uri,
            $response->getStatusCode()
        );

        $summary = static::getResponseBodySummary($response);

        if ($summary !== null) {
            $message .= ":\n{$summary}\n";
        }

        return new $className($message, $request, $response, $previous);
    }

    /**
     * 获取http响应体概要
     *
     * @param Response $response
     * @return string|null
     */
    public static function getResponseBodySummary(Response $response)
    {
        $content = $response->getContent();
        $size    = mb_strlen($content);
        if ($size === 0) {
            return null;
        }
        $summary = mb_substr($content, 0, 120);
        if ($size > 120) {
            $summary .= ' (truncated...)';
        }

        // Matches any printable character, including unicode characters:
        // letters, marks, numbers, punctuation, spacing, and separators.
        if (preg_match('/[^\pL\pM\pN\pP\pS\pZ\n\r\t]/', $summary)) {
            return null;
        }

        return $summary;
    }
}