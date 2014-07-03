<?php

/**
 * PEX处理器
 * @authors fotomxq <fotomxq.me>
 * @date    2014-06-29 10:02:50
 * @version 1
 */
class AppPex {

    /**
     * 标签数据表
     * @var string 
     */
    private $tagTableName = 'app_pex_tag';

    /**
     * 文件数据表名称
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
     * 标签数据表字段
     * @var array
     */
    private $tagFields = array('id', 'tag_name', 'tag_type', 'tx_type');

    /**
     * 文件数据表字段
     * @var array 
     */
    private $fxFields = array('id', 'fx_title', 'fx_name', 'fx_parent', 'fx_size', 'fx_type', 'fx_sha1', 'fx_src', 'fx_create_time', 'fx_visit_time', 'fx_content');

    /**
     * 文件和标签关系数据表字段
     * @var array
     */
    private $txFields = array('id', 'fx_id', 'tag_id');

    /**
     * 文件和标签关系表类型
     * @var array 
     */
    private $txType = array('file', 'folder');

    /**
     * 类型
     * key-键值,用于tag表等类型标记 ; folder-对应文件夹ID ; title-名称
     * @var array 
     */
    private $pexType = array(
        'photo' => array('key' => 'photo', 'folder' => 1, 'title' => '照片', 'type' => array('jpg', 'png', 'gif')),
        'movie' => array('key' => 'movie', 'folder' => 2, 'title' => '影片', 'type' => array('mp4')),
        'cartoon' => array('key' => 'cartoon', 'folder' => 3, 'title' => '漫画', 'cartoon' => array('jpg', 'png')),
        'txt' => array('key' => 'txt', 'folder' => 4, 'title' => '文本', 'txt' => array('txt'))
    );

    /**
     * 文件数据目录路径
     * @var string
     */
    private $dataFolderSrc;

    /**
     * 文件数据目录
     * @var string
     */
    private $dataFolderFileSrc;

    /**
     * 缓冲图片目录
     * @var string
     */
    private $dataFolderCacheImgsSrc;

    /**
     * 等待发布文件目录
     * @var string
     */
    private $dataFolderTransferSrc;

    /**
     * 初始化
     * @param CoreDB $db            数据库对象
     * @param string $dataFolderSrc 文件数据目录路径
     */
    public function __construct(&$db, $dataFolderSrc) {
        $this->db = $db;
        $this->dataFolderSrc = $dataFolderSrc;
        $this->dataFolderFileSrc = $dataFolderSrc . DS . 'file';
        $this->dataFolderCacheImgsSrc = $dataFolderSrc . DS . 'imgs';
        $this->dataFolderTransferSrc = $dataFolderSrc . DS . 'transfer';
    }

    public function uploadFile($files) {
        //暂时不支持上传文件
    }

    /**
     * 查询等待转移文件
     * @param int $page 页数
     * @param int $max 页长
     * @return array 数据数组
     */
    public function transferList($page = 1, $max = 10) {
        $list = CoreFIle::searchDir($this->dataFolderTransferSrc . DS . '*.*');
        if ($list) {
            $res;
            for ($i = $page - 1; $i < $max; $i++) {
                if (isset($list[$i]) == true) {
                    $res[] = basename($list[$i]);
                }
            }
            return $res;
        }
        return null;
    }

    /**
     * 转移新的文件
     * @param string $src 文件路径
     * @param string $title 标题
     * @param string $parent 上一级Id
     * @param string $content 描述内容
     * @return int 文件Id
     */
    public function transferFile($src, $title, $parent, $content) {
        if (is_file($src) == true) {
            //获取文件基本信息
            $fileName = basename($src);
            $fileSize = filesize($src);
            $fileType = pathinfo($src, PATHINFO_EXTENSION);
            $fileSha1 = sha1_file($src);
            $ds = DIRECTORY_SEPARATOR;
            //生成目录路径
            //获取时间
            $dateY = date('Y');
            $dateM = date('m');
            $dateD = date('d');
            $dateH = date('H');
            $dateI = date('i');
            $dateS = date('s');
            $time = $dateY . '-' . $dateM . '-' . $dateD . ' ' . $dateH . ':' . $dateI . ':' . $dateS;
            //生成目录
            $newDir = $this->dataFolderFileSrc . $ds . $dateY . $ds . $dateM . $ds . $dateD;
            if (mkdir($newDir, 0777, true) != true) {
                return 0;
            }
            //生成文件路径
            $newSrc = $newDir . $ds . $dateY . $dateM . $dateD . $dateH . $dateI . $dateS . '_' . $fileSha1 . '.' . $fileType;
            //转移文件
            if(rename($src,$newSrc) != true){
                return 0;
            }
            //创建文件数据
            return $this->addFx($title, $fileName, $parent, $fileSize, $fileType, $fileSha1, $time, $content);
        }
        return false;
    }

