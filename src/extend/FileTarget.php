<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace YiiHelper\extend;


use yii\helpers\VarDumper;
use yii\log\Logger;
use Zf\Helper\ReqHelper;

/**
 * 扩展 FileTarget，为日志加上 trace-id
 * Class FileTarget
 * @package YiiHelper\extend
 */
class FileTarget extends \yii\log\FileTarget
{
    /**
     * @var bool 是否包含日志出处的trace信息
     */
    public $trace = false;

    /**
     * 格式化消息
     *
     * @param array $message
     * @return string
     */
    public function formatMessage($message)
    {
        list($text, $level, $category, $timestamp) = $message;
        $level = Logger::getLevelName($level);
        if (!is_string($text)) {
            // exceptions may not be serializable if in the call stack somewhere is a Closure
            if ($text instanceof \Throwable || $text instanceof \Exception) {
                $text = (string)$text;
            } else {
                $text = VarDumper::export($text);
            }
        }
        $traces = [];
        if (isset($message[4])) {
            foreach ($message[4] as $trace) {
                $traces[] = "in {$trace['file']}:{$trace['line']}";
            }
        }

        $prefix  = $this->getMessagePrefix($message);
        $traceId = ReqHelper::getTraceId();
        if ($this->trace) {
            return $this->getTime($timestamp) . " {$prefix}[$level][$traceId][$category] $text"
                . (empty($traces) ? '' : "\n    " . implode("\n    ", $traces));
        } else {
            return $this->getTime($timestamp) . " {$prefix}[$level][$traceId][$category] $text";
        }
    }
}