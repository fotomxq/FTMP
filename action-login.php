<?php

/**
 * 登录操作
 * @author fotomxq <fotomxq.me>
 * @version 3
 * @package web
 */
//引用全局
require('glob.php');

//处理登录
if (isset($_POST['email']) == true && isset($_POST['password']) == true) {
    $remember = isset($_POST['remember']);
    //验证输入
    $email = $filter->getEmail($_POST['email']);
    //开始登录
    $loginReady = $user->login($ipAddr, $email, $_POST['password'], $remember);
    if ($loginReady == true) {
        $log->add(basename(__FILE__), 'Sign in success.');
        if(count($appList) > 1){
            CoreHeader::toURL('center.php');
        }else{
            foreach($appList as $k=>$v){
                CoreHeader::toURL('app/'.$k.'/index.php');
                die();
            }
        }
        die();
    }
}

//如果登录失败
CoreHeader::toURL('index.php?login-faild');
?>