<?php

/**
 * session会话操作类
 * @author fotomxq <fotomxq.me>
 * @version 3
 * @package core
 */
class CoreSession {

    /**
     * 初始化
     */
    public function __construct() {
        @session_start();
    }

    /**
     * 获取session变量
     * @param string $name session名称
     * @return mixed 值
     */
    public function get($name) {
        if (isset($_SESSION[$name]) == true) {
            return $_SESSION[$name];
        } else {
            return null;
        }
    }

    /**
     * 保存session
     * @param string $name 名称
     * @param mixed $value 值
     */
    public function save($name, $value) {
        $_SESSION[$name] = $value;
    }

    /**
     * 清理session
     * @param string $name 名称
     */
    public function clear($name = null) {
        if ($name == null) {
            $_SESSION = null;
            unset($_SESSION);
        } else {
            $_SESSION[$name] = null;
            unset($_SESSION[$name]);
        }
    }

    /**
     * 获取所有session
     */
    private function getSession() {
        $this->session = &$_SESSION;
    }

}

?>
