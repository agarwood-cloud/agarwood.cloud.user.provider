### Overview

UserCenter is a part of Agarwood. UserCenter is a user management service developed by the basic WeChat official account platform. It includes functions such as flexible fan allocation rules and fan operation reporting.
> **[中文说明](README.zh-CN.md)**

### Requirements

- PHP 8.0
- Swoole 8.4.1+
- Composer

### Install

```shell
git clone git@github.com:agarwood-cloud/agarwood.cloud.user.provider.git

composer install
```

### Configuration

- Please see the .env file for detailed configuration of database link, RPC, Redis, etc.
- JWT uses Sha256 encryption, please see app-private-key.pen and app-public-key.key for detailed configuration

### Start

```shell
php bin/swoft http:start
```
### Contributors

This project exists thanks to all the people who contribute.
<a href="https://github.com/agarwood-cloud/agarwood.cloud.oauth.provider/graphs/contributors"></a>


### License

Agarwood is an open-source software licensed under the [LICENSE](LICENSE)

