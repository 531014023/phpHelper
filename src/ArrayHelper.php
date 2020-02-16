<?php
/**
 * Created by PhpStorm.
 * User: dy
 * Date: 2020/2/16
 * Time: 10:37
 */
namespace phpHelper;
class ArrayHelper
{
    /**
     * 数组转换为字符串，主要用于把分隔符调整到第二个参数
     * @param  array  $arr  要连接的数组
     * @param  string $glue 分割符
     * @return string
     */
    static function arrToStr($arr, $glue = ',')
    {
        return implode($glue, $arr);
    }

    /**
     * 将二维数组数组按某个键提取出来组成新的索引数组
     */
    static function array_extract($array = [], $key = 'id')
    {
        $count = count($array);
        $new_arr = [];
        for($i = 0; $i < $count; $i++) {
            if (isset($array[$i]) && isset($array[$i][$key])) {
                $new_arr[] = $array[$i][$key];
            }
        }
        return $new_arr;
    }

    /**
     * 根据某个字段获取关联数组
     */
    static function array_extract_map($array = [], $key = 'id'){
        $count = count($array);
        $new_arr = [];
        for($i = 0; $i < $count; $i++) {
            $new_arr[$array[$i][$key]] = $array[$i];
        }
        return $new_arr;
    }

    /**
     * 关联数组转索引数组
     */
    static function relevance_arr_to_index_arr($array)
    {
        $new_array = [];
        foreach ($array as $v)
        {
            $temp_array = [];
            foreach ($v as $vv)
            {
                $temp_array[] = $vv;
            }
            $new_array[] = $temp_array;
        }
        return $new_array;
    }
    /**
     * 在数组指定位置插入新元素
     * @param array $array
     * @param mixed $item
     * @param int $offset
     * @return mixed
     */
    static public function insert($array, $item, $offset){
        array_splice($array,$offset,0,[$item]);
        return $array;
    }
    /**
     * 替换数组指定位置的元素
     * @param array $array
     * @param mixed $item
     * @param int $offset
     * @return mixed
     */
    static public function replace($array, $item, $offset){
        array_splice($array,$offset,1,[$item]);
        return $array;
    }
    /**
     * 删除数组指定索引的元素
     * @param array $array
     * @param int $offset
     * @return mixed
     */
    static public function delete($array, $offset){
        array_splice($array,$offset,1);
        return $array;
    }

    /**
     * 把数组转换成Tree
     * @param array $array 要转换的数据集
     * @param string $pid parent标记字段
     * @param string $level level标记字段
     * @return array
     */
    static function array_to_tree($array, $pk='id', $pid = 'parent_id', $child = 'child', $root = 0)
    {
        // 创建Tree
        $tree = [];
        if (!is_array($array)) {
            return [];
        }
        // 创建基于主键的数组引用
        $refer = [];
        foreach ($array as $key => $data) {
            $refer[$data[$pk]] =& $array[$key];
        }
        foreach ($array as $key => $data) {
            // 判断是否存在parent
            $parentId =  $data[$pid];
            if ($root == $parentId) {
                $tree[] =& $array[$key];
            } else if (isset($refer[$parentId])){
                is_object($refer[$parentId]) && $refer[$parentId] = $refer[$parentId]->toArray();
                $parent =& $refer[$parentId];
                $parent[$child][] =& $array[$key];
            }
        }
        return $tree;
    }

}