### 概述

UserCenter 是 Agarwood 的一部分，UserCenter是基础微信公众号平台的开发的用户管理服务，包含灵活的粉丝分配规则，粉粉操作行为上报等功能，


### 环境要求

- PHP 8.0
- Swoole 8.4.1+
- Composer

### 安装

```shell
git clone git@github.com:agarwood-cloud/agarwood.cloud.user.provider.git

composer install
```

### 配置

- 数据库链接、RPC、Redis等详细配置请看.env文件

### 运行

```shell
php bin/agarwood http:start
```

### 开源许可

Agarwood is an open-source software licensed under the [LICENSE](LICENSE)
