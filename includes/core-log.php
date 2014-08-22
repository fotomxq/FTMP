<?php

/**
 * 日志操作类
 * @author liuzilu <fotomxq@gmail.com>
 * @version 5
 * @package core
 */
class CoreLog {

    /**
     * 是否开启日志记录
     * @var boolean
     */
    private $logOpen = true;

    /**
     * 日志文件目录
     * @var string
     */
    private $logDir = '';

    /**
     * 缓冲文件后缀名
     * @var string
     */
    private $suffix = '.log';

    /**
     * 路径分隔符
     * @var string
     */
    private $ds = DIRECTORY_SEPARATOR;

    /**
     * 设定日志文件路径形式
     * 0 - 发送到PHP日志记录系统
     * 1 - 年月.log
     * 2 - 年月/日.log
     * 3 - 年月/日-时.log
     * 4 - 年/月/日-时.log
     * @var int
     */
    private $setNameType = 1;

    /**
     * 设定文件限制
     * 如果超过该大小设定，则创建日志文件时自动递增。如: name-1.log / name-2.log...
     * @var integer
     */
    private $limitSize = 0;

    /**
     * IP地址
     * @var string
     */
    private $ip;

    /**
     * 初始化
     * <p>日志形式</p>
     * <p>0 - 发送到PHP日志记录系统</p>
     * <p>1 - 年月.log</p>
     * <p>2 - 年月/日.log</p>
     * <p>3 - 年月/日-时.log</p>
     * <p>4 - 年/月/日-时.log</p>
     * @param boolean $logOpen 是否开启日志系统
     * @param string $logDir  日志所在目录
     * @param int $logType 日志记录形式
     */
    public function __construct($logOpen, $logDir, $logType, $ip) {
        $this->logOpen = $logOpen;
        $this->logDir = $logDir;
        $this->setNameType = $logType;
        $this->ip = $ip;
        if (!is_dir($logDir)) {
            mkdir($logDir, '0777', true);
        }
    }

    /**
     * 添加日志
     * @param string $local 位置
     * @param string $message 消息内容
     * @return boolean      是否成功
     */
    public function add($local, $message) {
        if (!$this->logOpen) {
            return false;
        }
        if ($this->setNameType == 0) {
            $data = $this->ip . ' ' . $message;
            $this->addSysLog($local, LOG_INFO, $data);
            return true;
        } else {
            $time = date('Y-m-d H:i:s');
            $src = $this->getSrc($time);
            $data = $time . ' <' . $local . '> ' . $this->ip . ' ' . $message;
            return $this->saveFile($src, $data);
        }
        return false;
    }

    /**
     * 添加一条系统日志
     * @param string $local    位置
     * @param int $type    日志类型
     * @param string $message 消息
     */
    public function addSysLog($local, $type, $message) {
        openlog($local, LOG_PID | LOG_PERROR, LOG_LOCAL0);
        syslog($type, $message);
        closelog();
    }

    /**
     * 获取日志列
     * @param int $offset 偏移文件值
     * @return array 数据数组
     */
    public function view($offset = 0) {
        //如果是系统日志，不支持
        if ($this->setNameType === 0) {
            return null;
        }
        //以今天日期为起点，逆向遍历出日志文件路径
        $dateY = date('Y');
        $dateM = date('m');
        $dateD = date('d');
        $dateH = date('H');
        $logSrcArr;
        switch ($this->setNameType) {
            case 1:
                $logSrcArr = $this->viewFileList($this->logDir);
                break;
            default:
                $logSrcArr = $this->viewAllFile($this->logDir);
                break;
        }
        if(!$logSrcArr){
            return null;
        }
        if(isset($logSrcArr[$offset])){
            return $logSrcArr[$offset];
        }
        return null;
    }

    /**
     * 计算日志同同时间段个数
     * @param  string $src 搜索路径
     * @return int      个数
     */
    private function getFileCount($src) {
        $s = glob($src);
        if ($s) {
            return count($s);
        }
        return 0;
    }

    /**
     * 目录是否存在
     * @param  string  $src 目录路径
     * @return boolean      是否存在
     */
    private function isDir($src) {
        return is_dir($src);
    }

    /**
     * 创建目录
     * @param  string $src 目录路径
     * @return boolean      是否成功
     */
    private function createDir($src) {
        if ($this->isDir($src) == true) {
            return true;
        } else {
            return mkdir($src, 0777, true);
        }
    }

    /**
     * 保存文件
     * @param  string $src  文件路径
     * @param  string $data 内容
     * @return boolean       是否成功
     */
    private function saveFile($src, $data) {
        return file_put_contents($src, $data, FILE_APPEND);
    }

    /**
     * 通过当前反馈类型，获取日志文件路径
     * @param string $time 时间
     * @return string 文件路径
     */
    private function getSrc($time) {
        $dir = $this->logDir;
        $src;
        switch ($this->setNameType) {
            case 1:
                $timeYm = substr($time, 0, 4) . substr($time, 5, 2);
                $src = $dir . $this->ds . $timeYm . $this->suffix;
                break;
            case 2:
                $timeYm = substr($time, 0, 4) . substr($time, 5, 2);
                $timeD = substr($time, 8, 2);
                $dir .= $this->ds . $timeYm;
                $src = $dir . $this->ds . $timeD . $this->suffix;
                break;
            case 3:
                $timeYm = substr($time, 0, 4) . substr($time, 5, 2);
                $timeD = substr($time, 8, 2);
                $timeH = substr($time, 11, 2);
                $dir .= $this->ds . $timeYm;
                $src = $dir . $this->ds . $timeD . '-' . $timeH . $this->suffix;
                break;
            case 4:
                $timeY = substr($time, 0, 4);
                $timeM = substr($time, 5, 2);
                $timeD = substr($time, 8, 2);
                $timeH = substr($time, 11, 2);
                $dir .= $this->ds . $timeY . $this->ds . $timeM;
                $src = $dir . $this->ds . $timeD . '-' . $timeH . $this->suffix;
                break;
        }
        if (!is_dir($dir)) {
            mkdir($dir, '0777', true);
        }
        return $src;
    }

    /**
     * 搜索文件夹下的所有日志文件
     * @param string $dir 目录
     * @return array 文件数组
     */
    private function viewFileList($dir) {
        return glob($dir . $this->ds . '*' . $this->suffix);
    }

    /**
     * 遍历出目录下所有日志文件
     * @param string $dir 目录
     * @return array 文件数组
     */
    private function viewAllFile($dir) {
        if (!is_dir($dir)) {
            return null;
        }
        $arr;
        $list = glob($dir . $this->ds . '*');
        foreach ($list as $v) {
            if (is_dir($v)) {
                $vArr = $this->viewAllFile($v);
                if (is_array($vArr)) {
                    $arr = array_merge($arr, $vArr);
                }
            } else {
                $arr[] = $v;
            }
        }
        return $arr;
    }

}

?>