    /**
     * 查询FX信息
     * @param int $id ID
     * @return array 数据数组
     */
    public function view($id) {
        $where = '`' . $this->fxFields[0] . '` = :id';
        $attrs = array(':id' => array($id, PDO::PARAM_INT));
        return $this->db->sqlSelect($this->fxTableName, $this->fxFields, $where, $attrs);
    }

    /**
     * 获取合并后的字段
     * @param int $key 键位值
     * @return string 字段
     */
    public function getFxField($key) {
        return $this->fxTableName . '.' . $this->fxFields[$key];
    }

    /**
     * 查询FX列
     * @param string $where 条件,注意条件必须设定归属表,使用getFxField获取字段
     * @param array $attrs 筛选过滤
     * @param array $tags 标签组,eg:array(1,4,6)
     * @param int $page 页数
     * @param int $max 页长
     * @param int $sort 排序字段键位值
     * @param boolean $desc 是否倒叙
     * @return array 数据数组
     */
    public function viewList($where = '', $attrs = null, $tags = null, $page = 1, $max = 10, $sort = 0, $desc = false) {
        $sortField = isset($this->folderFields[$sort]) == true ? $this->getFxField($sort) : $this->getFxField(0);
        $descStr = $desc === true ? 'DESC' : 'ASC';
        $whereTag = '';
        if ($tags) {
            foreach ($tags as $v) {
                $whereTag .= $this->getTxField(2) . ' = :tagID or ';
            }
            $whereTag = substr($whereTag, 0, -4);
        }
        $sql = 'SELECT ' . $this->fxTableName . '.* FROM `' . $this->fxTableName . '`,`' . $this->txTableName . '` WHERE ' . $where . ' and ' . $this->getTxField(1) . ' = ' . $this->getFxField(0) . ' and (' . $whereTag . ') ORDER BY ' . $sortField . ' ' . $descStr . ' LIMIT ' . (($page - 1) * $max) . ',' . $max;
        return $this->db->runSQL($sql, $attrs, 3, PDO::FETCH_ASSOC);
    }

    /**
     * 修改Fx信息
     * @param int $id ID
     * @param string $title 标题
     * @param string $name 名称
     * @param string $content 描述内容
     * @return boolean 是否成功
     */
    public function editFx($id, $title, $name, $content) {
        $sets = array($this->fxFields[1] => ':title', $this->fxFields[2] => ':name', $this->fxFields[10] => ':content');
        $where = '`' . $this->fxFields[0] . '` = :id';
        $attrs = array(':title' => array($title, PDO::PARAM_STR), ':name' => array($name, PDO::PARAM_STR), ':content' => array($content, PDO::PARAM_STR), ':id' => array($id, PDO::PARAM_INT));
        return $this->db->sqlUpdate($this->fxTableName, $sets, $where, $attrs);
    }

    /**
     * 更新访问时间
     * @param int $id ID
     * @return boolean 是否成功
     */
    public function updateFxTime($id) {
        $sets = array($this->fxFields[9] => ':time');
        $where = '`' . $this->fxFields[0] . '` = :id';
        $attrs = array(':time' => array(date('Y-m-d H:i:s'), PDO::PARAM_STR), ':id' => array($id, PDO::PARAM_INT));
        return $this->db->sqlUpdate($this->fxTableName, $sets, $where, $attrs);
    }

    /**
     * 剪切文件到指定文件夹
     * @param int $id ID
     * @param int $parent 上一级ID
     * @return boolean 是否成功
     */
    public function cutFile($id, $parent) {
        $sets = array($this->fxFields[3] => ':parent');
        $where = '`' . $this->fxFields[0] . '` = :id';
        $attrs = array(':id' => array($id, PDO::PARAM_INT), ':parent' => array($parent, PDO::PARAM_INT));
        return $this->db->sqlUpdate($this->fxTableName, $sets, $where, $attrs);
    }

    /**
     * 删除FX
     * @param int $id ID
     * @return boolean 是否成功
     */
    public function delFx($id) {
        $where = '`' . $this->fxFields[3] . '` = :parent';
        $attrs = array(':parent' => array($id, PDO::PARAM_INT));
        $res = $this->db->sqlSelect($res, $fields, $where, $attrs, 1, 2);
        //遍历分支ID
        if ($res) {
            if ($this->delFx($res['id']) != true) {
                return false;
            }
        }
        //删除本ID
        //如果是文件，先尝试删除文件
        if ($res[$this->fxFields[5]] != 'folder') {
            if (CoreFile::deleteFile($this->getSrc($res[$this->fxFields[7]])) != true) {
                return false;
            }
        }
        $where = '`' . $this->fxFields[0] . '` = :id';
        $attrs = array(':id' => array($id, PDO::PARAM_INT));
        return $this->db->sqlDelete($this->fxTableName, $where, $attrs);
    }

