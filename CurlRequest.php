<?php
namespace CurlRequest;

/**
 * Class CurlRequests.
 */
class CurlRequest
{
    private $curl_options = array(
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_0,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => 'utf8',
        CURLOPT_USERAGENT => 'CurlRequest',
    );
    private $timeout = 30;
    private $req_method = 'GET';
    private $headers = array();
    private $url = '';

    protected static $instances = array();
    /**
     * 单例.
     *
     * @return self
     */
    public static function Instance()
    {
        return self::InstanceInternal(__CLASS__);
    }

    /**
     * 常住进程模型，需要调用该方法，销毁对象
     *
     * @return void
     */
    public static function Destroy()
    {
        unset(self::$instances[__CLASS__]);
    }

    /**
     * 单例.
     *
     * @param string $cls 类名字.
     *
     * @return mixed
     */
    protected static function InstanceInternal($cls)
    {
        if (!isset(self::$instances[$cls]))
            self::$instances[$cls] = new $cls();
        return self::$instances[$cls];
    }

    /**
     * 设置curl的选项.
     *
     * @param $key
     * @param $value
     *
     * @return $this
     */
    public function setCurlOption($key, $value)
    {
        $this->curl_options[$key] = $value;
        return $this;
    }

    /**
     * 设置请求方法.
     *
     * @param string $method 请求方法.
     *
     * @return $this
     */
    public function setMethod($method)
    {
        $this->req_method = strtoupper($method);
        return $this;
    }

    /**
     * 设置请求域名
     *
     * @param string $url
     *
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * 批量这是Header
     *
     * @param array $header
     *
     * @return $this
     */
    public function setHeaderMap($header = array())
    {
        if (empty($header)) {
            return $this;
        }

        foreach ($header as $key => $value) {
            $this->setHeader($key, $value);
        }

        return $this;
    }

    /**
     * 设置请求头,比如User_agent等信息.
     *
     * @param $key
     * @param $value
     *
     * @return $this
     */
    public function setHeader($key, $value)
    {
        $this->headers[$key] = "{$key}: {$value}";
        return $this;
    }

    /**
     * 设置超时时间，单位秒,默认30秒.
     *
     * @param $timeout
     *
     * @return $this
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
        return $this;
    }

    /**
     * 发起一个请求.
     *
     * @param array  $params 请求的参数.
     *
     * @return mixed 请求结果.
     * @throws \Exception
     */
    public function request($params=array())
    {
        $ch = curl_init();
        foreach ($this->curl_options as $k => $v) {
            curl_setopt($ch, $k, $v);
        }
        switch ($this->req_method) {
            case 'GET':
                $contact_char = strpos($this->url, '?') === false ?  '?' : '&';
                $this->url = $this->url.$contact_char.http_build_query($params, null, '&');
                break;
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                break;
        }
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array_values($this->headers));
        curl_setopt($ch, CURLOPT_URL, $this->url);
        $response = curl_exec($ch);
        if ($response === false) {
            throw new \Exception(curl_error($ch));
        }
        curl_close($ch);
        return $response;
    }

}
