<?php
/**
 * 设置公用的函数
 */

/**
 * 从模型中获取错误信息,并拼接成ul
 */
function showErrors($model)
{
    //获取错误信息(可能是一个数组)
    $errors = $model->getError();
    //判断该错误信息是否是一个数组
    $msg = "<ul>";
    if (is_array($errors)) {
        foreach ($errors as $error) {
            //遍历每个错误
            $msg .= "<li>$error</li>";
        }
    } else {
        $msg .= "<li>$errors</li>";//把错误信息拼到li
    }
    $msg .= "</ul>";
    return $msg;
}