<?php
//1.�Աȵ�ǰphp���л���,��ȡphp�汾,PHP_VERSION
if(version_compare(PHP_VERSION,'5.3.0','<')){
    die('�汾����');
}
//2.������Ŀ���е�Ŀ¼
define('ROOT_PATH',dirname($_SERVER['SCRIPT_FILENAME']).'/');
//3. ��ThinkPHP���Ŀ¼����Ϊ����
define('THINK_PATH',dirname(ROOT_PATH).'/ThinkPHP'.'/');
//4����Ӧ��Ŀ¼,APP_PATH
define('APP_PATH',ROOT_PATH.'Application'.'/');
//5.����RUNTIME_PATH,ָ������Ŀ¼----�����ڸ���Ŀ�ĸ���
define('RUNTIME_PATH',ROOT_PATH.'Runtime'.'/');
//6.��������ģʽ ���鿪���׶ο��� ����׶�ע�ͻ�����Ϊfalse
define('APP_DEBUG', true);
//7.��ģ��,�󶨺��ע����
define('BIND_MODULE','Home');

//8.���ؿ�ܴ���
require THINK_PATH.'ThinkPHP.php';
