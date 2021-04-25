<?php
namespace panan\Alipay;


use Yansongda\Pay\Pay;

class Alipay
{

    //app_id
    protected $app_id                   = '';

    //异步回调
    protected $notify_url               = '';

    //同步回调
    protected $return_url               = '';

    //公钥
    protected $ali_public_key           = '';

    //私钥
    protected $private_key              = '';

    //生产环境等级调整为 info，开发环境为 debug
    protected $level = 'debug';// APP APPID
    protected $config;

    public function initialize()
    {
        $this->config = [
            'app_id'                => $this->app_id,
            'notify_url'            => $this->notify_url,
            'return_url'            => $this->return_url,
            'ali_public_key'        => $this->ali_public_key,
            'private_key'           => $this->private_key,
            'log'           => [
//                'file'              => './logs/alipay.log',
                'level'             => $this->level, // 建议生产环境等级调整为 info，开发环境为 debug
                'type'              => 'single', // optional, 可选 daily.
                'max_file'          => 30, // optional, 当 type 为 daily 时有效，默认 30 天
            ],
            'http' => [ // optional
                'timeout' => 5.0,
                'connect_timeout' => 5.0,
                // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
            ],
            // 'mode' => 'dev', // optional,设置此参数，将进入沙箱模式
        ];

    }


    //type 1电脑  2手机网站  3App
    public function pay($type,$order,$price,$body,$return_url,$notify_url)
    {
        $this->config       = [
            'notify_url'        => $notify_url,
            'return_url'        => $return_url
        ];

        $pay_type           = '';
        switch ($type)
        {
            case 1:
                $pay_type   = 'web';
                break;
            case 2:
                $pay_type   = 'wap';
                break;
            case 3:
                $pay_type   = 'app';
                break;
        }

        return \Yansongda\Pay\Gateways\Alipay::$pay_type(
            [
                'out_trade_no' => $order,
                'total_amount' => $price,
                'subject'      => $body,
            ]
        )->send();
        // laravel 框架中请直接 return $alipay->web($order)
    }

    // 阿里 购物车多商品或单商品 通用支付 回调
    public function shopcar_many_pay_notify_url()
    {
        $alipay = Pay::alipay($this->config);
        try{
            //验签
            $data       = $alipay->verify();

            //订单状态 支付成功
            if($data->trade_status == 'TRADE_SUCCESS') {

                $local_order        = $data->out_trade_no;//本地订单号

                $out_order          = $data->trade_no;//微信订单号
                //业务逻辑

                //业务逻辑

                return $alipay->success()->send();
            }

        } catch (\Exception $e) {
            $e->getMessage();
        }
        //通知 ali 成功
        return $alipay->success()->send();
    }
}