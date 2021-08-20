# iOS-推送-Push(apns-voip)
apple aps推送和voip推送PHP代码

- 准备好证书
- 参考 https://www.jianshu.com/p/cc952ea07a08
- 打开`push.php`配置好相关参数
  - `devicetoken`
  - pem证书，可以相对路径也可绝对路径
  - pem证书密码
  - bundleId
- 使用终端 `php push.php`

