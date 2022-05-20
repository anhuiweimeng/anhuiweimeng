<?php
namespace weimeng\wm-utils;
use think\Db;

/**
 * 工具方法类
 * 安徽盟数科技有限公司
 * 采用静态方式
 */

class Utils{


	/**
	 * [test 测试方法]
	 * @return [string] [测试字符串]
	 */
    public static function test(){
        echo 'success!';
    }


    /**
     * [randomStr 创建随机字符串]
     * @param  [type]  $length  [长度]
     * @param  boolean $numeric [是否纯数字 1是 0否]
     * @return [type]           [随机字符串]
     */
    public static function randomStr($length, $numeric = false) {
        $seed = base_convert(md5(microtime() . $_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
        $seed = $numeric ? (str_replace('0', '', $seed) . '012340567890') : ($seed . 'zZ' . strtoupper($seed));
        if ($numeric) {
            $hash = '';
        }else{
            $hash = chr(rand(1, 26) + rand(0, 1) * 32 + 64);
            --$length;
        }
        $max = strlen($seed) - 1;
        for ($i = 0; $i < $length; ++$i) {
            $hash .= $seed[mt_rand(0, $max)];
        }
        return $hash;   
	}


	/**
	 * [createNo 创建不重复的字符串，如订单表的order_id字段不重复的值]
	 * @param  [type]  $table   [description]
	 * @param  [type]  $field   [description]
	 * @param  [type]  $prefix  [description]
	 * @param  boolean $numeric [description]
	 * @return [type]           [description]
	 */
    public static function createNoByTableField($table, $field, $length=6, $prefix='',$numeric=true)
    {
    	if(empty($table) || empty($field) || empty($length)) return false;
    	if(!is_numeric($length)) return false;
    	if($length < 6) $length = 6;
        $billno = $prefix . date('YmdHis') . self::randomStr($length, $numeric);
        while (1) {
            $count = Db::name($table)->where($field,$billno)->count();
            if ($count <= 0) {
                
                ;
            }
            $billno = date('YmdHis') . self::randomStr($length, true);
        }
        return $prefix . $billno;
    }





}
