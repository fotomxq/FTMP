<?php

/**
 * 中心动作
 * @author liuzilu <fotomxq@gmail.com>
 * @date    2014-07-09 15:25:51
 * @version 4
 */
//引用全局
require('glob.php');

//引用备份类
require(DIR_LIB . DS . 'sys-backup.php');

//判断当前用户权限
$checkPowers = $user->checkPower($userID, array('NORMAL', 'ADMIN'));

//用户权限检测处理模块
function powerCheck($power) {
    if ($power != true) {
        die();
    }
}

//设定脚本时间
ini_set('max_execution_time', 1800);
set_time_limit(1800);

//判断动作类型
if (isset($_GET['action']) != true) {
    die();
}
switch ($_GET['action']) {
    case 'database-backup':
        //备份数据库
        powerCheck($checkPowers['ADMIN']);
        $type = isset($_POST['type']) == true ? $_POST['type'] : 'both';
        $backup = new SysBackup($db, DIR_BACKUP, DIR_DATA);
        $res = $backup->backup($type);
        CoreHeader::toJson($res);
        break;
    case 'database-return':
        //还原数据库
        powerCheck($checkPowers['ADMIN']);
        $res = false;
        if (isset($_POST['file-name']) == true) {
            $backup = new SysBackup($db, DIR_BACKUP, DIR_DATA);
            $name = $_POST['file-name'];
            $res = $backup->re($name);
        }
        CoreHeader::toJson($res);
        break;
    case 'system-info':
        //查看参数信息
        //引用模块
        require(DIR_LIB . DS . 'plug-disk.php');
        //检查权限
        powerCheck($checkPowers['ADMIN']);
        //获取数据
        $res['user-limit-time'] = $config->get('USER-LIMIT-TIME');
        $backup = new SysBackup($db, DIR_BACKUP, DIR_DATA);
        $res['backup-list'] = $backup->viewList();
        $res['system-maint'] = $config->get('WEB-MAINT-ON');
        $res['ip-white-list'] = $config->get('IP-WHITE-LIST');
        $res['disk'] = PlugDiskInfo(DIR_DATA);
        CoreHeader::toJson($res);
        break;
    case 'system-save':
        //保存参数
        powerCheck($checkPowers['ADMIN']);
        $boolean = array();
        $systemUserLimitTime = isset($_POST['user-limit-time']) == true ? $_POST['user-limit-time'] : $config->get('USER-LIMIT-TIME');
        $systemIPWhiteList = isset($_POST['ip-white-list']) ? $_POST['ip-white-list'] : $config->get('IP-WHITE-LIST');
        if ($systemUserLimitTime > 120) {
            $boolean[] = $config->save('USER-LIMIT-TIME', $systemUserLimitTime);
        }
        $boolean[] = $config->save('IP-WHITE-LIST', $systemIPWhiteList);
        $res = true;
        foreach ($boolean as $v) {
            if ($v == false) {
                $res = false;
            }
        }
        if ($res == true) {
            $cache->clear();
        }
        CoreHeader::toJson($res);
        break;
    case 'system-maint':
        //切换系统维护模式
        powerCheck($checkPowers['ADMIN']);
        $maint = $config->get('WEB-MAINT-ON');
        $res = -1;
        if ($maint === '1') {
            $config->save('WEB-MAINT-ON', '0');
            $res = 0;
        } else {
            $config->save('WEB-MAINT-ON', '1');
            $res = 1;
        }
        CoreHeader::toJson($res);
        break;
    case 'user-info':
        //获取当前用户信息
        powerCheck($checkPowers['NORMAL']);
        $res = $user->viewUser($userID);
        if ($res) {
            $res['meta'] = $user->viewMetaList($userID);
        }
        CoreHeader::toJson($res);
        break;
    case 'user-info-save':
        //修改当前用户信息
        powerCheck($checkPowers['NORMAL']);
        $res = false;
        if (isset($_POST['nicename']) == true) {
            $nicename = $_POST['nicename'];
            $passwd = isset($_POST['passwd']) == true ? $_POST['passwd'] : false;
            $isPasswd = false;
            if ($passwd) {
                if (strlen($passwd) >= 6 && strlen($passwd) <= 20) {
                    $isPasswd = true;
                }
            } else {
                $isPasswd = true;
            }
            if ($isPasswd === true) {
                $res = $user->editUser($userID, $nicename, $passwd);
            }
        }
        CoreHeader::toJson($res);
        break;
    case 'clear-cache':
        //清理缓冲
        $res = $cache->clear();
        CoreHeader::toJson($res);
        break;
}
?>