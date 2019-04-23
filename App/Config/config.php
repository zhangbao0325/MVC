<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/23
 * Time: 21:27
 */

return array(
    'db' => array( // 数据库信息组
        'host' => '127.0.0.1',
        'port' => '8088',
        'user' => 'root',
        'pass' => '123456',
        'charset' => 'utf8',
        'dbname' => 'gwadmin'

    ),
    'App' => array( // 应用程序组
        'default_platform' => 'Test',
    ),
    'Front' => array( // 前台组

    ),
    'Admin' => array(    // 后台组

    ),
    'Test' => array(    // 测试平台组
        'default_controller' => 'User',
        'default_action' => 'list'
    ),
    // 其他
);

