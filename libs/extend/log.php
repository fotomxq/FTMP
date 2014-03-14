<?php

/**
 * 日志操作类
 * <p>需要类 : CoreFile & CoreDB</p>
 * <p>需要常量 : DS</p>
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package extend
 */
class ExtendLog {
	/**
	 * 数据库操作句柄
	 * @var CoreDB
	 */
	private $db;

	/**
	 * 日志表名称
	 * @var string
	 */
	private $tableName;

	/**
	 * 日志所在目录
	 * @var string
	 */
	private $logDir;

	/**
	 * 初始化
	 * @param CoreDB $db 数据库操作句柄
	 * @param string $logDir 日志所在目录
	 */
	public function __construct(&$db,$logDir){
		$this->db = $db;
		$this->logDir = $logDir;
	}

	/**
	 * 添加日志
	 * @param int $app 应用ID,如果为空则为0
	 * @param string $message 消息
	 */
	public function add($app,$message){
		$sql = 'INSERT INTO `'.$this->tableName.'`(`id`,`log_app`,`log_time`,`log_ip`,`log_message`) VALUES(NULL,:app,NOW(),:message);';
		$attrs = array(':app'=>array($app,PDO::PARAM_INT),':message'=>array($message,PDO::PARAM_STR));
		return $this->db->prepareAttr($sql,$attrs,0,null);
	}

	/**
	 * 归档日志
	 * @return boolean 是否成功
	 */
	public function file(){
		$sqlCount = 'SELECT count(`id`) as `count` FROM `'.$this->tableName.'`;';
		$count = $this->db->prepareAttr($sqlCount,null,2,0);
		if(abs($count) > 0){
			//遍历表，导出数据
			$page = 0;
			$max = 50;
			$bool = true;
			do{
				$sqlSelect = 'SELECT * FROM `'.$this->tableName.'` LIMIT '.($page*$max).','.$max;
				$result = $this->db->prepareAttr($sqlSelect,null,3,PDO::FETCH_ASSOC);
				if($result){
					foreach($result as $v){
						$dateYM = substr($v['log_time'],0);
						$dateD = date('d');
						//生成目录
						$dir = $this->logDir.DS.$dateYM;
						CoreFile::newDir($dir);
						//生成文件路径
						$src = $dir.DS.$dateYM.$dateD.'.log';
						//加入日志
					}
				}else{
					$bool = false;
				}
				$page ++;
			}while($bool == true);
			//清空表
			$this->clearTable();
		}
		return true;
	}

	public function viewList($page,$max){
	}

	public function viewFile($date){
	}

	/**
	 * 清空日志表
	 */
	private function clearTable(){
		$sql = 'TRUNCATE TABLE `'.$this->tableName.'`;';
		$this->db->exec($sql);
	}
}

?>