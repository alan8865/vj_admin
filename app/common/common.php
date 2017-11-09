<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: Venus <iweixiaopeng@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
use think\Loader;

/**
 * 获取 managerId
 * @return string
 */
function getManagerId () {
    return session('managerId');
}

/**
 * 生成UUID
 * @return string
 */
function getUUID () {
    $str = md5(uniqid(mt_rand(), true));
    $uuid  = substr($str,0,8) . '-';
    $uuid .= substr($str,8,4) . '-';
    $uuid .= substr($str,12,4) . '-';
    $uuid .= substr($str,16,4) . '-';
    $uuid .= substr($str,20,12);
    return 'vj' . $uuid;
}

/**
 * 将模型对象或模型对象数组转为纯数组
 * @param $item array | \think\Model
 */
function castToArray (&$item) {
    // 如果是数组则判断每个元素是不是
    if (is_array($item)) {
        foreach ($item as &$val) {
            // 对数组的每一个元素进行递归调用
            castToArray($val);
        }
    } else if ($item instanceof \think\Model) {
        // 仅仅是Model对象，转为数组
        $item = $item->toArray();
    }
}

/**
 * 获取字段字典字段值含义的数组
 * @param $table string 表名
 * @param $field string 字段名
 * @return array 返回数组
 */
function getMeaningsOfFieldValues ($table, $field) {
    // 获取数据字段模型
    $model = model('app\\admin\\model\\SysFieldDict');
    // 返回查询到的字段值含义的数组
    $arr = $model->field([
        'value',
        'meaning'
    ])->where([
        'table' => $table,
        'field' => $field
    ])->order(config('system.sys_table_pk'), 'asc')->select();
    castToArray($arr);
    return $arr;
}

/**
 * 获取某一字段的所有可取的值
 * @param $table string 表名
 * @param $field string 字段名
 * @return mixed 字段值数组
 */
function getFieldValues ($table, $field) {
    // 获取数据字段模型
    $model = model('app\\admin\\model\\SysFieldDict');
    // 返回查询到的字段值的数组
    $arr = $model->where([
        'table' => $table,
        'field' => $field
    ])->order(config('system.sys_table_pk'), 'asc')->column('value');
    return $arr;
}

/**
 * 将某一字段可取的值连接为字符串
 * @param $table string 表名
 * @param $field string 字段名
 * @param string $sep string 分隔符
 * @return string
 */
function getFieldValuesStr ($table, $field, $sep = ',') {
    return join($sep, getFieldValues($table, $field));
}

/**
 * 获取C风格加表前缀的表名
 * @param $modelName string 表名
 * @return string C风格并且加表前缀的表名
 */
function getTableNameOfPrefixWithCStyle ($modelName) {
    return config('database.prefix') . toCStyle($modelName);
}

/**
 * 将字符串转为C风格形式（xxx_xxx）
 * @param $string
 * @return string
 */
function toCStyle ($string) {
    return Loader::parseName($string, 0);
}

/**
 * 将字符串转为Java风格形式（驼峰式 XxxXxx）
 * @param $string
 * @return string
 */
function toJavaStyle ($string) {
    return Loader::parseName($string, 1);
}

/**
 * 获取文件地址
 * @param $id integer 文件id
 * @param $domain bool 是否连接域名
 * @return mixed|string
 */
function getFileUrl ($id, $domain = false) {
    /*文件id为空，直接返回*/
    if (empty($id)) {
        return '';
    }
    $url = model('app\\admin\\model\\SysFile')
        ->where([
            'id' => $id
        ])
        ->value('relative_url');
    return $domain ? request()->domain() . htmlspecialchars_decode($url) : htmlspecialchars_decode($url);
}

/**
 * 获取系统选项的值
 * @param $name string 系统选项名
 * @return mixed|string
 */
function getSysOption ($name) {
    if (empty($name)) {
        return '';
    }
    return model('app\\admin\\model\\SysOption')
        ->where([
            'name' => $name
        ])
        ->value('value');
}
