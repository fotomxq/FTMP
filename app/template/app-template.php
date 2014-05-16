<?php

/**
 * APP简易模版
 * @author fotomxq <fotomxq.me>
 * @version 2
 * @package app-template
 */
class AppTemplate {

    /**
     * 数据库对象
     * @var CoreDB 
     */
    public $db;

    /**
     * 数据表名称
     * @var string 
     */
    public $tableName;

    /**
     * 字段组
     * @var array 
     */
    public $fields;

    /**
     * 初始化
     * @param CoreDB $db 数据库对象
     * @param string $tableName 数据表名称
     * @param array $fields 字段组
     */
    public function __construct($db, $tableName, $fields) {
        $this->db = $db;
        $this->tableName = $tableName;
        $this->fields = $fields;
    }

    /**
     * 查询列
     * @param string $where 条件
     * @param array $attrs 过滤数组
     * @param int $page 页数
     * @param int $max 页长
     * @param int $sort 排序键值
     * @param boolean $desc 是否倒叙
     * @return array 数据数组
     */
    public function viewList($where = '1', $attrs = null, $page = 1, $max = 10, $sort = 0, $desc = false) {
        $sortField = isset($this->fields[$sort]) == true ? $this->fields[$sort] : $this->fields[0];
        return $this->db->sqlSelect($this->tableName, $this->fields, $where, $attrs, $page, $max, $sortField, $desc);
    }

    /**
     * 查看ID
     * @param int $id ID
     * @return array 数据数组
     */
    public function view($id) {
        $where = '`' . $this->fields[0] . '` = :id';
        $attrs = array(':id' => array($id, PDO::PARAM_INT));
        return $this->db->sqlSelect($this->tableName, $this->fields, $where, $attrs);
    }

    /**
     * 设定ID
     * @param int $id ID
     * @param array $sets 设定组,array(字段名=>:值)
     * @param array $attrs 过滤组
     * @return boolean 是否成功
     */
    public function edit($id, $sets, $attrs) {
        $where = '`' . $this->fields[0] . '` = :id';
        $attrs[':id'] = array($id, PDO::PARAM_INT);
        return $this->db->sqlUpdate($this->tableName, $sets, $where, $attrs);
    }

    /**
     * 删除ID
     * @param int $id ID
     * @return boolean 是否成功
     */
    public function del($id) {
        $where = '`' . $this->fields[0] . '` = :id';
        $attrs = array(':id' => array($id, PDO::PARAM_INT));
        return $this->db->sqlDelete($this->tableName, $where, $attrs);
    }

}

?>