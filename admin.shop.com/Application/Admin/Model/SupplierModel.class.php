<?php
/**
 * Created by PhpStorm.
 * User: zph
 * Date: 2015/10/30
 * Time: 20:59
 */

namespace Admin\Model;

use Think\Model;

class SupplierModel extends BaseModel
{
    // 自动验证定义
    protected $_validate = array(
        array('name', 'require', '名称不能够为空!'),//验证商家必须存在
        array('name', '', '名称已存在!', '', unique),//验证商家的名字不能重复
        array('intro', 'require', '简介不能够为空!')//验证简介必须存在
    );
}