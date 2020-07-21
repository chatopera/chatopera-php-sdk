<p align="center">
    <b>Chatopera开发者平台：809987971， <a href="https://jq.qq.com/?_wv=1027&k=5S51T2a" target="_blank">点击链接加入群聊</a></b><br>
    <img src="https://user-images.githubusercontent.com/3538629/48105854-0bfcca00-e274-11e8-8eb4-ffb46a2c9179.png" width="200">
  </p>
  
  
# [chatopera-php-sdk](https://github.com/chatopera/chatopera-php-sdk)
企业聊天机器人-PHP开发工具包

本教程介绍如何使用 Chatopera 机器人开发者平台的[PHP SDK]()与机器人进行集成，阅读本教程需要 20 分钟时间。

[安装](#安装)

[创建机器人](#创建机器人)

[执行程序](#执行程序)

[帮助](#帮助)

[更多 SDK](#更多SDK)

[开源许可协议](#开源许可协议)

## 安装

[_composer_](https://getcomposer.org)是一个优秀到 PHP 项目包管理工具，Chatopera PHP SDK 可通过 composer 直接下载，包文件发布在[packagist](https://packagist.org/packages/chatopera/sdk)。

```
composer require chatopera/sdk
```

【注意】**如果项目不使用[_composer_](https://getcomposer.org)管理，那么可直接下载安装[Chatbot.php](https://github.com/chatopera/chatopera-php-sdk/blob/master/src/chatopera/sdk/Chatbot.php)文件到项目中。**

## 创建机器人

<p align="center">
  <b>登录Chatopera聊天机器人平台</b><br>
  <a href="http://bot.chatopera.com/" target="_blank">
      <img src="https://user-images.githubusercontent.com/3538629/48039685-e35fcc00-e1b0-11e8-81a9-f26d744fcd1d.png" width="800">
  </a>
</p>

### 点击“立即使用”

第一登录输入“邮箱”和“密码”，点击“回车键”，完成账户创建。

### 创建聊天机器人

点击“创建机器人”，并填入下面各项：

| 项目       | 值         | 描述                                           |
| ---------- | ---------- | ---------------------------------------------- |
| 机器人名称 | 小松       | 机器人的名字                                   |
| 描述       | 机器人示例 | 机器人的描述                                   |
| 语言       | zh_CN      | 机器人的语言，目前支持中文(zh_CN)和英文(en_US) |

【提示】其它项如兜底回复，问候语可以在创建后，设置页面修改。

### 下载知识库文件

下载知识库示例文件[chatopera_faq_samples.json](https://static-public.chatopera.com/bot/faq/chatopera_faq_samples.json)，保存文件名为*chatopera_faq_samples.json*。

<p align="center">
  <b>知识库文件格式</b><br>
      <img src="https://user-images.githubusercontent.com/3538629/88005551-396ad380-cb3c-11ea-8318-e70615bec281.png" width="500">
</p>

在该示例文件中，用 JSON 数组的形式存储了 100 个问答对，字段含义如下：

| key              | type     | required | description                                                                                                                    |
| ---------------- | -------- | -------- | ------------------------------------------------------------------------------------------------------------------------------ |
| categories       | [string] | false    | 分类名称，支持层级比如 `["一级", "二级"]`，服务器端自动创建对应分类                                                            |
| enabled          | boolean  | true     | 是否启用，代表该问答对导入后是否支持来访者检索                                                                                 |
| post             | string   | true     | 问答对的标准问                                                                                                                 |
| replies          | [object] | true     | 问答对的回答，数组长度大于 0, `content`是文本内容，`rtype`为`plain`表示`content`为纯文本; `rtype`为`html`表示`content`为富文本 |
| similarQuestions | [string] | false    | 问答对里的相似问                                                                                                               |

### 导入知识库

<p align="center">
  <b>上传知识库文件</b><br>
  <a href="http://bot.chatopera.com/" target="_blank">
      <img src="https://user-images.githubusercontent.com/3538629/88005421-f7da2880-cb3b-11ea-9ceb-bb132652963d.png" width="500">
  </a>
</p>

选择*chatopera_faq_samples.json*，这时，会显示问答对列表，点击“提交”，在进度条完成后，知识库导入成功。

### 测试知识库

<p align="center">
  <b>知识库测试窗口</b><br>
  <a href="http://bot.chatopera.com/" target="_blank">
      <img src="https://user-images.githubusercontent.com/3538629/48043965-5161be80-e1c4-11e8-99c6-53f36fc5e29a.png" width="300">
  </a>
</p>

**输入：** 下雨天在屋外烧电焊注意什么

确认得到回复。

### 获取*ClientId*和*Secret*

集成机器人服务的方式是通过 SDK，每个机器人实例需要通过*ClientId*和*Secret*初始化，完成认证和授权。打开机器人【设置】页面，拷贝*ClientId*和*Secret*。

<p align="center">
  <b>显示Secret</b><br>
  <a href="http://bot.chatopera.com/" target="_blank">
      <img src="https://user-images.githubusercontent.com/3538629/48044641-f4680780-e1c7-11e8-889e-01df6b0cbd7f.png" width="800">
  </a>
</p>

## 执行示例程序

假设您已经:

1. 准备好**ClientId**和**Secret**了；

2. 安装了[chatopera/sdk](https://packagist.org/packages/chatopera/sdk)，

那么，可以用以下代码测试。

```php
<?php

include_once __DIR__ . "/vendor/autoload.php";

$appId = "YOUR CLIENT ID";
$secret = "YOUR SECRET";

$chatbot = new Chatopera\SDK\Chatbot($appId, $secret);
print_r($chatbot->command("GET", "/"));
```

<p align="center">
  <b>返回结果示例</b><br>
  <a href="http://bot.chatopera.com/" target="_blank">
      <img src="https://user-images.githubusercontent.com/3538629/48771009-177fd480-ecfb-11e8-9ce5-fa2a8adeea27.png" width="400">
  </a>
</p>

## 接口概述

各接口的详细描述请访问[开发者平台文档中心](https://docs.chatopera.com/products/chatbot-platform/integration.html)。

同时提供[PHP Docs](https://chatopera.github.io/chatopera-php-sdk/classes/Chatopera.SDK.Chatbot.html)为使用参考。

## 贡献

单元测试

```
./vendor/bin/phpunit --bootstrap vendor/autoload.php test/ChatbotTest.php
```

## 卸载

从项目中卸载 SDK。

```
composer remove chatopera/sdk
```

## 更多 SDK

<p align="center">
  <b>集成面板</b><br>
  <a href="http://bot.chatopera.com/" target="_blank">
      <img src="https://user-images.githubusercontent.com/3538629/48044669-1e212e80-e1c8-11e8-918c-8e6fdf4e95c0.png" width="800">
  </a>
</p>

## 开源许可协议

Copyright (2018) [北京华夏春松科技有限公司](https://www.chatopera.com/)

[Apache License Version 2.0](./LICENSE)

Copyright 2017-2018, [北京华夏春松科技有限公司](https://www.chatopera.com/). All rights reserved. This software and related documentation are provided under a license agreement containing restrictions on use and disclosure and are protected by intellectual property laws. Except as expressly permitted in your license agreement or allowed by law, you may not use, copy, reproduce, translate, broadcast, modify, license, transmit, distribute, exhibit, perform, publish, or display any part, in any form, or by any means. Reverse engineering, disassembly, or decompilation of this software, unless required by law for interoperability, is prohibited.

[![chatoper banner][co-banner-image]][co-url]

[co-banner-image]: https://user-images.githubusercontent.com/3538629/42383104-da925942-8168-11e8-8195-868d5fcec170.png
[co-url]: https://www.chatopera.com
