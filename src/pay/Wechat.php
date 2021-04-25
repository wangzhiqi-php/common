<?php
namespace panan\Wechatpay;
/**基于Yansongda\Pay\Pay 地址：https://pay.yansongda.cn/docs/v2/* */
class Wechat
{
    //APP appid
    protected $app_id       = '';

    //公众号appid
    protected $appid        = '';

    //小程序appid
    protected $miniapp_id   = '';

    //商户号
    protected $mch_id       = '';

    //商户对应的key
    protected $key          = '';

    //回调地址
    protected $notify_url   = '';

    //退款所需要的证书
    protected $cert_client  = '';
    protected $cert_key     = '';

    //生产环境等级调整为 info，开发环境为 debug
    protected $level = 'debug';// APP APPID

    protected $app;
    protected $config;


    public function initialize()
    {
        $this->config     = [
            'appid'             => $this->appid,
            'app_id'            => $this->app_id,
            'miniapp_id'        => $this->miniapp_id,
            'mch_id'            => $this->mch_id,
            'key'               => $this->key,
            'notify_url'        => $this->notify_url,//完整的http链接或者https链接
            'cert_client'       => $this->cert_client,
            'cert_key'          => $this->cert_key,
            'log'           => [ // optional
                'file'          => './logs/wechat.log',
                'level'         => $this->level, // 建议生产环境等级调整为 info，开发环境为 debug
                'type'          => 'single', // optional, 可选 daily.
                'max_file'      => 30, // optional, 当 type 为 daily 时有效，默认 30 天
            ],
        ];
    }

    //小程序支付 返回前段所需要的信息
    public function mini_app_pay($order,$price,$body,$openId,$notify_url)
    {
        $this->config['notify_url'] = $notify_url;

        return \Yansongda\Pay\Pay::wechat($this->config)->miniapp([
            'out_trade_no'  => $order,
            'body'          => $body,
            'total_fee'     => $price*100,
            'openid'        => $openId
        ]);
    }

    //app支付 直接返回app
    public function app_pay($order,$price,$body,$notify_url)
    {
        $this->config['notify_url'] = $notify_url;

        return \Yansongda\Pay\Pay::wechat($this->config)->app([
            'out_trade_no'  => $order,
            'body'          => $body,
            'total_fee'     => $price*100,
        ])->send();
    }

    //手机h5支付 直接跳转到微信
    public function h5_pay($order,$price,$body,$notify_url)
    {
        $this->config['notify_url'] = $notify_url;

        return \Yansongda\Pay\Pay::wechat($this->config)->wap([
            'out_trade_no'  => $order,
            'body'          => $body,
            'total_fee'     => $price*100,
        ])->send();
    }

    //公众号支付 返回所需参数
    public function gongzhong_pay($order,$price,$body,$openId,$notify_url)
    {
        $this->config['notify_url'] = $notify_url;

        return \Yansongda\Pay\Pay::wechat($this->config)->mp([
            'out_trade_no'  => $order,
            'body'          => $body,
            'openid'        => $openId,
            'total_fee'     => $price*100
        ]);
    }

    //申请退款
    public function refund($order,$all_price,$tui_price,$remark)
    {
        $order = [
            'out_trade_no'          => $order,
            'out_refund_no'         => time(),
            'total_fee'             => $all_price*100,
            'refund_fee'            => $tui_price*100,
            'refund_desc'           => $remark,
        ];

        $result = \Yansongda\Pay\Pay::wechat($this->config)->refund($order)->toArray();

        if($result['return_code'] == 'SUCCESS' && $result['return_msg'] == 'OK')
        {
            return ['code'=>1,'msg'=>'退款成功'];
        }else{
            return ['code'=>0,'msg'=>'退款失败'];
        }
    }

    //异步回调
    public function notify_url()
    {
        $wx      = \Yansongda\Pay\Pay::wechat($this->config);
        try{
            //验签
            $data       = $wx->verify();

            //订单状态 支付成功
            if($data->return_code == 'SUCCESS') {

                //本地订单号
                $local_order        = $data->out_trade_no;
                //微信订单号
                $out_order          = $data->transaction_id;

                //业务逻辑
                //业务逻辑
            }

        } catch (\Exception $e) {
            $e->getMessage();
        }
        return $wx->success()->send();
    }

}