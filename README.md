# CurlRequest
PHP curl系列函数封装

#### 发起请求
> `CurlRequest::Instance()->setHeaderMap($header)->setMethod('GET')->setUrl(Site::$host.Site::$buyItem)->request($param);`

#### 销毁HTTP对象
> `CurlRequest::destroy();`

特别感谢@[shellvon同学](https://github.com/shellvon)