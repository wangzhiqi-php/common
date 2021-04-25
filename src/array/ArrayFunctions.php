<?php
namespace panan\arrayfunction;
/**
 *
 *数组功能。
 * @author      echo 潘安;
 * @version     2.0.0
 */
class ArrayFunctions
{
    /**
     * 二维数组过滤出有用的字段 并返回二维数组
     * @param array $data 待过滤数组
     * @param string $field 要拿出的字段的字段
     * @return array 返回所有符合要求的数组集合
     */
    public static function  ErArrayField(array $data, array $field)
    {

        $new_data      = [];

        foreach ($data as $k=>$v)
        {
            for ($i=0;$i<count($field);$i++)
            {
                $new_data[$k][$field[$i]]     = $v[$field[$i]];

            }
        }

        return $new_data;
    }

    /**
     * 二维数组过滤出有用的字段 并返回一维数组
     * @param array $arr 待过滤数组
     * @param string $key 下标
     * @return array 返回所有符合要求的数组集合
     */
    public static function  ErArrayFieldReturnOne(array $arr, $key)
    {
        if (!trim($key)) return false;

        preg_match_all("/\"$key\";\w{1}:(?:\d+:|)(.*?);/", serialize($arr), $output);

        return $output[1];
    }

    /**
     * 二维数组根据某个字段进行分组
     * @param  array $arr [二维数组]
     * @param  string $key [键名]
     * @return array      新的二维数组
     */
    public static function ArrayGroupBy($arr, $key){
        $grouped = array();
        foreach ($arr as $value) {
            $grouped[$value[$key]][] = $value;
        }
        if (func_num_args() > 2) {
            $args = func_get_args();
            foreach ($grouped as $key => $value) {
                $parms = array_merge($value, array_slice($args, 2, func_num_args()));
                $grouped[$key] = call_user_func_array('ArrayGroupBy', $parms);
            }
        }
        return $grouped;
    }


    /**
     * 二维数组转一维数组 并且可以指定任意的值和主键(可选)  并且值和主键可以是一样的
     * 二维数组过滤需要的字段并且可以指定下表
     * @param  array $data [二维数组]
     * @param  string $value [键名]
     * @param  string $primary_key [键名]
     * @return array      新的数组
     */
    public static function ErArrayToOneArray($data,$value,$primary_key='')
    {
        if($primary_key !== '')
        {
            return  array_column($data,$value,$primary_key);
        }
        return  array_column($data,$value);
    }

    /**
     * 获取数组的第一个或者末尾一个的值
     * @param  array $array [二维数组]
     * @param  int   $type [键名]   0第一个  1 末尾一个
     * @return array      新的数组
     */
    public static function ArrayStarOrEnd(array$array=[],$type=0)
    {
        if($type === 0)
        {
            $new_array = current($array);
        }else{
            $new_array = end($array);
        }

        return $new_array;
    }

    /**
     * 二维数组去重复项
     * @param  array $array2D [二维数组]
     * @param  bool   $stkeep
     * @param  bool   $ndformat
     * @return array      新的数组
     */
    public static function UniqueErArray($array2D,$stkeep=false,$ndformat=true)
    {
        // 判断是否保留一级数组键 (一级数组键可以为非数字)
        if($stkeep) $stArr = array_keys($array2D);
        // 判断是否保留二级数组键 (所有二级数组键必须相同)
        if($ndformat) $ndArr = array_keys(end($array2D));
        //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
        foreach ($array2D as $v){
            $v = join(",",$v);
            $temp[] = $v;
        }
        //去掉重复的字符串,也就是重复的一维数组
        $temp = array_unique($temp);
        //再将拆开的数组重新组装
        foreach ($temp as $k => $v)
        {
            if($stkeep) $k = $stArr[$k];
            if($ndformat)
            {
                $tempArr = explode(",",$v);
                foreach($tempArr as $ndkey => $ndval) $output[$k][$ndArr[$ndkey]] = $ndval;
            }else $output[$k] = explode(",",$v);
        }
        return $output;
    }

}