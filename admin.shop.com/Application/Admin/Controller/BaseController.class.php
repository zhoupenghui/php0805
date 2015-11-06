<?php
/**
 * Created by PhpStorm.
 * User: zph
 * Date: 2015/11/2
 * Time: 19:20
 */

namespace Admin\Controller;

use Think\Controller;

class BaseController extends Controller
{
    //因为所有方法都要加载模型,故在加载该类时就自动创建对象
    //定义模型
    protected $model;
    public function _initialize()
    {//当加载控制器的自动完成时,就会触发该类,自动创建模型对象
        $this->model = D(CONTROLLER_NAME);//CONTROLLER_NAME--表示当前控制器的名字
    }

    /**
     * 从数据库中获取供应商的信息
     */
    public function index()
    {
        // 获取查询条件
        $wheres = array();//构建条件数组,多个条件查询时
        $keyword = I('get.keyword');
        if (!empty($keyword)) {
            //当条件不为空时,把条件放在数组中,并设定什么查询
            $wheres['name'] = array('like', "%$keyword%");
        }
        //.从模型中获取分页工具条和分页列表数据--传入条件
        $pageResult = $this->model->getPageResult($wheres);
        /**
         * $pageResult是一个数组,包括$rows:分页数据;  $pageHtml:分页工具栏
         */
        //3.把信息发布到页面assign
        $this->assign($pageResult);
        $this->assign('meta_title', $this->meta_title);
        //当我们修改,删除,添加时,状态发生改变,为了使我们操作后还是能够跳转到该页面,
        //就需要记录该页面,使用cookie保存该页面的url,当操作后,跳转到该url,
        //获取url---$_SERVER['REQUEST_URI']
        cookie('__forward__', $_SERVER['REQUEST_URI']);
        //4.选择页面display
        $this->display('index');
    }

    /**
     * 添加数据
     */
    public function add()
    {
        if (IS_POST) {
            //1.通过create获取数据,并验证,自动提交
            if ($this->model->create() !== false) {
                //2.进行添加add--判断添加是否成功
                if ($this->model->add() !== false) {
                    $this->success('添加成功',cookie('__forward__'));//添加成功后返回到原页面
                    return;//添加成功,防止执行后续代码
                }
            }
            //当create验证失败时,和添加入数据库失败是
            $this->error('操作失败' . showErrors($this->model));
        } else {
            $this->assign('meta_title', '添加' . $this->meta_title);//进入添加页面,获取该类的属性
            $this->display('edit');
        }
    }

    /**
     * 编辑
     */
    public function edit($id)
    {
        if (IS_POST) {
            //通过create获取数据
            //1.判断create是否验证成功和自动提交成功
            if ($this->model->create() !== false) {
                //2.判断更新到数据库是否成功
                if ($this->model->save() !== false) {
                    $this->success('更新成功', cookie('__forward__'));//编辑后跳转到当前页
                    return;//跳转后,防止执行后续代码
                }
            }
            //验证失败,更新失败
            $this->error('操作失败' . showErrors($this->model));//调用公共函数中的方法,获取错误信息
        } else {
            //get方式,通过id获取一条记录
            //1.通过id获取要编辑的数据  find
            $row = $this->model->find($id);
            //2.把数据分布到页面上
            $this->assign($row);
            $this->assign('meta_title', '编辑' . $this->meta_title);
            //3.选择要分布的页面
            $this->display('edit');
        }
    }

    /**
     * 状态发生改变:
     *              1.当改变对象状态时,字段status的值发生改变
     *              2.status无非是0,1,和-1   修改和删除都是状态发送改变,故可以用一个方法表示   修改和删除
     *              也就是说:当点击 修改状态,和删除时,都调用这同一个方法
     *              当删除时不传入status,给一个默认值  -1
     *              因为修改状态,和删除时,就只有status不同
     */
    public function changeStatus($id, $status = -1)
    {
        //1.调用模型中的changeStatus方法改变状态
        $result = $this->model->changeStatus($id, $status);
        //2.返回结果集,判断是否修改成功
        if ($result !== false) {
            $this->success('操作成功', cookie('__forward__'));//当删除或修改后,返回到原页面,
        } else {
            $this->error('操作失败');
        }
    }
}