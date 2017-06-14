# CurlRequest
PHP curl系列函数封装

#### 发起请求
> `CurlRequest::Instance()->setHeaderMap($header)->setMethod('GET')->setUrl(Site::$host.Site::$buyItem)->request($param);`

#### 销毁HTTP对象
> `CurlRequest::destroy();`