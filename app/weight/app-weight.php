<?php
/**
 * 体重记录类
 * @author fotomxq <fotomxq.me>
 * @version 3
 * @package app-weight-lib
 */

class AppWeight{
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
	private $fields = array('id','user_id','weight_date','weight_weight','weight_fat','weight_tag_dinner','weight_tag_sport','weight_tag_sleep','weight_tag_toilet','weight_tag_sick','weight_tag_alcohol','weight_note');
	
	/**
	 * 用户ID
	 * @var int
	 */
	private $userID;

	/**
	 * 初始化
	 * @param CoreDB $db        数据库对象
	 * @param string $tableName 数据表名称
	 * @param int $userID    用户ID
	 */
	public function __construct(&$db,$tableName,$userID){
		$this->db = $db;
		$this->tableName = $tableName;
		$this->userID = $userID;
	}

	/**
	 * 查看指定日期的记录
	 * @param  string $startDate 开始日期
	 * @param  string $endDate   截止日期，如果给定null则表明查询某个日期的记录
	 * @param string $avg  是否获取该时间段的某个健位的平均值
	 * @return array            记录组，失败则返回null
	 */
	public function view($startDate,$endDate=null,$avg=null){
		$where = '`'.$this->fields[1].'` = :userID AND ';
		$attrs = array(':userID'=>array($this->userID,PDO::PARAM_INT),':start'=>array($startDate,PDO::PARAM_STR));
		if($endDate == null){
			$where .= '`'.$this->fields[2].'` = :start';
			return $this->db->sqlSelect($this->tableName,$this->fields,$where,$attrs);
		}else{
			$where .= '`'.$this->fields[2].'` >= :start AND `'.$this->fields[2].'` <= :end';
			$attrs[':end'] = array($endDate,PDO::PARAM_STR);
			if($avg == null){
				return $this->db->sqlSelect($this->tableName,$this->fields,$where,$attrs,1,99999,$this->fields[2],false);
			}else{
				$avgField = isset($this->fields[$avg]) == true ? $this->fields[$avg] : $this->fields[0];
				$sql = 'SELECT AVG(`'.$avgField.'`) FROM `'.$this->tableName.'` WHERE '.$where;
				return $this->db->runSQL($sql,$attrs,2,0);
			}
		}
	}

	/**
	 * 获取最近的数据
	 * @param  int $max 条数
	 * @return array 记录组
	 */
	public function viewTop($max=10){
		$where = '`'.$this->fields[1].'` = :userID';
		$attrs = array(':userID'=>array($this->userID,PDO::PARAM_INT));
		return $this->db->sqlSelect($this->tableName,$this->fields,$where,$attrs,1,$max,$this->fields[2],false);
	}

	/**
	 * 设定体重记录
	 * @param float  $weight     体重，如“85.63”；给定0表明忽略该记录
	 * @param string  $date       自定义日期，不提供则表明为当天
	 * @param float  $fat        脂肪量，如"0.6"，给定0表明忽略该记录
	 * @param string  $note       备注
	 * @param boolean $tagDinner  标签饭后
	 * @param boolean $tagSport   标签运动
	 * @param boolean $tagSleep   标签睡觉
	 * @param boolean $tagToilet  标签厕所
	 * @param boolean $tagSick    标签生病
	 * @param boolean $tagAlcohol 标签饮料/水/酒后
	 * @return int 操作的记录ID，失败则返回0
	 */
	public function set($weight,$date=null,$fat=null,$note=null,$tagDinner=false,$tagSport=false,$tagSleep=false,$tagToilet=false,$tagSick=false,$tagAlcohol=false){
		$date = $date == null ? date('Y-m-d') : $date;
		$weight = (float) $weight;
		$fat = $fat == null ? 0 : (float) $fat;
		$note = !$note ? null : $note;
		$tagDinner = $tagDinner ? '1' : '0';
		$tagSport = $tagSport ? '1' : '0';
		$tagSleep = $tagSleep ? '1' : '0';
		$tagToilet = $tagToilet ? '1' : '0';
		$tagSick = $tagSick ? '1' : '0';
		$tagAlcohol = $tagAlcohol ? '1' : '0';
		$where = '`'.$this->fields[2].'` = :date and `'.$this->fields[1].'` = :userID';
		$attrs = array(':date'=>array($date,PDO::PARAM_STR),':userID'=>array($this->userID,PDO::PARAM_INT));
		$res = $this->db->sqlSelect($this->tableName,array($this->fields[0]),$where,$attrs);
		if($res){
			$where = '`'.$this->fields[0].'` = :id';
			$sets = array($this->fields[3]=>$weight,$this->fields[5]=>$tagDinner,$this->fields[6]=>$tagSport,$this->fields[7]=>$tagSleep,$this->fields[8]=>$tagToilet,$this->fields[9]=>$tagSick,$this->fields[10]=>$tagAlcohol);
			$attrs = array(':id'=>array($res['id'],PDO::PARAM_INT));
			if($fat !== null){
				$sets[$this->fields[4]] = ':fat';
				$attrs[':fat'] = array($fat,PDO::PARAM_STR);
			}
			if($note !== null){
				$sets[$this->fields[11]] = ':note';
				$attrs[':note'] = array($note,PDO::PARAM_STR);
			}
			if($this->db->sqlUpdate($this->tableName,$sets,$where,$attrs)){
				return $res['id'];
			}
			return 0;
		}else{
			$value = 'NULL,:userID,:date,:weight,:fat,\'' . $tagDinner . '\',\'' . $tagSport . '\',\'' . $tagSleep . '\',\'' . $tagToilet . '\',\'' . $tagSick . '\',\'' . $tagAlcohol . '\',:note';
			$attrs = array(':userID'=>array($this->userID,PDO::PARAM_INT),':date'=>array($date,PDO::PARAM_STR),':weight'=>array($weight,PDO::PARAM_STR),':fat'=>array($fat,PDO::PARAM_STR),':note'=>array($note,PDO::PARAM_STR));
			return $this->db->sqlInsert($this->tableName,$this->fields,$value,$attrs);
		}
	}
}
?>