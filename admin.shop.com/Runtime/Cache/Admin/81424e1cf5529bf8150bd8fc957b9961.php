<?php if (!defined('THINK_PATH')) exit();?><!-- $Id: brand_info.htm 14216 2008-03-10 02:27:21Z testyang $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - <?php echo ($meta_title); ?> </title>
<meta name="robots" content="noindex, nofollow" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="http://admin.shop.com/Public/Admin/css/general.css" rel="stylesheet" type="text/css" />
<link href="http://admin.shop.com/Public/Admin/css/main.css" rel="stylesheet" type="text/css" />
    
    <link href="http://admin.shop.com/Public/Admin/uploadify/uploadify.css" rel="stylesheet" type="text/css" />

</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo U('index');?>"><?php echo mb_substr($meta_title,2,null,'utf-8');?>列表</a></span>
    <span class="action-span1"><a href="#">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - <?php echo ($meta_title); ?> </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">
   
    <form method="post" action="<?php echo U();?>" enctype="multipart/form-data">
        <table cellspacing="1" cellpadding="3" width="100%">
            <tr>
                <td class="label">品牌名称</td>
                <td>
                    <!--
                        //目的:根据每个字段的注解的表单类型,生成不同的表单元素
                            //获取每个注解的表单类型
                    --><input type="text" name="name" maxlength="60" value="<?php echo ($name); ?>"> <span
                        class="require-field">*</span>
                </td>
            </tr>
            <tr>
                <td class="label">品牌LOGO</td>
                <td>
                    <!--
                        //目的:根据每个字段的注解的表单类型,生成不同的表单元素
                            //获取每个注解的表单类型
                    --><input type="file" name="upload-logo" id="upload-logo"/>
                    <input type="hidden" name="logo" class="logo" value="<?php echo ($logo); ?>"/>
                    <div class="upload-img-box" style="display: <?php echo ($logo?'block':none); ?>">
                        <div class="upload-pre-item" >
                            <img src="http://goodsbrand.b0.upaiyun.com/<?php echo ($logo); ?>">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="label">品牌网址</td>
                <td>
                    <!--
                        //目的:根据每个字段的注解的表单类型,生成不同的表单元素
                            //获取每个注解的表单类型
                    --><input type="text" name="url" maxlength="60" value="<?php echo ($url); ?>"> <span class="require-field">*</span>
                </td>
            </tr>
            <tr>
                <td class="label">品牌描述</td>
                <td>
                    <!--
                        //目的:根据每个字段的注解的表单类型,生成不同的表单元素
                            //获取每个注解的表单类型
                    --><textarea name="intro" cols="60" rows="4"><?php echo ($intro); ?></textarea>
                    <span class="require-field">*</span>
                </td>
            </tr>
            <tr>
                <td class="label">是否显示</td>
                <td>
                    <!--
                        //目的:根据每个字段的注解的表单类型,生成不同的表单元素
                            //获取每个注解的表单类型
                    --><input type="radio" class="status" name="status" value="1"/> 是<input type="radio" class="status"
                                                                                            name="status" value="0"/> 否
                    <span class="require-field">*</span>
                </td>
            </tr>
            <tr>
                <td class="label">排序</td>
                <td>
                    <!--
                        //目的:根据每个字段的注解的表单类型,生成不同的表单元素
                            //获取每个注解的表单类型
                    --><input type="text" name="sort" maxlength="60" value="<?php echo ((isset($sort) && ($sort !== ""))?($sort):20); ?>"> <span
                        class="require-field">*</span>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center"><br/>
                    <input type="hidden" name="id" value="<?php echo ($id); ?>"/>
                    <input type="submit" class="button" value=" 确定 "/>
                    <input type="reset" class="button" value=" 重置 "/>
                </td>
            </tr>

        </table>
    </form>

</div>

<div id="footer">
共执行 1 个查询，用时 0.018952 秒，Gzip 已禁用，内存占用 2.197 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
<script type="text/javascript" src="http://admin.shop.com/Public/Admin/js/jquery-1.11.2.js"></script>
<script type="text/javascript" src="http://admin.shop.com/Public/Admin/layer/layer.js"></script>
<script type="text/javascript" src="http://admin.shop.com/Public/Admin/js/common.js"></script>

    <script type="text/javascript" src="http://admin.shop.com/Public/Admin/uploadify/jquery.uploadify.min.js" ></script>
    <script type="text/javascript" >
        $(function() {
            $("#upload-logo").uploadify({
                height        : 25,//指定插件的宽高
                width         : 145,
                'buttonText' : '选择图片',//定义上传按钮的文字
                'fileSizeLimit' : '100000KB',//指定文件上传的大小
                swf           : 'http://admin.shop.com/Public/Admin/uploadify/uploadify.swf',//指定swf的地址
                uploader      : '<?php echo U("Upload/index");?>',//在服务器上处理上传的代码
//                'fileObjName' : 'the_files',//上传文件时,name的名字  $_FIELDS['the_files'], ----它有一个默认值Filedata,搜易这里不必指定,直接用$_FIELDS['Filedata']获取文件信息
                'formData'      : {'dir' : 'brand'},//通过post方式,传入额外的参数---参数(上传文件的目录)
                'multi'    : true,//是否支持多文件上传
                'onUploadError' : function(file, errorCode, errorMsg, errorString) {
                    alert('该文件上传失败,错误为: ' + errorString);
                },
                'onUploadSuccess' : function(file, data, response) {
                    //上传成功后返回data,就包括文件上传后的路径,把该路劲放到.logo的隐藏域中,与数据一起保存到数据库中
                    $(".logo").val(data);
                    $(".upload-img-box").show();//当返回值时,显示
                    $(".upload-img-box img").attr("src","http://goodsbrand.b0.upaiyun.com/"+data);//要显示图片的路径
                }
            });
        });
    </script>

<script type="text/javascript">
    $(function(){
        $(".status").val([<?php echo ((isset($status) && ($status !== ""))?($status):1); ?>]);
    });
</script>

</body>
</html>