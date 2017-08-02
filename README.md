# CurlRequest
PHP curl系列函数封装

#### 发起请求
```php
CurlRequest::Instance()->setHeaderMap($header)->setMethod('GET')->setUrl($url)->request($param);
```

#### 销毁HTTP对象
```php
CurlRequest::destroy();
```

特别感谢@[shellvon同学](https://github.com/shellvon)
