<?php

namespace ESCloud\SDK;

use ESCloud\SDK;
use Firebase\JWT\JWT;

class Auth
{
    protected $accessKey;

    protected $secretKey;

    protected $useJwt;

    protected $service = '';

    /**
     * Auth constructor.
     *
     * @param $accessKey
     * @param $secretKey
     * @param bool $useJwt 新的服务将启用 JWT 作为鉴权的 Token
     */
    public function __construct($accessKey, $secretKey, bool $useJwt = false)
    {
        $this->accessKey = $accessKey;
        $this->secretKey = $secretKey;
        $this->useJwt = $useJwt;
    }

    public function getAccessKey()
    {
        return $this->accessKey;
    }

    /**
     * 使用 HMAC 算法，对文本进行签名
     *
     * @param string $text 待签名的文本
     *
     * @return string 签名
     */
    public function makeSignature(string $text): string
    {
        $signature = hash_hmac('sha1', $text, $this->secretKey, true);

        return str_replace(array('+', '/'), array('-', '_'), base64_encode($signature));
    }

    /**
     * 制作API请求的授权信息
     *
     * @param string $uri      HTTP 请求的 URI
     * @param string $body     HTTP 请求的 BODY
     * @param int    $lifetime 授权生命周期
     * @param bool   $useNonce 授权随机值避免重放攻击
     *
     * @return string 授权信息
     */
    public function makeRequestAuthorization(string $uri, string $body = '', int $lifetime = 600, bool $useNonce = true, $service = 'es-cloud-default'): string
    {
        if ($this->useJwt) {
            $payload = array(
                'jti' => strtolower(Sdk\random_str(16)),
                'exp' => time() + $lifetime,
                'iss' => $service,
            );

            $token = JWT::encode($payload, $this->secretKey, 'HS256', $this->accessKey);

            return "Bearer {$token}";
        } else {
            $nonce = $useNonce ? SDK\random_str('16') : 'no';
            $deadline = time() + $lifetime;
            $signature = $this->makeSignature("{$nonce}\n{$deadline}\n{$uri}\n{$body}");

            return "Signature {$this->accessKey}:{$deadline}:{$nonce}:{$signature}";
        }
    }

    /**
     * 生成 Jwt Token
     *
     * @param array $payload 载荷
     *
     * @return string 资源播放Token
     */
    public function makeJwtToken(array $payload = []): string
    {
        return JWT::encode($payload, $this->secretKey, 'HS256');
    }
}
