<?php
//1.对比当前php运行环境,获取php版本,PHP_VERSION
if(version_compare(PHP_VERSION,'5.3.0','<')){
    die('版本过低');
}
//2.定义项目运行的目录
define('ROOT_PATH',dirname($_SERVER['SCRIPT_FILENAME']).'/');
//3. 将ThinkPHP框架目录定义为常量
define('THINK_PATH',dirname(ROOT_PATH).'/ThinkPHP'.'/');
//4定义应用目录,APP_PATH
define('APP_PATH',ROOT_PATH.'Application'.'/');
//5.定义RUNTIME_PATH,指定运行目录----定义在该项目的根下
define('RUNTIME_PATH',ROOT_PATH.'Runtime'.'/');
//6.开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG', true);
//7.绑定模型,绑定后就注释了
define('BIND_MODULE','Home');

//8.加载框架代码
require THINK_PATH.'ThinkPHP.php';
