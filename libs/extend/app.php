<?php

/**
 * 应用管理类
 * <p>需要类 : CoreFile & CoreDB & ExtendReg</p>
 * <p>需要常量 : DS</p>
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package extend
 */

class ExtendApp{
	/**
	 * 数据表名称
	 * @var string
	 */
	private $tableName;

	/**
	 * 数据库句柄
	 * @var CoreDB
	 */
	private $db;

	/**
	 * 注册句柄
	 * @var ExtendReg
	 */
	private $reg;

	/**
	 * 字段数组
	 * @var array
	 */
	private $fields = array('id','app_name','app_des');

	/**
	 * 字段组合
	 * @var string
	 */
	private $fieldSQL = '';

	/**
	 * 初始化
	 * @param CoreDB $db        数据库句柄
	 * @param ExtendReg $reg       注册句柄
	 * @param string $tableName 数据表名称
	 */
	public function __construct(&$db,&$reg,$tableName){
		$this->db = $db;
		$this->reg = $reg;
		$this->tableName = $tableName;
	}
	public function viewAll(){
		$sql = 'SELECT '.$this->fieldSQL.' FROM `'.$this->tableName.'`;';
		$result = $this->db->prepareAttr($sql,null,PDO)
	}
	public function load($appID){
	}
	public function install($appName){
	}
	public function uninstall(){
	}
	private function addDB($sql){
	}
	private function deleteDB(){
	}
	private function addFile(){
	}
	private function deleteFile(){
	}

	/**
	 * 组合字段
	 */
	private function mergeFields(){
		$this->fieldSQL = '`'.implode('`,`',$this->fields).'`'
	}
}
?>