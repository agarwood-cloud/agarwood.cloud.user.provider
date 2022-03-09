### 概述

UserCenter 是 Agarwood 的一部分，UserCenter是基础微信公众号平台的开发的用户管理服务，包含灵活的粉丝分配规则，粉粉操作行为上报等功能，


### 环境要求

- PHP 8.0+
- Swoole 4.8.6+
- Composer 2.0+

### 安装

```shell
git clone git@github.com:agarwood-cloud/agarwood.cloud.user.provider.git

composer install
```

### 配置

- 数据库链接、RPC、Redis等详细配置请看.env文件
- 如果是使用docker-compose，请配置docker-compose.yml/.env.docker.example(去掉.docker.example后缀)文件

### 运行

```shell
php bin/agarwood http:start
```

### 开源许可

Agarwood is an open-source software licensed under the [LICENSE](LICENSE)
