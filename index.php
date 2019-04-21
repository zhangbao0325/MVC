<?php
//include "./Frame/MySQLDB.class.php";
/*$conn = array(
    "host" => "10.90.101.81",
    "port" => "8088",
    "user" => "root",
    "pass" => "123456",
    "dbname" => "gwadmin"
);
$mysql = MySQLDB::getInstance($conn);
$result = $mysql->my_query("select * from xes_users;");
//var_dump($mysql);
foreach ($result as $row) {
    print $row['uid'] . "\t";
    print $row['username'] . "\t";
    print $row['realname'] . "\t";
    print $row['role'] . "\n";
}
echo "1111";*/

function autoload($class_name) {
    // 先把已经确定的核心类放到一个数组里面
    $frame_class_list = array(
        // '类名'	=>	'类文件地址'
        'Controller'=>'./Frame/Controller.class.php',
        'Model'=>'./Frame/Model.class.php',
        'Factory'=>'./Frame/Factory.class.php',
        'MySQLDB'=>'./Frame/MySQLDB.class.php',
    );
    // 判断是否为核心类
    if(isset($frame_class_list[$class_name])) {
        // 说明是核心类
        include $frame_class_list[$class_name];
    }
    // 判断是否为控制器类,截取后10个字符进行匹配
    elseif(substr($class_name, -10) == 'Controller') {
        // 说明是控制器类,应该在当前平台的Controller目录下进行加载
        include './App/' . PLATFORM . '/Controller/' . $class_name . '.class.php';
    }
    // 判断是否为模型类,截取后5个字符进行匹配
    elseif(substr($class_name, -5) == 'Model') {
        // 说明是模型类,应该在当前平台的Model目录下进行加载
        include './App/' . PLATFORM . '/Model/' . $class_name . '.class.php';
    }
}
// 注册自动加载函数
spl_autoload_register('autoload');

// 确定分发参数p(平台)
$default_platform = 'Test';// 暂时用Test
define('PLATFORM', isset($_GET['p']) ? $_GET['p'] : $default_platform);

// 确定分发参数c(控制器)
$default_controller = 'User';// 暂时为User

define('CONTROLLER', isset($_GET['c']) ? $_GET['c'] : $default_controller);

// 确定分发参数a(动作)
$default_action = 'list';
define('ACTION', isset($_GET['a']) ? $_GET['a'] : $default_action);

// 先确定控制器类的名字
$controller_name = CONTROLLER . 'Controller';
// 载入当前所需要的控制器类
include './App/' . PLATFORM . '/Controller/' . $controller_name . '.class.php';
// 实例化控制器类
$controller = new $controller_name; // 可变类

// 先拼凑出当前方法的名字
$action_name = ACTION . 'Action';

// 调用方法
$controller->$action_name();// 可变方法
