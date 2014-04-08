<?php

/**
 * 设定用户
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package web
 */
//引用登录检测模块
require('action-logged.php');

//提交
if(isset($_POST['nicename']) == true){
    $nicename = $filter->getString($_POST['nicename'],100,0,true,true);
    $password = isset($_POST['passwd']) == true ? $_POST['passwd'] : null;
    if($user->editUser($userID,$nicename,$password) == true){
        $log->add('action-user','Success,edit user info.');
        CoreHeader::toURL('center-user.php?msg=ok');
    }else{
        $log->add('action-user','Faild,edit user info.');
        CoreHeader::toURL('center-user.php?msg=faild');
    }
}else{
    CoreHeader::toURL('center-user.php?msg=faild-filter');
}
?>