<?php

/**
 * 格式化打印数据方法
 * @param object/array/string/json  $$data
 * @return object
 */
function pdump($data)
{
    echo "<pre>";
    print_r($data);
    exit();
}