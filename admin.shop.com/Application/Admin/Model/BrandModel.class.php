<?php
namespace Admin\Model;

use Think\Model;

class BrandModel extends BaseModel
{
// 自动验证定义
protected $_validate = array(
//根据标准的字段生成验证规则,因为字段有多个,所以是一个数组,要递归判断生成
array('name', 'require', '品牌名称不能够为空!'),
array('logo', 'require', '品牌LOGO不能够为空!'),
array('url', 'require', '品牌网址不能够为空!'),
array('status', 'require', '是否显示不能够为空!'),
array('sort', 'require', '排序不能够为空!'),
);
}