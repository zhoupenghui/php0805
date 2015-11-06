<?php
/**
 * Created by PhpStorm.
 * User: zph
 * Date: 2015/11/4
 * Time: 23:40
 */

namespace Admin\Controller;


use Think\Controller;
use Think\Upload;

class UploadController extends Controller
{
    /**
     *接收到上传插件上传来的文件,并保存到指定的位置
     */
    public function index()
    {
        //1.接收上传的目录
        $dir = I("post.dir");
        if (!is_dir(ROOT_PATH . 'Uploads/' . $dir)) {//判断Uploads下的$dir是不是目录,不是则创建之
            mkdir(ROOT_PATH . 'Uploads/' . $dir, 0777, true);//递归创建
        }

        //2.接收上传过来的文件,并把偶承诺懂啊上面的目录中
        //文件上传的配置
        $config = array(
            'exts' => array(),//上传文件的后缀
//            'rootPath' => './Uploads/', //保存根路径--上传到本地文件中
            'rootPath' => './', //保存根路径--./代表又拍云的每个空间的根目录,必须是./
//            'savePath' => $dir.'/', //保存路径
            'driver'       => 'Upyun', // 文件上传驱动---上传到又拍云
            'driverConfig' => array(
                    'host'     => 'v0.api.upyun.com', //又拍云服务器
                    'username' => 'zph123', //又拍云操作员用户
                    'password' => 'zhoupenghui', //又拍云操作员密码
                    'bucket'   => 'goods'.$dir, //空间名称
                    'timeout'  => 90, //超时时间
            ), // 上传驱动配置
        );

        $uploader = new Upload($config);//要上传文件,就要实例化Upload类
        $info = $uploader->uploadOne($_FILES['Filedata']);//上传Filedata中的文件
        if ($info !== false) {
            echo $info['savepath'] . $info['savename'];//返回字符串给浏览器,那么onUploadSuccess方法就执行了,会接收服务器传过来的数据
        } else {
            echo $uploader->getError();
        }
    }
}