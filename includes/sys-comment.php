<?php
/**
 * 评论处理器
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package sys
 */

class SysComment{
	/**
	 * 数据库对象
	 * @var CoreDB
	 */
	private $db;

	/**
	 * 数据表名称
	 * @var string
	 */
	private $tableName;

	/**
	 * 字段组
	 * @var array
	 */
	private $fields = array('id','post_id','comment_status','comment_author','comment_content','comment_date','comment_ip','comment_parent','comment_sha1','user_id');

	/**
	 * 状态
	 * wait-等待审核;public-发布;trash-垃圾;recycle-回收站
	 * @var array
	 */
	private $status = array('wait'=>0,'public'=>1,'trash'=>2,'recycle'=>3);

	/**
	 * 初始化
	 * @param CoreDB $db        数据库对象
	 * @param string $tableName 数据表名称
	 */
	public function __construct(&$db,$tableName){
		$this->db = $db;
		$this->tableName = $tableName;
	}

	public function viewList($where,$attrs,$page=1,$max=10,$sort=4,$desc=true){
	}

	public function add($data){
		$sql = 'INSERT INTO `'.$this->tableName.'`() VALUES()';
		return false;
	}
	public function edit($id,$data){
		$sql = '';
	}

	/**
	 * 审核评论
	 * @param  int $id     ID
	 * @param  string $status 状态键位
	 * @return boolean         是否成功
	 */
	public function audit($id,$status){
		$where = '`'.$this->fields[0].'` = :id';
		$sets = array($this->fields[2]=>':status');
		$statusStr = isset($this->status[$status]) == true ? $this->status[$status] : $this->status[0];
		$attrs = array(':id'=>array($id,PDO::PARAM_INT),':status'=>array($statusStr,PDO::PARAM_INT));
		return $this->db->sqlUpdate($this->tableName,$sets,$where,$attrs);
	}
	
	public function del($id){
	}
	public function delPOST($postID){
	}

	/**
	 * 删除所有评论
	 * @return [type] [description]
	 */
	public function delAll(){
		$sql = 'DELETE FROM `'.$this->tableName.'`';
		return $this->db->runSQLExec($sql);
	}

	/**
	 * 查询评论个数
	 * @param  int $postID POST ID,如果统计全部则为0
	 * @return int          评论个数
	 */
	public function getCount($postID = 0){
		$sql = 'SELECT COUNT(`'.$this->fields[0].'`) FROM `'.$this->tableName.'` WHERE ';
		$attrs = null;
		if($postID == 0){
			$sql .= '1';
		}else{
			$sql .= '`'.$this->fields[1].'` = :postID';
			$attrs = array(':postID'=>array($postID,PDO::PARAM_INT));
		}
		return $this->db->runSQL($sql,$attrs,2,0);
	}

	/**
	 * 获取SHA1
	 * @param  string $str 字符串
	 * @return string      SHA1
	 */
	private function getSHA1(&$str){
		return sha1($str);
	}
}

?>