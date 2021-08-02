# afdian-php-sdk
爱发电非官方简易 PHP SDK by Akkariin

这是一个简单的 SDK，可以用于查询爱发电的订单和赞助者信息

## Installation
将项目 clone 到本地即可
```bash
git clone https://github.com/ZeroDream-CN/afdian-php-sdk/ .
```

## Examples
通过引入 afdian.php 即可调用相关函数
```php
<?php
// 引入 SDK 核心文件
include(__DIR__ . "/afdian.php");

// 设定 User ID 和 Token
define("USERID", "这里改为你的 User ID");
define("TOKEN", "这里改为你的 Token");

// 初始化 Afdian 对象
$afdian = new Afdian(USERID, TOKEN);
```
检测 User ID 与 Token 是否有效，与服务器连接是否正常
```php
echo sprintf("Ping status: %s\n", $afdian->pingServer() ? "Success" : "Failed");
```
获取所有的订单列表，并缓存到文件里，有效时间 120 秒
```php
$orders = $afdian->getAllOrders(120, "order_cache.json");
print_r($orders);
```
在返回的订单列表里进一步查询，根据订单 ID 获取信息
```php
$order = $afdian->getOrderById($orders, "这里写你的订单号");
print_r($order);
```
获取所有的赞助者，并缓存到 Redis，有效时间 600 秒
```php
$sponsors = $afdian->getAllSponsors(600, "&redis=127.0.0.1:6379");
print_r($sponsors);
```
得到赞助者列表后，根据用户名查询赞助者信息
```php
$user = $afdian->getSponsorByName($sponsors, "Lain音酱");
print_r($user);
```
另外也可以直接查看 afdian.php，每个方法都写了详细的注释。

## Redis Cache
如需使用 Redis 缓存订单或赞助者信息，可以在 getAllOrders/getAllSponsors 的第二个参数填入以下格式内容：
```
&redis=服务器地址:端口
```
例如：
```
&redis=127.0.0.1:6379
```

## Server Return
关于服务器返回的状态码以及更多信息，请查阅官方文档：

https://afdian.net/dashboard/dev

## License
本项目使用 MIT 协议开源

## About
本 SDK 非官方 SDK，可能有尚不完善的地方，欢迎通过 Issues 提出，或直接提交 PR。
