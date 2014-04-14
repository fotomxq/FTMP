<?php

/**
 * 修改网站设置
 * @author fotomxq <fotomxq.me>
 * @version 3
 * @package web
 * @todo 完成统计部分
 */

//引用登录检测模块
require('action-logged.php');

//判断用户是否具备权限
if($userPowers[$user->powerValues[1]] == false) die('No Power.');

//用户列表页长
$userListMax = 10;

//提交处理
// 0 - 没有通过过滤器; 1 - 执行成功; 2 - 执行失败
$res = 0;
if(isset($_GET['type']) == true){
    switch($_GET['type']){
        case 'operate':
            //设置平台
            //网站标题
            if(isset($_POST['configWebTitle']) == true){
                $val = $filter->getString($_POST['configWebTitle'],100,0,true,true);
                if($config->save('WEB-TITLE',$val) == true){
                    $res = 1;
                }
            }
            //登录用户超时时间(s)
            if(isset($_POST['inputUserLimitTime']) == true) {
                $val = (int) $_POST['inputUserLimitTime'];
                if ($val > 100) {
                    if ($config->save('WEB-TITLE', $val) == true) {
                        $res = 1;
                    }
                }
            }
            if($res < 2){
                $res = 1;
            }
            break;
        case 'user-list':
            //获取用户列表
            $page = isset($_POST['page']) == true ? $_POST['page'] : 1;
            if($page < 1) $page = 1;
            $sort = 0;
            $desc = true;
            $where = '1';
            $attrs;
            if(isset($_POST['search']) == true && $_POST['search']){
                $whereSearch = '%'.$filter->getString($_POST['search'],100,0,true,true).'%';
                $where = '`'.$user->fieldsUser[1].'` LIKE :nice or `'.$user->fieldsUser[2].'` LIKE :login';
                $attrs = array(':nice'=>array($whereSearch,PDO::PARAM_STR),':login'=>array($whereSearch,PDO::PARAM_STR));
            }
            $res = $user->viewUserList($where,$attrs,$page,$userListMax,$sort,$desc);
            break;
        case 'user-list-max-page':
            $where = '1';
            $attrs;
            if(isset($_POST['search']) == true && $_POST['search']){
                $whereSearch = '%'.$filter->getString($_POST['search'],100,0,true,true).'%';
                $where = '`'.$user->fieldsUser[1].'` LIKE :nice or `'.$user->fieldsUser[2].'` LIKE :login';
                $attrs = array(':nice'=>array($whereSearch,PDO::PARAM_STR),':login'=>array($whereSearch,PDO::PARAM_STR));
            }
            $res = ceil((int)$user->viewUserListCount($where,$attrs) / $userListMax);
            break;
        case 'user-info':
            //获取用户信息
            if(isset($_POST['id']) == true){
                $id = (int)$_POST['id'];
                $res = $user->viewUser($id);
                if($res){
                    $res['infos'] = $user->viewMetaList($res['id']);
                }
            }
            break;
        case 'user-add':
            //添加用户
            if(isset($_POST['nicename']) == true && isset($_POST['login']) == true && isset($_POST['passwd']) == true && isset($_POST['powers']) == true && isset($_POST['app']) == true){
                $nicename = $filter->getString($_POST['nicename'],100,0,true,true);
                $username = $filter->getString($_POST['login'],50,0,true,true);
                $password = isset($_POST['passwd']) == true ? $_POST['passwd'] : null;
                $power = $_POST['powers'];
                $app = $_POST['app'];
                $addUserID = $user->addUser($nicename,$username,$password);
                if($addUserID > 0){
                    $metaA = $user->setMetaValList($addUserID,$user->powerMetaName,$power);
                    $metaB = $user->setMetaValList($addUserID,$user->appMetaName,$app);
                    if($metaA > 0 && $metaB > 0){
                        $res = 1;
                    }else{
                        $res = 2;
                    }
                }else{
                    $res = 2;
                }
            }
            break;
        case 'user-edit':
            //修改用户信息
            if(isset($_POST['id']) == true && isset($_POST['nicename']) == true && isset($_POST['powers']) == true && isset($_POST['app']) == true){
                $id = (int)$_POST['id'];
                $nicename = $filter->getString($_POST['nicename'],100,0,true,true);
                $password = isset($_POST['passwd']) == true ? $_POST['passwd'] : null;
                if(!$password){
                    $password = null;
                }
                $power = $_POST['powers'];
                $app = $_POST['app'];
                if($user->editUser($id,$nicename,$password) == true && $user->setMetaValList($id,$user->powerMetaName,$power) == true && $user->setMetaValList($id,$user->appMetaName,$app) == true){
                    $res = 1;
                }else{
                    $res = 2;
                }
            }
            break;
        case 'user-meta-add':
            //添加META
            if(isset($_POST['id']) == true && isset($_POST['name']) == true){
                $id = (int)$_POST['id'];
                $name = $filter->getString($_POST['name'],100);
                $value = isset($_POST['val']) == true ? $_POST['val'] : '';
                $addMetaID = $user->addMeta($id,$name,$value);
                if($addMetaID > 0){
                    $res = 1;
                }else{
                    $res = 2;
                }
            }
            break;
        case 'user-meta-edit':
            //修改META
            if(isset($_POST['id']) == true){
                $id = (int)$_POST['id'];
                $value = isset($_POST['val']) == true ? $_POST['val'] : '';
                if($user->editMeta($id,$val) == true){
                    $res = 1;
                }else{
                    $res = 2;
                }
            }
            break;
        case 'user-meta-del':
            //删除META数据
            if(isset($_POST['id']) == true){
                $id = (int)$_POST['id'];
                if($user->delMeta($id) == true){
                    $res = 1;
                }else{
                    $res = 2;
                }
            }
            break;
        case 'user-del':
            //删除用户
            if(isset($_POST['id']) == true){
                if(is_array($_POST['id']) == true){
                    foreach($_POST['id'] as $v){
                        $vId = (int)$v;
                        if($vId != $userID){
                            if($user->delUser($vId) == true){
                                $res = 1;
                            }else{
                                $res = 2;
                                break;
                            }
                        }else{
                            $res = 3;
                            break;
                        }
                    }
                }else{
                    $id = (int)$_POST['id'];
                    if($userID != $id){
                        if($user->delUser($id) == true){
                            $res = 1;
                        }else{
                            $res = 2;
                        }
                    }else{
                        //不能删除自身
                        $res = 3;
                    }
                }
            }
            break;
    }
}
CoreHeader::toJson($res);
?>