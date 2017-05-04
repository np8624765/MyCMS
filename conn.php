<?php
session_start();
//包含数据库配置和数据库函数文件，以及工具文件
include_once 'admin/common/error.php';
include_once 'admin/common/filter.php';
include_once 'admin/common/cutstr.php';
include_once 'admin/config/DBconfig.php';
include_once 'admin/system/my_database.php';

//请在网站正式上线时开启下面的函数，关闭错误报告
//添加一条注释
error_reporting(0);

//实例化数据库对象
$conn = new My_database($dbtype,$dbhost,$dbname,$dbuser,$dbpassword);
//实例化错误对象
$error = new Error();
?>