    /**
     * 查看标签列
     * @param string $type 标签类型
     * @return array 数据数组
     */
    public function viewTag($type) {
        $where = '`' . $this->tagFields[3] . '` = :type';
        $attrs = array(':type' => array($type, PDO::PARAM_STR));
        return $this->db->sqlSelect($this->tagTableName, $this->tagFields, $where, $attrs, 1, 9999);
    }

    /**
     * 添加新的标签
     * 注意，在提交前使用前端JS判断是否重复。
     * @param string $name 标签名称
     * @param string $type 类型
     * @return int 新的ID值
     */
    public function addTag($name, $type) {
        if (isset($this->pexType[$type]) == true) {
            $value = 'NULL,:name,:type';
            $attrs = array(':name' => array($name, PDO::PARAM_STR), ':type' => array($this->pexType[$type]['key']));
            return $this->db->sqlInsert($this->tagTableName, $this->tagFields, $value, $attrs);
        }
        return 0;
    }

    /**
     * 添加新的标签和文件关系
     * @param int $fID 文件ID
     * @param int $tagID 标签ID
     * @param int $type 类型,file或folder
     * @return int 新的ID
     */
    public function addTx($fID, $tagID, $type) {
        $type = isset($this->txType[$type]) == true ? $this->txType[$type] : $this->txType[0];
        $where = '`' . $this->txFields[1] . '` = :fID and `' . $this->txFields[2] . '` = :tagID and `' . $this->txFields[3] . '` = :type';
        $attrs = array(':fileID' => array($fID, PDO::PARAM_INT), ':tagID' => array($tagID, PDO::PARAM_INT), ':type' => array($type, PDO::PARAM_STR));
        $res = $this->db->sqlSelect($this->tagTableName, $this->tagFields, $where, $attrs);
        if ($res) {
            return $res[0][$this->txFields[0]];
        } else {
            $value = 'NULL,:fileID,:tagID,:type';
            return $this->db->sqlInsert($this->txTableName, $this->txFields, $value, $attrs);
        }
        return 0;
    }

    /**
     * 修改标签名称
     * @param int $id 索引
     * @param string $name 新的名称
     * @return boolean 是否成功
     */
    public function editTag($id, $name) {
        $id = (int) $id;
        $sets = array($this->tagFields[1] => ':name');
        $where = '`' . $this->tagFields[0] . '` = :id';
        $attrs = array(':name' => array($name, PDO::PARAM_STR), ':id' => array($id, PDO::PARAM_INT));
        return $this->db->sqlUpdate($this->tagTableName, $sets, $where, $attrs);
    }

    /**
     * 删除标签关系
     * @param int $id ID
     * @return boolean 是否成功
     */
    public function delTx($id) {
        $where = '`' . $this->txFields[0] . '` = :id';
        $attrs = array(':id' => array($id, PDO::PARAM_INT));
        return $this->db->sqlDelete($this->txTableName, $where, $attrs);
    }

    /**
     * 删除标签
     * @param int $id ID
     * @return boolean 是否成功
     */
    public function delTag($id) {
        $where = '`' . $this->txFields[2] . '` = :id';
        $attrs = array(':id' => array($id, PDO::PARAM_INT));
        $re = $this->db->sqlDelete($this->txTableName, $where, $attrs);
        if ($re) {
            $where = '`' . $this->tagFields[0] . '` = :id';
            return $this->db->sqlDelete($this->tagTableName, $where, $attrs);
        }
        return false;
    }

    /**
     * 创建新的FX
     * @param string $title 标题
     * @param string $name 名称
     * @param int $parent 上一级ID
     * @param int $size 大小
     * @param string $type 类型
     * @param string $sha1 SHA1
     * @param string $time 时间
     * @param string $content 内容
     * @return int 新的ID
     */
    private function addFx($title, $name, $parent, $size, $type, $sha1, $time, $content) {
        $value = 'NULL,:title,:name,:parent,:size,:type,:sha1,:time,NOW(),:content';
        $attrs = array(':title' => array($title, PDO::PARAM_STR), ':name' => array($name, PDO::PARAM_STR), ':parent' => array($parent, PDO::PARAM_INT), ':size' => array($size, PDO::PARAM_INT), ':type' => array($type, PDP::PARAM_STR), ':sha1' => array($sha1, PDO::PARAM_STR), ':time' => array($time, PDO::PARAM_STR), ':content' => array($content, PDO::PARAM_STR));
        return $this->db->sqlInsert($this->fxTableName, $this->fxFields, $value, $attrs);
    }

    /**
     * 获取合并后的文件路径
     * @param string $src 文件路径
     * @return string 文件路径
     */
    private function getSrc($src) {
        return $this->dataFolderFileSrc . DS . $src;
    }

    /**
     * 获取TX字段
     * @param int $key 键位值
     * @return string 字段
     */
    private function getTxField($key) {
        return $this->txTableName . '.' . $this->txFields[$key];
    }

}

?>