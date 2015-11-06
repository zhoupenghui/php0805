<?php
/**
 * Created by PhpStorm.
 * User: zph
 * Date: 2015/11/2
 * Time: 22:42
 */

namespace Admin\Model;


use Think\Model;
use Think\Page;

class BaseModel extends Model
{
    // 是否批处理验证
    protected $patchValidate = true;
    /**
     * 分页工具条和分页数据的获取
     * @return array
     */
    public function getPageResult($wheres = array())//接收条件,当没有传过来条件时,设为可以空数组,让后面可以使用
    {
        //1.2.1设置查询的条件
        $wheres['status'] = array('neq', -1);
        //1.提供分页工具条
        //1.2获取总条数
        $totalRows = $this->where($wheres)->count();  //获取总条数--获取没有删除的数据,就是status不等于-1的数据
        //1.3由于页大小可能变动,所以在配置文件了设置,方便修改,
        $listRows = C('PAGE_SIZE') ? C('PAGE_SIZE') : 10;//获取页大小(当没有设置页大小时,使用默认的)
        //1.1要获取分页工具条,就要实例化Page类,并传入两个参数($totalRows--总记录数,$listRows---页大小)
        $page = new Page($totalRows, $listRows);  //实例化分页类
        //1.4改变分页工具栏的属性
        $page->rollPage = 3;//分页栏每页显示的页数;
        //1.5设置分页显示定制
        $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $pageHtml = $page->show();//获取分页工具条

        //2.获取当前分页列表数据,使用limit(当前页码--可以从$page中的firstRow获取,页大小--可以从$page中的listRows获取)
        $rows = $this->where($wheres)->limit($page->firstRow, $page->listRows)->select();
        //3.返回包含分页工具条和分页列表数据的数组
        return array('pageHtml' => $pageHtml, 'rows' => $rows);
    }

    /**
     * 根据id改变状态(包括删除和更新)
     * @param $id
     * @param $status
     * @return bool
     */
    public function changeStatus($id, $status)
    {
        //当为删除时,应该标志该条记录是删除的,不然以后添加时会出现重复的数据,导致不能添加,不符合业务逻辑
        //所以要判断是删除还是修改,是删除时,给name连接一个字符串(用concat()---数据库中的函数,连接字符串),表示已经删除
        //把status用数组表示
        $data = array('status' => $status);
        if ($status == -1) {//操作为删除时,
            $data['name'] = array('exp', "concat(name,'_del')");//拼接字段
        }
        //根据条件改变status的值
        //更新操作,当是修改时,要修改的字段只有status,当操作为删除时,要修改的字段要添加一个name
        return $this->where(array('id' => array('in', $id)))->save($data);
    }
}