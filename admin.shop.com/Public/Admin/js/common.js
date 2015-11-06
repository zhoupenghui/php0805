$(function () {

    //列表中复选框的特效
    //通过all控制下面的状态
    $('.all').change(function () {
        //当选中时,所有的class=id的子选框都要被选中,也就是找到class=id的所有复选框,把该状态下复选框的状态赋给子选框
        //找到class=id
        $('.id').prop('checked', $(this).prop('checked'));
    });
    //在所有的class=id上加上事件
    $('.id').change(function () {
        //找到全选的标签,当所有的calss=id的标签中,只要有一个没有选,就不会全选,也就是说:当所有的calss=id的选项的没有被选中的状态为0是]时,表示全选
        $('.all').prop('checked', $('.id:not(:checked)').length == 0);
    });

//1.向带有class='ajax-get' 的标签上加上点击事件,事件处理函数发送ajax的 get请求给服务器
//通过class类找到含有ajax-get的标签,加上事件
    $(".ajax-get").click(function () {
        //发送ajax的get请求给服务器,传入url,参数,回调函数
        var url = $(this).attr('href');//获取url,该url就是我们要发送的地址,(url中已经有了参数,所以不必再指定参数了)
        $.get(url, function (data) {
            //返回的数据是一个对象,里面有属性,info:表示操作成功与否的提示,status表示成功与否:0表示失败,1:表示成功,url:表示操作后跳转的页面
            //判断是否成功
            //正上方---引入layer,使用layer中的方法,制作效果
            showLayer(data)
        });
        //当执行该ajax时,操作的默认执行就不需要了,所以关闭默认执行
        return false;
    });

//2.页面加载完毕后,找到class='ajax-post'的类,添加点击事件,并发送ajax的post请求
    $('.ajax-post').click(function () {
        var form = $(this).closest('form');//找到form表单源元,如果找到了,则说明是表单,没有找到,则是表单元素
        var url = form.length == 0 ? $(this).attr('url') : form.attr('action');//获取url
        var param = form.length == 0 ? $('.id').serialize() : form.serialize();//获取元素的值,序列化
        //发送post请求给服务器
        $.post(url, param, function (data) {
            //返回结果,使用layer
            showLayer(data);
        });
        return false;
    });

    /**
     * 根据服务器返回过来的信息,显示不同的信息
     */
    function showLayer(data) {
        //第一个参数时候说明信息,第二个是外观效果配置
        layer.msg(data.info, {
            icon: data.status ? 1 : 0,//表示笑脸图形---成功为1,失败为0
            offset: 0,
            //shift: 6,//  跳动
            time: 1000 //定义时间
        }, function () {
            //判断是否成功
            if (data.status) {
                //第三个参数可以是一个函数,当提示框隐藏时,跳转
                location.href = data.url;
            }
        });
    }
});