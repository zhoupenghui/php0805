<?php
define('WEB_URL', 'http://admin.shop.com');//设置域名
return array(
    'TMPL_PARSE_STRING' => array(
        '__CSS__' => WEB_URL . '/Public/Admin/css',//设置css样式
        '__JS__' => WEB_URL . '/Public/Admin/js',//设置js样式
        '__IMG__' => WEB_URL . '/Public/Admin/images',//设置Images样式
        '__LAYER__' => WEB_URL . '/Public/Admin/layer/layer.js',//设置layer样式(js效果)
        '__UPLOADIFY__' => WEB_URL . '/Public/Admin/uploadify',//设置layer样式(js效果)
        '__BRAND__' => "http://goodsbrand.b0.upaiyun.com",//设置又拍云的ip
    ),
);