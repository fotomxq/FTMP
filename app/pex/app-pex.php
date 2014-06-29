<?php

/**
 * PEX处理器
 * @authors fotomxq <fotomxq.me>
 * @date    2014-06-29 10:02:50
 * @version 1
 */
class AppPex {

    /**
     * 文件数据表
     * @var string 
     */
    private $fileTableName = 'app_pex_file';

    /**
     * 文件夹数据表
     * @var string
     */
    private $folderTableName = 'app_pex_folder';

    /**
     * 标签数据表
     * @var string 
     */
    private $tagTableName = 'app_pex_tag';

    /**
     * 文件和文件夹关系数据表
     * @var string
     */
    private $fxTableName = 'app_pex_fx';

    /**
     * 文件和标签数据表
     * @var string
     */
    private $txTableName = 'app_pex_tx';

    /**
     * 数据库对象
     * @var CoreDB 
     */
    private $db;

    /**
     * 文件数据表字段
     * @var array 
     */
    private $fileFields = array('id', 'file_name', 'file_title', 'file_sha1', 'file_time', 'file_src', 'file_size', 'file_type');

    /**
     * 文件夹数据表字段
     * @var array 
     */
    private $folderFields = array('id', 'folder_name', 'folder_parent', 'folder_create_time', 'folder_visit_time', 'folder_size', 'folder_folder_count', 'folder_file_count');

    /**
     * 标签数据表字段
     * @var array
     */
    private $tagFields = array('id', 'tag_name', 'tag_type');

    /**
     * 文件和文件夹关系数据表字段
     * @var array 
     */
    private $fxFields = array('id', 'file_id', 'folder_id');

    /**
     * 文件和标签关系数据表字段
     * @var array
     */
    private $txFields = array('id', 'file_id', 'tag_id');

    /**
     * 类型
     * key-键值,用于tag表等类型标记 ; folder-对应文件夹ID ; title-名称
     * @var array 
     */
    private $pexType = array(
        'photo' => array('key' => 'photo', 'folder' => 1, 'title' => '照片'),
        'movie' => array('key' => 'movie', 'folder' => 2, 'title' => '影片'),
        'cartoon' => array('key' => 'cartoon', 'folder' => 3, 'title' => '漫画'),
        'txt' => array('key' => 'txt', 'folder' => 4, 'title' => '文本')
    );

    /**
     * 文件类型
     * @var array 
     */
    private $fileType = array(
        'photo' => array('jpg', 'png', 'gif'),
        'movie' => array('mp4'),
        'cartoon' => array('jpg', 'png'),
        'txt' => array('txt')
    );

    /**
     * 文件数据目录路径
     * @var string
     */
    private $dataFolderSrc;

    public function __construct(&$db, $dataFolderSrc) {
        $this->db = $db;
        $this->dataFolderSrc = $dataFolderSrc;
    }

    public function uploadFile() {
        
    }

    public function transferFile() {
        
    }

    public function cutFile($fxID, $FolderID) {
        
    }

    public function copyFile($fileID, $folderID) {
        
    }

    public function delFile($fxID) {
        
    }

    public function addTag($name, $type) {
        
    }

    public function addTx($fileID, $tagID) {
        
    }

    public function editTag($id, $name) {
        
    }

    public function delTx($id) {
        
    }

    public function delTag($id) {
        
    }

    public function addFolder($parent, $name) {
        
    }

    public function updateFolderTime($id) {
        
    }

    public function updateFolderInfo($id) {
        
    }

    public function editFolder($id, $name, $parent) {
        
    }

    public function delFolder($id) {
        
    }

}

?>