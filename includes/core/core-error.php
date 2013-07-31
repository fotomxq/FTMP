<?php

/**
 * 核心错误处理器
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package core
 */
class CoreError {

    /**
     * 错误页面URL
     * @var string 
     */
    private $pageURL;

    /**
     * 初始化
     * @param string $message 消息
     * @param int $id 列
     * @param int $level 级别
     * @param string $url 跳转地址
     * @param boolean $debug Debug是否开启
     * @param SysLog $log 日志操作句柄
     */
    public function __construct($message, $id = 0, $level = 0, $url = 'error.php', $debug = false, &$log = null) {
        if ($level != 2) {
            $this->addLog($log, $message);
            if ($debug == false) {
                $this->pageURL = $url . '?e=';
                $this->error($message);
            } else {
                die('<p>Location : ' . $id . '</p>' . '<p>Message : ' . $message . '</p>' . '<p>Level : ' . $level . '</p>');
            }
        }
    }

    /**
     * 记录日志
     * @param SysLog $log 日志操作句柄，如果为NULL则跳过
     * @param string $message 记录消息
     */
    private function addLog(&$log, $message) {
        if ($log != null) {
            $log->add($message);
        }
    }

    /**
     * 发送错误消息
     * @param string $message 错误消息
     */
    private function error($message) {
        $this->toURL($message);
    }

    /**
     * 将错误消息发送并跳转到URL
     * @param strng $message 错误消息
     */
    private function toURL($message) {
        try {
            header('Location:' . $this->pageURL . $message);
        } catch (Exception $e) {
            die($message);
        }
    }

}

/**
 * 错误接收函数
 * @since 4
 * @param string $errno 错误级别
 * @param string $errstr 错误描述
 * @param string $errfile 错误文件名
 * @param integer $errline 错误发生行
 */
function CoreErrorHandle($errno, $errstr, $errfile, $errline) {
    $message = $errno . ' : ' . $errstr;
    $id = $errfile . '::' . $errline;
    $url = '';
    if (defined('WEB_URL') == true) {
        $url = WEB_URL . '/error.php';
    } else {
        $url = 'error.php';
    }
    $debug = false;
    if (defined('DEBUG_ON') == true) {
        $debug = DEBUG_ON;
    }
    $coreError = new CoreError($message, $id, 2, $url, $debug);
}

//设定错误输出函数
set_error_handler('CoreErrorHandle');
?>
