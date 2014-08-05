<?php

/**
 * PEX处理器
 * @author liuzilu <fotomxq@gmail.com>
 * @date    2014-06-29 10:02:50
 * @version 9
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
    private $tagFields = array('id', 'tag_name', 'tag_type');

    /**
     * 文件数据表字段
     * @var array 
     */
    private $fxFields = array('id', 'fx_title', 'fx_name', 'fx_parent', 'fx_size', 'fx_type', 'fx_sha1', 'fx_src', 'fx_create_time', 'fx_visit_time', 'fx_content');

    /**
     * 文件和标签关系数据表字段
     * @var array
     */
    private $txFields = array('id', 'file_id', 'tag_id', 'tx_type');

    /**
     * 文件和标签关系表类型
     * @var array 
     */
    private $txType = array('file', 'folder');

    /**
     * 日志对象
     * @var CoreLog 
     */
    private $log;

    /**
     * 类型
     * key-键值,用于tag表等类型标记 ; folder-对应文件夹ID ; title-名称
     * @var array 
     */
    public $pexType = array(
        'photo' => array('key' => 'photo', 'folder' => 1, 'title' => '照片', 'type' => array('jpg', 'png', 'gif', 'jpeg')),
        'movie' => array('key' => 'movie', 'folder' => 2, 'title' => '影片', 'type' => array('mp4')),
        'cartoon' => array('key' => 'cartoon', 'folder' => 3, 'title' => '漫画', 'cartoon' => array('jpg', 'png', 'jpeg')),
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
     * 垃圾箱目录
     * @var string 
     */
    private $dataFolderTrashSrc;

    /**
     * 文件路径分隔符
     * @var string 
     */
    private $ds;

    /**
     * 初始化
     * @param CoreDB $db            数据库对象
     * @param string $dataFolderSrc 文件数据目录路径
     * @param CoreLog $log 日志对象
     */
    public function __construct(&$db, $dataFolderSrc, &$log) {
        $this->db = $db;
        $this->dataFolderSrc = $dataFolderSrc;
        $this->dataFolderFileSrc = $dataFolderSrc . DS . 'file';
        $this->dataFolderCacheImgsSrc = $dataFolderSrc . DS . 'imgs';
        $this->dataFolderTransferSrc = $dataFolderSrc . DS . 'transfer';
        $this->dataFolderTrashSrc = $dataFolderSrc . DS . 'trash';
        $this->log = $log;
        $this->ds = DIRECTORY_SEPARATOR;
    }

    public function uploadFile($files) {
        //暂时不支持上传文件
    }

    /**
     * 查询等待转移文件
     * @param int $page 页数
     * @param int $max 页长
     * @return array 数据数组，文件路径组成
     */
    public function transferList($page = 1, $max = 10) {
        $list = CoreFIle::searchDir($this->dataFolderTransferSrc . DS . '*');
        if ($list) {
            $res;
            for ($i = $page - 1; $i < $max; $i++) {
                if (isset($list[$i]) == true) {
                    $res[] = iconv("GB2312", "UTF-8//IGNORE", $this->getBasename($list[$i]));
                }
            }
            return $res;
        }
        return null;
    }

    /**
     * 转移发布文件夹模式
     * @param int $parent 上一级ID
     * @param array $tags 标签组
     * @return boolean 是否成功
     */
    public function transferFolder($parent, $tags) {
        //是否为顶级目录
        $isUpParent = false;
        foreach ($this->pexType as $v) {
            if ($parent == $v['folder']) {
                $isUpParent = true;
                break;
            }
        }
        //获取等待转移区所有文件夹
        $waitFolderSearch = $this->dataFolderTransferSrc . $this->ds . '*';
        $waitFolderList = CoreFile::searchDir($waitFolderSearch, GLOB_ONLYDIR);
        if (!$waitFolderList) {
            return false;
        }
        //获取并遍历所有文件夹下的文件
        foreach ($waitFolderList as $folderV) {
            //获取基本信息
            $folderName = $this->getBasename($folderV);
            //建立文件夹
            $folderID = $this->addFolder($folderName, $parent, '');
            if ($folderID < 1) {
                return false;
            }
            if (!$this->setTx($folderID, $tags, $this->txType[1])) {
                return false;
            }
            //遍历文件并转移
            $waitFileSearch = $folderV . $this->ds . '*.*';
            $waitFileList = CoreFile::searchDir($waitFileSearch);
            if (!$waitFileList) {
                continue;
            }
            foreach ($waitFileList as $fileV) {
                $fileName = $this->getBasename($fileV);
                $fileID = $this->transferFile($fileV, $fileName, $folderID, '');
                if ($fileID < 1) {
                    continue;
                }
                if (!$this->setTx($fileID, $tags, $this->txType[0])) {
                    continue;
                }
            }
            //删除文件夹
            CoreFile::deleteDir($folderV);
        }
        return true;
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
            $fileName = $this->getBasename($src);
            $fileSize = filesize($src);
            $fileType = strtolower(pathinfo($src, PATHINFO_EXTENSION));
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
            if (!is_dir($newDir)) {
                if (mkdir($newDir, 0777, true) != true) {
                    return 0;
                }
            }
            //生成文件路径
            $saveSrc = $dateY . $ds . $dateM . $ds . $dateD . DS . $dateY . $dateM . $dateD . $dateH . $dateI . $dateS . '_' . $fileSha1 . '.' . $fileType;
            $newSrc = $newDir . $ds . $dateY . $dateM . $dateD . $dateH . $dateI . $dateS . '_' . $fileSha1 . '.' . $fileType;
            //转移文件
            if (rename($src, $newSrc) != true) {
                return 0;
            }
            //创建文件数据
            return $this->addFx($title, $fileName, $parent, $fileSize, $fileType, $fileSha1, $saveSrc, $time, $content);
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
        $res = $this->db->sqlSelect($this->fxTableName, $this->fxFields, $where, $attrs);
        if ($res) {
            if (PATH_SEPARATOR == ':') {
                $res[$this->fxFields[7]] = str_replace('\\', '/', $res[$this->fxFields[7]]);
            } else {
                $res[$this->fxFields[7]] = str_replace('/', '\\', $res[$this->fxFields[7]]);
            }
        }
        return $res;
    }

    /**
     * 不通过Src获取文件路径
     * @param int $id ID
     * @return string 路径
     */
    public function getFileSrc($id) {
        $res = $this->view($id);
        if ($res) {
            $type = $res['fx_type'] == 'folder' ? 'jpg' : $res['fx_type'];
            $dateY = substr($res['fx_create_time'], 0, 4);
            $dateM = substr($res['fx_create_time'], 5, 2);
            $dateD = substr($res['fx_create_time'], 8, 2);
            $dateH = substr($res['fx_create_time'], 11, 2);
            $dateI = substr($res['fx_create_time'], 14, 2);
            $dateS = substr($res['fx_create_time'], 17, 2);
            $src = $this->dataFolderFileSrc . DS . $dateY . DS . $dateM . DS . $dateD . DS . $dateY . $dateM . $dateD . $dateH . $dateI . $dateS . '_' . $res['fx_sha1'] . '.' . $type;
            return $src;
        }
        return '';
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
     * @param int $parent 上一级Id 
     * @param array $tags 标签组,eg:array(1,4,6)
     * @param int $page 页数
     * @param int $max 页长
     * @param int $sort 排序字段键位值
     * @param boolean $desc 是否倒叙
     * @param boolean $or 是否或查询
     * @return array 数据数组
     */
    public function viewList($parent = 0, $tags = null, $page = 1, $max = 10, $sort = 0, $desc = false, $or = true) {
        $where = $this->fxTableName . '.' . $this->fxFields[3] . ' = :parent';
        $attrs = array(':parent' => array($parent, PDO::PARAM_INT));
        $sortField = isset($this->folderFields[$sort]) == true ? $this->getFxField($sort) : $this->getFxField(0);
        $descStr = $desc === true ? 'DESC' : 'ASC';
        $whereTag = '1';
        $orStr = $or ? 'or' : 'and';
        if ($tags) {
            $whereTag = '';
            foreach ($tags as $k => $v) {
                $aK = ':tagID' . $k;
                $whereTag .= $this->getTxField(2) . ' = ' . $aK . ' ' . $orStr . ' ';
                $attrs[$aK] = array($v, PDO::PARAM_INT);
            }
            if ($or) {
                $whereTag = substr($whereTag, 0, -4);
            } else {
                $whereTag = substr($whereTag, 0, -5);
            }
        }
        $sql = 'SELECT ' . $this->fxTableName . '.* FROM `' . $this->fxTableName . '`,`' . $this->txTableName . '` WHERE ' . $where . ' and ' . $this->getTxField(1) . ' = ' . $this->getFxField(0) . ' and (' . $whereTag . ') GROUP BY ' . $sortField . ' ' . $descStr . ' LIMIT ' . (($page - 1) * $max) . ',' . $max;
        return $this->db->runSQL($sql, $attrs, 3, PDO::FETCH_ASSOC);
    }

    /**
     * 创建文件夹
     * @param string $title 标题
     * @param int $parent 上一级Id
     * @param string $content 描述
     * @return int 新的Id
     */
    public function addFolder($title, $parent, $content) {
        $size = 0;
        $type = 'folder';
        $sha1 = sha1('folder');
        $time = date('Y-m-d H:i:s');
        return $this->addFx($title, $title, $parent, $size, $type, $sha1, '', $time, $content);
    }

    /**
     * 修改Fx信息
     * @param int $id ID
     * @param string $title 标题
     * @param string $content 描述内容
     * @return boolean 是否成功
     */
    public function editFx($id, $title, $content) {
        $sets = array($this->fxFields[1] => ':title', $this->fxFields[10] => ':content');
        $where = '`' . $this->fxFields[0] . '` = :id';
        $attrs = array(':title' => array($title, PDO::PARAM_STR), ':content' => array($content, PDO::PARAM_STR), ':id' => array($id, PDO::PARAM_INT));
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
        //获取本ID信息
        $res = $this->view($id);
        if (!$res) {
            return false;
        }
        //获取子ID
        $where = '`' . $this->fxFields[3] . '` = :parent';
        $attrs = array(':parent' => array($id, PDO::PARAM_INT));
        $resList = $this->db->sqlSelect($this->fxTableName, $this->fxFields, $where, $attrs, 1, 50);
        //遍历分支ID
        $step = 1;
        while ($resList) {
            foreach ($resList as $v) {
                if ($this->delFx($v['id']) != true) {
                    return false;
                }
            }
            $step += 1;
            $resList = $this->db->sqlSelect($this->fxTableName, $this->fxFields, $where, $attrs, 1, 50);
        }
        //删除本ID
        //如果是文件，先尝试删除文件
        if ($res[$this->fxFields[5]] != 'folder') {
            $src = $this->getSrc($res[$this->fxFields[7]]);
            $trashSrc = $this->dataFolderTrashSrc . DS . $res[$this->fxFields[2]];
            if (CoreFile::cutF($src, $trashSrc) != true) {
                //如果失败则忽略文件
                //return false;
            }
        }
        $where = '`' . $this->fxFields[0] . '` = :id';
        $attrs = array(':id' => array($id, PDO::PARAM_INT));
        return $this->db->sqlDelete($this->fxTableName, $where, $attrs);
    }

    /**
     * 合并文件夹
     * @param int $srcID 源文件夹ID
     * @param int $destID 目标文件夹ID
     * @return boolean 是否成功
     */
    public function folderJoin($srcID, $destID) {
        $src = $this->view($srcID);
        $dest = $this->view($destID);
        if ($src && $dest && $src[$this->fxFields[5]] == 'folder' && $dest[$this->fxFields[5]] == 'folder') {
            $srcParent = $this->viewList($srcID, null, 1, 1);
            if ($srcParent) {
                $sets = array($this->fxFields[3] => ':parentDest');
                $where = '`' . $this->fxFields[3] . '` = :parentSrc';
                $attrs = array(':parentSrc' => array($src[$this->fxFields[0]], PDO::PARAM_INT), ':parentDest' => array($dest[$this->fxFields[0]], PDO::PARAM_INT));
                if (!$this->db->sqlUpdate($this->fxTableName, $sets, $where, $attrs)) {
                    return false;
                }
            }
            return $this->delFx($src[$this->fxFields[0]]);
        }
        return false;
    }

    /**
     * 查看标签列
     * @param string $type 标签类型
     * @return array 数据数组
     */
    public function viewTag($type) {
        $where = '`' . $this->tagFields[2] . '` = :type';
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
     * 查看文件对应的标签关系列
     * @param int $id 文件ID
     * @return array 数据数组
     */
    public function viewTx($id) {
        $sql = 'SELECT ' . $this->txTableName . '.*,' . $this->tagTableName . '.' . $this->tagFields[1] . ' FROM ' . $this->tagTableName . ',' . $this->txTableName . ' WHERE ' . $this->txTableName . '.' . $this->txFields[1] . ' = :id AND ' . $this->txTableName . '.' . $this->txFields[2] . ' = ' . $this->tagTableName . '.' . $this->tagFields[0] . ' GROUP BY ' . $this->txTableName . '.' . $this->txFields[0];
        $attrs = array(':id' => array($id, PDO::PARAM_STR));
        return $this->db->runSQL($sql, $attrs, 3, PDO::FETCH_ASSOC);
    }

    /**
     * 设置标签关系
     * @param int $id 文件ID
     * @param array $tags 标签组,eg:array(1,3,5)
     * @param string $type 类型，file或folder对应0和1
     * @return boolean
     */
    public function setTx($id, $tags, $type) {
        $type = $type == 1 ? 1 : 0;
        $nowTagRes = $this->viewTx($id);
        if ($nowTagRes) {
            if (!$tags) {
                foreach ($nowTagRes as $v) {
                    if (!$this->delTxTag($id, $v[$this->txFields[2]])) {
                        return false;
                    }
                }
            }
            $nowTags;
            foreach ($nowTagRes as $v) {
                $nowTags[] = $v[$this->txFields[2]];
            }
            $diffMore = array_diff($tags, $nowTags);
            $diffLess = array_diff($nowTags, $tags);
            if ($diffMore) {
                foreach ($diffMore as $v) {
                    if (!$this->addTx($id, $v, $type)) {
                        return false;
                    }
                }
            }
            if ($diffLess) {
                foreach ($diffLess as $v) {
                    if (!$this->delTxTag($id, $v)) {
                        return false;
                    }
                }
            }
            return true;
        } else {
            foreach ($tags as $v) {
                if (!$this->addTx($id, $v, $type)) {
                    return false;
                }
            }
            return true;
        }
        return false;
    }

    /**
     * 添加新的标签和文件关系
     * @param int $fID 文件ID
     * @param int $tagID 标签ID
     * @param int $type 类型,file或folder对应0和1
     * @return int 新的ID
     */
    public function addTx($fID, $tagID, $type) {
        $type = isset($this->txType[$type]) == true ? $this->txType[$type] : $this->txType[0];
        $where = '`' . $this->txFields[1] . '` = :fileID and `' . $this->txFields[2] . '` = :tagID and `' . $this->txFields[3] . '` = :type';
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
     * 获取文件字段列
     * @return array 字段数组
     */
    public function getFxAllField() {
        return $this->fxFields;
    }

    /**
     * 根据文件ID和标签ID删除标签关系
     * @param int $fileID 文件ID
     * @param int $tagID 标签ID
     * @return boolean 是否成功
     */
    private function delTxTag($fileID, $tagID) {
        $where = '`' . $this->txFields[1] . '` = :fileID and `' . $this->txFields[2] . '` = :tagID';
        $attrs = array(':fileID' => array($fileID, PDO::PARAM_INT), ':tagID' => array($tagID, PDO::PARAM_INT));
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
     * 删除某类型下的所有标签
     * @param string $type 类型
     * @return boolean 是否成功
     */
    public function delTagType($type) {
        $where = '`' . $this->tagFields[2] . '` = :type';
        $attrs = array(':type' => array($type, PDO::PARAM_STR));
        return $this->db->sqlDelete($this->tagTableName, $where, $attrs);
    }

    /**
     * 设定类型下的标签组
     * @param array $newTags 新的标签组
     * @param string $type 类型
     * @return boolean 是否成功
     */
    public function setTag($newTags, $type) {
        if ($newTags) {
            $nowTagsRes = $this->viewTag($type);
            if ($nowTagsRes) {
                $nowTags;
                foreach ($nowTagsRes as $v) {
                    $nowTags[] = $v[$this->tagFields[1]];
                }
                $diffMore = array_diff($newTags, $nowTags);
                $diffLess = array_diff($nowTags, $newTags);
                if ($diffMore) {
                    foreach ($diffMore as $v) {
                        if ($v) {
                            if (!$this->addTag($v, $type)) {
                                return false;
                            }
                        }
                    }
                }
                if ($diffLess) {
                    foreach ($diffLess as $v) {
                        if ($v) {
                            $where = '`' . $this->tagFields[1] . '` = :name and `' . $this->tagFields[2] . '` = :type';
                            $attrs = array(':name' => array($v, PDO::PARAM_STR), ':type' => array($type, PDO::PARAM_STR));
                            if (!$this->db->sqlDelete($this->tagTableName, $where, $attrs)) {
                                return false;
                            }
                        }
                    }
                }
                return true;
            } else {
                foreach ($newTags as $v) {
                    if ($v) {
                        if (!$this->addTag($v, $type)) {
                            return false;
                        }
                    }
                }
                return true;
            }
        } else {
            return $this->delTagType($type);
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
     * @param string $src 路径
     * @param string $time 时间
     * @param string $content 内容
     * @return int 新的ID
     */
    private function addFx($title, $name, $parent, $size, $type, $sha1, $src, $time, $content) {
        $value = 'NULL,:title,:name,:parent,:size,:type,:sha1,:src,:time,NOW(),:content';
        $attrs = array(
            ':title' => array($title, PDO::PARAM_STR),
            ':name' => array($name, PDO::PARAM_STR),
            ':parent' => array($parent, PDO::PARAM_INT),
            ':size' => array($size, PDO::PARAM_INT),
            ':type' => array($type, PDO::PARAM_STR),
            ':sha1' => array($sha1, PDO::PARAM_STR),
            ':src' => array($src, PDO::PARAM_STR),
            ':time' => array($time, PDO::PARAM_STR),
            ':content' => array($content, PDO::PARAM_STR));
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

    /**
     * 获取文件基本名称
     * @param string $src 路径
     * @return string 文件名
     */
    private function getBasename($src) {
        return preg_replace('/^.+[\\\\\\/]/', '', $src);
    }

    /**
     * 添加日志
     * @param string $local 位置标记
     * @param string $msg 消息
     */
    private function addLog($local, $msg) {
        $this->log->add($local, $msg);
    }

}

?>