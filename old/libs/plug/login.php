<?php

/**
 * 登录处理模块
 * <p>模块分为三个部分，登录、检查登录状态、退出登录部分。</p>
 * <p>处理登录Session和计时器处理。</p>
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package plug
 */
class PlugLogin {

    /**
     * Session操作对象
     * @var CoreSession
     */
    private $session;

    /**
     * 会话保存变量名称
     * @var string
     */
    private $varName;

    /**
     * 当前登录状态变量名称
     * @var string 
     */
    private $varStatusName;

    /**
     * 时间计数变量名称
     * @var string 
     */
    private $varTimeName;

    public function __construct(&$session, $varName) {
        $this->session = &$session;
        $this->varName = $varName;
        $this->varStatusName = $varName . '-Status';
        $this->varTimeName = $varName . '-Time';
    }

    /**
     * 登录
     * <p>如果登录失败，则返回用户提交值和对比值出错的数组键值。</p>
     * @param array $userInputs 用户提交值
     * @param array $checkVars 对比值
     * @return boolean 是否登录成功
     */
    public function login($userInputs = null, $checkVars = null) {
        if ($this->checkStatus() === true) {
            return true;
        } else {
            if ($userInputs != null && $checkVars != null) {
                foreach ($userInputs as $k => $v) {
                    if ($checkVars[$k] != $v) {
                        return $k;
                    }
                }
            }
            $this->saveStatus(true);
            $this->saveTime();
            return true;
        }
        return false;
    }

    /**
     * 检查当前登录状态
     * @param int $timeout 超时时间(秒s)
     * @return boolean 是否已登录
     */
    public function checkStatus($timeout = 1200) {
        $status = $this->getStatus();
        if ($status === true) {
            $statusTime = $this->checkTimeout($timeout);
            if ($statusTime === true) {
                $this->saveTime();
                return true;
            }
        }
        return false;
    }

    /**
     * 退出登录
     */
    public function logout() {
        $this->saveStatus(false);
        $this->session->clear($this->varStatusName);
        $this->session->clear($this->varTimeName);
    }

    /**
     * 获取会话登录状态记录
     * @return boolean 是否已登录
     */
    private function getStatus() {
        return $this->session->get($this->varStatusName);
    }

    /**
     * 保存登录状态
     * @param boolean $bool 登录状态布尔值
     */
    private function saveStatus($bool) {
        $this->session->save($this->varStatusName, $bool);
    }

    /**
     * 获取会话时间记录
     * @return int Unix时间戳
     */
    private function getTime() {
        return $this->session->get($this->varTimeName);
    }

    /**
     * 保存当前时间到会话变量
     */
    private function saveTime() {
        $this->session->save($this->varTimeName, $this->getNowTime());
    }

    /**
     * 获取当前Unix时间戳
     * @return int Unix时间戳
     */
    private function getNowTime() {
        return time();
    }

    /**
     * 检查是否超时
     * @param int $timeout 超时时间(秒s)
     * @return boolean 是否超时
     */
    private function checkTimeout($timeout = 1200) {
        if ($timeout > 0) {
            $nowTime = $this->getNowTime();
            $varTime = $this->getTime();
            $t = $nowTime - $varTime;
            if ($t < $timeout) {
                return true;
            }
        }
        return false;
    }

}

?>