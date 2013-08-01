<?php

/**
 * 配置类
 * <p>额外：DB_PREFIX</p>
 * @author fotomxq <fotomxq.me>
 * @version 2
 * @package sys
 */
class SysOption {

    /**
     * 数据库句柄
     * @var CoreDB
     */
    private $db;

    /**
     * 表名称
     * @var string 
     */
    private $tableName;

    /**
     * 字段列
     * @var array 
     */
    private $fields = array('id', 'group', 'name', 'value', 'default');

    /**
     * 内部配置缓冲
     * @var array 
     */
    private $vals;

    /**
     * 初始化
     * @param CoreDB $db 数据库句柄
     */
    public function __construct(&$db) {
        $this->db = $db;
        $this->tableName = DB_PREFIX . 'option';
    }

    /**
     * 获取配置
     * @param string $name 获取名称
     * @return string 配置值
     */
    public function load($name) {
        $sql = 'SELECT `' . $this->fields[3] . '` FROM `' . $this->tableName . '` WHERE `' . $this->fields[2] . '` = :name';
        $attrs = array(':name' => array($name, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT));
        return $this->db->prepareAttr($sql, $attrs, 2, 0);
    }

    /**
     * 保存配置
     * @param array $vals 新的配置数组 eg: array('config1'=>'value1',...)
     * @return boolean 是否成功
     */
    public function save($vals) {
        try {
            $this->db->beginTransaction();
            $sql = 'UPDATE `' . $this->tableName . '` SET';
            foreach ($vals as $k => $v) {
                $where = '';
                $key = '';
                $attrs;
                if (is_int($v) == true) {
                    $key = ':id' . $k;
                    $where = ' `id` = ' . $key . 'w';
                    $attrs[$key] = array($v, PDO::PARAM_INT);
                } else {
                    $key = ':name' . $k;
                    $where = ' `' . $this->fields[2] . '` = ' . $key . 'w';
                    $attrs[$key] = array($v, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT);
                }
                $sql .= ' `' . $this->fields[3] . '` = ' . $key . ' WHERE' . $where;
                $attrs[$key . 'w'] = array($k, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT);
                $this->db->prepareAttr($sql, $attrs);
            }
            return $this->db->commit();
        } catch (PDOException $e) {
            $this->db->rollBack();
            return false;
        }
    }

    /**
     * 还原配置
     * @param string|int|array $names 单个或多个配置，且细分为配置名称或Id
     * @return boolean
     */
    public function restore($names = '') {
        if ($names == '') {
            $sql = 'UPDATE `' . $this->tableName . '` SET `' . $this->fields[3] . '` = `' . $this->fields[4] . '`';
            return $this->db->exec($sql) !== false ? true : false;
        } else {
            $sql = 'UPDATE `' . $this->tableName . '` SET `' . $this->fields[3] . '` = `' . $this->fields[4] . '` WHERE';
            $where = '';
            $attrs;
            if (is_string($names) == true || is_int($names) == true) {
                if (is_string($names) == true) {
                    $where = '`' . $this->fields[2] . '` = :name';
                    $attrs = array(':name' => array($names, PDO::PARAM_STR));
                } else {
                    $where = '`' . $this->fields[0] . '` = :id';
                    $attrs = array(':id' => array($names, PDO::PARAM_INT));
                }
                $sql .= ' ' . $where;
                return $this->db->prepareAttr($sql, $attrs);
            } else {
                foreach ($names as $k => $v) {
                    $key = '';
                    if (is_int($v) == true) {
                        $key = ':id' . $k;
                        $where .= ' OR `' . $this->fields[0] . '` = ' . $key;
                    } else {
                        $key = ':name' . $k;
                        $where .= ' OR `' . $this->fields[2] . '` = ' . $key;
                    }
                    $attrs[$key] = array($v, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT);
                }
                $where = substr($where, 4);
                $sql .= ' ' . $where;
                return $this->db->prepareAttr($sql, $attrs);
            }
        }
    }

}

?>
