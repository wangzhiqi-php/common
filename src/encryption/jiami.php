<?php
namespace panan\jiamifunction;
/**
 *
 * 对称加密。
 * @author      echo 潘安;
 * @version     2.0.0
 */
class jiami
{
    const Sercet    = '625202f9149e061d ';
    const Key       = '5efd3f6060e20330';


    //加密
    public static function panan_encode($data, $key = false, $iv = false)
    {

        $key        = $key ? $key : self::Sercet;
        $iv         = $iv  ? $iv  : self::Key;

        return self::strToHex(openssl_encrypt($data, 'aes-128-cbc', $key, true, $iv));
    }

    //解密
    public static function panan_decode($data, $key = false, $iv = false)
    {

        $key        = $key ? $key : self::Sercet;
        $iv         = $iv  ? $iv  : self::Key;

        return openssl_decrypt(self::hexToStr($data), 'aes-128-cbc', $key, true, $iv);
    }


    //十六进制转字符串
    public static function hexToStr($hex)
    {
        $string="";
        for($i=0;$i<strlen($hex)-1;$i+=2)
            $string.=chr(hexdec($hex[$i].$hex[$i+1]));
        return  $string;
    }

    //字符串转十六进制
    public static function strToHex($string)
    {
        $hex="";
        $tmp="";
        for($i=0;$i<strlen($string);$i++)
        {
            $tmp = dechex(ord($string[$i]));
            $hex.= strlen($tmp) == 1 ? "0".$tmp : $tmp;
        }
        $hex=strtoupper($hex);
        return $hex;
    }

}