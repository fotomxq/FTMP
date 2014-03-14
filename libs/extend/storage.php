<?php

/**
 * 存储点操作类
 * <p>需要类 : CoreDB</p>
 * <p>需要常量 : DS</p>
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package extend
 */

class ExtendStorage{
	private $db;
	public function __construct(&$db){
		$this->db = $db;
	}
	public function addStorage(){
	}
	public function updateStorage(){
	}
	public function deleteStorage(){
	}
}
?>