<?php

/**
 * 修改网站设置
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package web
 */

//引用登录检测模块
require('action-logged.php');

//判断用户是否具备权限
if($userPowers[$user->powerValues[1]] == false) die('No Power.');

//提交处理
$res = 0;
if(isset($_GET['type']) == true){
    switch($_GET['type']){
        case 'operate':
            //设置平台
            break;
        case 'user-list':
            //获取用户列表
            break;
        case 'user-add':
            //添加用户
            break;
        case 'user-edit':
            //修改用户信息
            break;
        case 'user-edit-meta':
            //修改用户META
            break;
        case 'user-del':
            //删除用户
            if(isset($_GET['id']) == true){
                $id = (int)$_GET['id'];
                if($userID != $id){
                    if($user->delUser($id) == true){
                        //删除成功
                        $res = 1;
                    }else{
                        //删除失败，内部原因
                        $res = 3;
                    }
                }else{
                    //
                    $res = 2;
                }
            }
            break;
    }
}
CoreHeader::toJson($res);
?>