<?php
namespace panan\Jwt;

use Firebase\JWT\JWT;

class JwtTools
{
    protected $key;

    public function __construct()
    {
        $this->key  = '123456';
    }

    //生成token
    public function token($user_id)
    {

        $plaload      = [
            'iat'   => time(),
            //过期时间为一周60*60*24*7
            'exp'   => time()+60*60*24*30,
            'data'  => [
                'user_id'      => $user_id,
            ],
        ];
        return JWT::encode($plaload,$this->key);
    }

    //    解密token
    public function de_token($token)
    {
        try {

            JWT::$leeway = 60;//当前时间减去60，把时间留点余地

            $decoded    = JWT::decode($token, $this->key, ['HS256']); //HS256方式，这里要和签发的时候对应

            $arr        = (array)$decoded;

            $data       = ['code'=>'success','data'=>$arr];

        } catch(\Firebase\JWT\SignatureInvalidException $e) {  //签名不正确

            $data       = ['code'=>'error','data'=>$e->getMessage()];

        }catch(\Firebase\JWT\BeforeValidException $e) {  // 签名在某个时间点之后才能用
            $data       = ['code'=>'error','data'=>$e->getMessage()];

        }catch(\Firebase\JWT\ExpiredException $e) {  // token过期
            $data       = ['code'=>'error','data'=>'请重新登录'];

        }catch(Exception $e) {  //其他错误
            $data       = ['code'=>'error','data'=>$e->getMessage()];

        }

        return $data;

    }


}