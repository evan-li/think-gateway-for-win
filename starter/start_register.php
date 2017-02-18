#!/usr/bin/env php
<?php

// 检查扩展是否加载
require 'check_extension.php';

// 加载启动项
require_once __DIR__ . '/../../vendor/autoload.php';

use \Workerman\Worker;
use \GatewayWorker\Register;

// 加载配置文件
$config = require_once __DIR__ . '/config.php';

$registerConfig = $config['register'];

// register 服务必须是text协议
$register = new Register('text://' . $registerConfig['address']);
// 给注册服务属性赋值 (只赋值支持的属性)
foreach (['name', 'reloadable', 'secretKey'] as $key) {
    isset($registerConfig[$key]) && $register->$key = $registerConfig[$key];
}

// 如果不是在根目录启动，则运行runAll方法
if(!defined('GLOBAL_START')) {
    Worker::runAll();
}
