<?php

/**
 * IP处理器
 * @author liuzilu <fotomxq@gmail.com>
 * @version 4
 */
class SysIP {

    /**
     * 数据库对象
     * @var CoreDB
     */
    private $db;

    /**
     * 表名称
     * @var string
     */
    private $tableName;

    /**
     * 字段组
     * @var array
     */
    private $fields = array('id', 'ip_addr', 'ip_real', 'ip_ban');

    /**
     * 当前IP索引ID
     * @var int
     */
    public $nowID = 0;
    
    /**
     * 当前Ip地址
     * @var string 
     */
    public $nowAddr;

    /**
     * 定位匹配的Key组
     * @var array
     */
    private $keys;

    /**
     * 初始化
     * @param CoreDB $db 数据库对象
     * @param string $tableName 表名称
     * @param array $keys 匹配的Key组
     * @return string IP地址
     */
    public function __construct(&$db, $tableName, $keys) {
        $this->db = $db;
        $this->tableName = $tableName;
        $this->nowAddr = $this->getIP();
        $this->nowID = $this->add($this->nowAddr);
        $this->keys = $keys;
    }

    /**
     * 查看ID信息
     * @param  int $id 索引
     * @return array 数据数组
     */
    public function view($id) {
        $where = '`' . $this->fields[0] . '` = :id';
        $attrs = array(':id' => array($id, PDO::PARAM_INT));
        return $this->db->sqlSelect($this->tableName, $this->fields, $where, $attrs);
    }

    /**
     * 查询列表
     * @param string $ipAddr 搜索的IP地址
     * @param string $real 搜索的真实地址
     * @param boolean $ban 是否被禁止访问
     * @param int $page 页数
     * @param int $max 页长
     * @param int $sort 排序字段键值
     * @param boolean $desc 是否倒叙
     * @return array 数据数组
     */
    public function viewList($ipAddr = null, $real = null, $ban = null, $page = 1, $max = 10, $sort = 0, $desc = false) {
        $where = '1';
        $attrs = null;
        if ($ipAddr !== null) {
            $where = '`' . $this->fields[1] . '` LIKE :addr';
            $attrs = array(':addr' => array('%' . $ipAddr . '%', PDO::PARAM_STR));
        }
        if ($real !== null) {
            if ($ipAddr !== null) {
                $where .= ' or ';
            }
            $where .= '`' . $this->fields[2] . '` LIKE :real';
            $attrs[':real'] = array($real, PDO::PARAM_STR);
        }
        if ($ban !== null) {
            if ($ipAddr !== null || $real !== null) {
                $where .= ' or ';
            }
            $banStr = $ban == true ? '1' : '0';
            $where .= '`' . $this->fields[3] . '` LIKE \'' . $banStr . '\'';
        }
        $sortField = isset($this->fields[$sort]) == true ? $this->fields[$sort] : $this->fields[0];
        $res = $this->db->sqlSelect($this->tableName, $this->fields, $where, $attrs, $page, $max, $sortField, $desc);
        if ($res) {
            $res[0]['max'] = $this->db->sqlSelectCount($this->tableName, $this->fields, $where, $attrs);
        }
        return $res;
    }

    /**
     * 是否拉黑
     * @param  string  $src IP地址
     * @return boolean 是否拉黑
     */
    public function isBan($src) {
        $res;
        if (is_int($src) == true) {
            $res = $this->view($src);
        } else {
            $where = '`' . $this->fields[1] . '` = :addr';
            $attrs = array(':addr' => array($src, PDO::PARAM_STR));
            $res = $this->db->sqlSelect($this->tableName, $this->fields, $where, $attrs);
        }
        if ($res) {
            if ((int) $res[$this->fields[3]] > 0) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * 设置拉黑状态
     * @param string  $src IP地址
     * @param boolean $ban 是否拉黑
     * @return boolean 是否成功
     */
    public function setBan($src, $ban = false) {
        $where;
        $attrs;
        if (is_int($src) == true) {
            $where = '`' . $this->fields[0] . '` = :id';
            $attrs = array(':id' => array($src, PDO::PARAM_INT));
        } else {
            $where = '`' . $this->fields[1] . '` = :addr';
            $attrs = array(':addr' => array($src, PDO::PARAM_STR));
        }
        $banStr = $ban ? '1' : '0';
        $sets = array($this->fields[3] => $banStr);
        return $this->db->sqlUpdate($this->tableName, $sets, $where, $attrs);
    }

    /**
     * 设置真实地址
     * <p>如果提供的real为空，则通过api获取.</p>
     * @param int $id 索引
     * @param string $real 真实地址
     * @return boolean 是否成功
     */
    public function setReal($id, $real) {
        if (!$real) {
            $res = $this->view($id);
            if ($res) {
                $real = $this->getIPAddress($res['ip_addr']);
            }
        }
        $sets = array($this->fields[2] => ':real');
        $where = '`' . $this->fields[0] . '` = :id';
        $attrs = array(':real' => array($real, PDO::PARAM_STR), ':id' => array($id, PDO::PARAM_INT));
        return $this->db->sqlUpdate($this->tableName, $sets, $where, $attrs);
    }

    /**
     * 添加新的地址
     * @param string $ipAddr IP地址
     * @return int 新索引
     */
    private function add($ipAddr) {
        $where = '`' . $this->fields[1] . '` = :addr';
        $attrs = array(':addr' => array($ipAddr, PDO::PARAM_STR));
        $res = $this->db->sqlSelect($this->tableName, $this->fields, $where, $attrs);
        if ($res) {
            return $res[$this->fields[0]];
        } else {
            $value = 'NULL,:addr,\'\',0';
            $attrs = array(':addr' => array($ipAddr, PDO::PARAM_STR));
            return $this->db->sqlInsert($this->tableName, $this->fields, $value, $attrs);
        }
    }

    /**
     * 获取IP地址
     * @return string IP地址
     */
    private function getIP() {
        $ip = '';
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } elseif (isset($_SERVER["HTTP_CLIENT_IP"])) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        } elseif (isset($_SERVER["REMOTE_ADDR"])) {
            $ip = $_SERVER["REMOTE_ADDR"];
        } elseif (getenv("HTTP_X_FORWARDED_FOR")) {
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        } elseif (getenv("HTTP_CLIENT_IP")) {
            $ip = getenv("HTTP_CLIENT_IP");
        } elseif (getenv("REMOTE_ADDR")) {
            $ip = getenv("REMOTE_ADDR");
        } else {
            $ip = "0.0.0.0";
        }
        return $ip;
    }

    /**
     * 获取IP物理地址
     * @param  string $ip IP地址
     * @return string     地址
     */
    private function getIPAddress($ip) {
        $res;
        if (isset($this->keys['baidu'])) {
            $url = 'http://api.map.baidu.com/location/ip?ak=' . $this->keys['baidu'] . '&ip=' . $ip;
            $dataJson = file_get_contents($url);
            if ($dataJson) {
                $data = json_decode($dataJson, true);
                if ($data['status'] == '0') {
                    $res = $data['address'];
                }
            }
        }
        if (!$res && $this->keys['blueera']) {
            $url = 'http://ip.blueera.net/api?ip=' . $ip;
            $dataJson = file_get_contents($url);
            if ($dataJson) {
                $data = json_decode($dataJson, true);
                if ($data['country']) {
                    $res = $data['isp'] . '-' . $data['country'] . $data['province'] . $data['city'];
                }
            }
        }
        return $res;
    }

}

?>