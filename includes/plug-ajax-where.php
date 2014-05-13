<?php

/**
 * WHERE组合插件
 * <p>该插件主要用于Ajax提交的多种条件之间的组合。</p>
 * <p>该插件仅限于简单的条件组合，如果关系复杂到需要使用括号，则需要手动建立。</p>
 * @author fotomxq <fotomxq.me>
 * @package plug
 * @todo 转移该模块到FTMP，并提交GIT
 */

/**
 * Ajax-WHERE快速组合插件
 * @since 1
 * @param array $fields 对应匹配的字段组，eg: array('id','name',...)
 * @param array $wheres 客户端提交的where数组
 *                                                  eg: array(0=>array(0=>对应的键值 , 1=>匹配标记[=/</>/<=/>=/!=] , 2=>值 , 3=>和上一个条件关系[or/and]),...)
 *                                                  注,在[]括号内的内容对应数字值
 * @return array 生成的where和attrs
 */
function PlugAjaxWhere($fields, $wheres) {
    $where = '';
    $attrs = null;
    if (is_array($wheres) == true) {
        foreach ($wheres as $v) {
            //必须确保键位存在，否则拒绝添加
            $fieldStr = isset($fields[$v[0]]) == true ? $fields[$v[0]] : '';
            if ($fieldStr) {
                //获取等式
                $qs = array('=', '<', '>', '<=', '>=', '!=');
                $q = isset($qs[$v[1]]) == true ? $qs[$v[1]] : $qs[$v[0]];
                //判断是否为第一个条件
                if ($where != '') {
                    //如果不是第一个条件，则添加and或or关系语句
                    if ($v[3] == 'and') {
                        $where .= ' and `' . $fieldStr . '` ' . $q . ' :' . $fieldStr;
                    } else {
                        $where .= ' or `' . $fieldStr . '` ' . $q . ' :' . $fieldStr;
                    }
                } else {
                    //如果是第一个条件，则直接添加条件
                    $where .= '`' . $fieldStr . '` ' . $q . ' :' . $fieldStr;
                }
                //过滤组，全部按照STR处理
                $val = '%' . $v[2] . '%';
                $attrs[':' . $fieldStr] = array($val, PDO::PARAM_STR);
            }
        }
    }
    if (!$where) {
        $where = '1';
        $attrs = null;
    }
    return array($where, $attrs);
}

?>