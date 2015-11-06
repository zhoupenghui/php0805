<?php
/**
 * Created by PhpStorm.
 * User: zph
 * Date: 2015/11/2
 * Time: 23:24
 */

namespace Admin\Controller;


use Think\Controller;

class GiiController extends Controller
{

    /**
     * //生成代码(控制器,模型,视图)的控制器(代码生成器)
     *          :当用户输入表名时(有没有表名),自动生成该表对应的控制器,模型类,视图...
     * 规则:
     *    创建表的规范,根据该规范用来生成crud的代码:
     * 创建的表名必须和类的名字一样.  XXXController XXXModel
     * 字段的名字和表单元素的名字必须一样
     * 通过表中字段的注解用来说明生成什么样的表单元素
     * 例如:
     * create table brand(
     * id smallint unsigned primary key auto_increment,
     * name varchar(20)  not null default '' comment '品牌名称',
     * url varchar(50) not null default '' comment '品牌网址',
     * logo  varchar(50) not null default '' comment '品牌LOGO@file',
     * intro text comment '品牌描述@text',
     * status tinyint not null default 1  comment '是否显示@radio|1=是&0=否',
     * sort  smallint not null default 20 comment '排序'
     * ) engine myisam default charset utf8 comment '品牌';
     *
     */
    public function index()
    {
        if (IS_POST) {
            //1.提供模板中所需要的数据(从post请求中获取--表名)---制作模板Template(控制器的,视图的,模型的模板)
            header("Content-Type:text/html;charset=utf-8");//告诉浏览器,使用的是utf-8的编码格式
            //获取表单输入的表名---为模板准备值:该值就是模板中控制器|模型的名字
            //1.1提供类的名字
            $table_name = I('post.table_name');
            $name = parse_name($table_name, 1);//将用户输入的表名转换成规范的类名,0:brand->brand,brand_type_brand_type(都转换成首字母小写);1:brand->Brand,brand_type->Brand_Type
            //1.2提供meta_title的值从information_schame库中TABLES表中查询--数据库名为shop,表名为输入的表单元素的值,meta_title就是该表的注解)--从数据库中获取
            $sql = "SELECT TABLE_COMMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA='" . C('DB_NAME') . "' AND TABLE_NAME='$table_name';";
            //1.3获取查询的结果
            $row = M()->query($sql);
            //1.4把查询的结果赋值给$meta_title
            $meta_title = $row[0]['table_comment'];

            //2.让模板使用数据合成代码
            //把模板的路径定义为常量,方便后面使用
            define('TEMPLATE_PATH') or define('TEMPLATE_PATH', ROOT_PATH . 'Template/');//模板的路劲存则使用,不存在则创建之


            //////////////生成控制器////////////////////////
            //3.要生成控制器,就不能把模板输出到浏览器,要把模板的数据(html)输出到指定的文件中,以创建控制器
            //故把模板的代码放到ob中,就不会不放到浏览器中了--这里要开启ob缓存--把代码放到ob缓存中,获取代码后关闭并清理
            ob_start();
            //加载模板
            require TEMPLATE_PATH . 'Controller.tpl';//引入要创建的控制器类模板,----将tpl当成html执行就行了,该tpl中会输出表单元素的值---当做控制器的名字

            //3.1获取生成代码,将其输出到指定的文件中
            $controller_content = ob_get_clean();//获取代码,结束并清空ob缓存
            $controller_content = "<?php\r\n" . $controller_content;//把代码拼接成php格式的代码
            $controller_path = APP_PATH . 'Admin/Controller/' . $name . 'Controller.class.php';//控制器的代码放置的文件夹,设置控制器的路径
            file_put_contents($controller_path, $controller_content);//将数据写入到文件


            ///////////////////生成模型////////////////////////
            //4.要生成模型,就不能把模板输出到浏览器,要把模板的数据(html)输出到指定的文件中,以创建模型
            //模型里面有自动验证功能,所以要在数据库中获取每个字段的注解,作为验证的名字,通过表结构中的NULL判断是否为空,Key=PRI不必自动验证
            $sql = "show full columns from " . $table_name;
            $fields = M()->query($sql);//发送sql语句,并获取结果集---包括字段名字和注解
//            dump($fields);
            //对$fields中的comment用正则表达式判断,-----是否显示@radio|1=是&0=否   使编辑(添加)模板能够获取表单的类型
            foreach ($fields as &$field) {
                $comment = $field['comment'];//获取注解,从中可以获取字段名,表单类型,参数
                preg_match("/(.*)@([a-z]*)\|?(.*)/", $comment, $result);//正则----@前的,@,@后的,|:可有可无,|后的---通过正则表达式匹配$comment中的数据
                if (!empty($result)) {
                //判断$result是否匹配到,没有就什么都不做,匹配到了,就把匹配到的按照相应的要求弄出来
                    $field['comment'] = $result[1];//把数组中的放到$field中,实际上就是@之前的数据
                    $field['input_type'] = $result[2];//表单的类型
                    if (!empty($result[3])) {//判断 有没有 | 之后的数据
                        parse_str($result[3], $option_values);//把 1=是&0=否  放到数组中$option_values
                        $field['option_values'] = $option_values;//把$option_values放到$field中可能有多个,是一个数组
                    }
                }
            }
            unset($field);//清除$field,避免后面使用$field出错
            //原理和创建控制器一样
//            dump($fields);
            ob_start();//4.1开启ob缓存
            //4.2加载模板
            require TEMPLATE_PATH . 'Model.tpl';//引入要创建的控制器类模板,----将tpl当成html执行就行了,该tpl中会输出表单元素的值---当做控制器的名字
            //4.3获取生成代码,将其输出到指定的文件中,并清空ob缓存
            $model_content = ob_get_clean();
            $model_content = "<?php\r\n" . $model_content;//4.4把代码拼接成php格式的代码
            $model_path = APP_PATH . 'Admin/Model/' . $name . 'Model.class.php';//4.5模型的代码放置的文件夹,设置模型的路径
            file_put_contents($model_path, $model_content);//4.6将数据写入到文件


            ///////////////////生成index页面////////////////////////
            //5.开启ob缓存,加载模板
            ob_start();
            require TEMPLATE_PATH . 'index.tpl'; //加载模板
            $index_content = ob_get_clean();//获取代码,并清空ob缓存
            $view_dir = APP_PATH . 'Admin/View/' . $name;//控制器对应的视图文件夹
            //判断$view_dir是不是一个文件目录,是否存在
            if (!is_dir($view_dir)) {
                mkdir($view_dir, 0777, true);//不存在该目录,则创建之,并赋予最高权限,递归创建
            }
            $index_path = $view_dir . '/index.html';//设定视图文件
            file_put_contents($index_path, $index_content);//将数据写入到文件


            //////////////////////////////////生成edit页面//////////////////////////////
            ob_start();
            require TEMPLATE_PATH . 'edit.tpl'; //加载模板
            $edit_content = ob_get_clean();//获取代码,并清空ob缓存
            $view_dir = APP_PATH . 'Admin/View/' . $name;//控制器对应的视图文件夹
            //判断$view_dir是不是一个文件目录,是否存在
            if (!is_dir($view_dir)) {
                mkdir($view_dir, 0777, true);//不存在该目录,则创建之,并赋予最高权限,递归创建
            }
            $edit_path = $view_dir . '/edit.html';//设定视图文件
            file_put_contents($edit_path, $edit_content);//将数据写入到文件
            $this->success('代码成功生成!');
        } else {
            $this->display("index");//当用get方式访问时,跳转到生成代码的静态页面
        }
    }
}