<?php
require_once 'vendor/autoload.php';
$wechat = new \panan\Wechatpay\Wechat();
$ali    = new \panan\Alipay\Alipay();
pdump($ali);
//pdump($wechat->h5_pay('32321321','32321321','32321321','32321321'));

//$jwt    = new \panan\Jwt\JwtTools();
//pdump($jwt->token(321));
//pdump($jwt->de_token("eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2MTkzMjI2NDQsImV4cCI6MTYyMTkxNDY0NCwiZGF0YSI6eyJ1c2VyX2lkIjozMjF9fQ.X00NTkuEa46oXxjHwoFD9qvqXk14TpWvNfQxWPzF9pk"));

//$key    = \panan\jiamifunction\jiami::panan_encode(123);
//$jiemi    = panan\jiamifunction\jiami::panan_decode("0FDD8F31EEF81FA6744C7EFA611E4FA6");

$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2MTU0NTI4MjksImV4cCI6OTM5MTQ1MjgyOSwiZGF0YSI6eyJ1c2VyX2lkIjoxfX0.6jUB0R2iM1afFw2qelf9LDQPICGNlmOD6mYGaP_XCVY';
$a     = \panan\http\Http::post("https://jiarong.xazbwl.com/shanghu/ShanghuMessage/shanghu_message",'','',$token);
pdump($a);

$data   = [
    [
        'name'  => '王志奇',
        'sex'   => 1,
        'sss'   => 2,
        'place' => '西安'
    ],
    [
        'name'  => '王志奇',
        'sex'   => 1,
        'sss'   => 3,
        'place' => '西安1'

    ],
    [
        'name'  => '王志奇',
        'sex'   => 1,
        'sss'   => 2,
        'place' => '西安2'

    ],
    [
        'name'  => '王志奇',
        'sex'   => 1,
        'sss'   => 3,
        'place' => '西安3'
    ],
    [
        'name'  => '王志奇',
        'sex'   => 1,
        'sss'   => 3,
        'place' => '西安3'
    ],
];
pdump(\panan\arrayfunction\ArrayFunctions::UniqueErArray($data));
pdump(\panan\arrayfunction\ArrayFunctions::ArrayStarOrEnd($data,0));
pdump(\panan\arrayfunction\ArrayFunctions::ErArrayToOneArray($data,'name'));
pdump(\panan\arrayfunction\ArrayFunctions::ArrayGroupBy($data,'sss'));
pdump(\panan\arrayfunction\ArrayFunctions::ErArrayField($data,['sss']));