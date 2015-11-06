namespace Admin\Model;

use Think\Model;

class <?php echo $name;?>Model extends BaseModel
{
// 自动验证定义
protected $_validate = array(
//根据标准的字段生成验证规则,因为字段有多个,所以是一个数组,要递归判断生成
<?php foreach($fields as $field){
            //当字段名中null=yes和主键时,不必生成验证规则,因为他可以为空
            if($field['null']=='YES' ||$field['key']=='PRI' ){
                     continue;
            }
            //$field['comment']中,有@符号,我们只需要@符号之前的,所以要截取字符串
            //首先要判断有没有@符号,也就是获取@符号zai字符串中的位置,如果没有找到,说明没有@符号,如果找到,就截取@之前的
            //strpos($field['comment'],'@')---查找@在$field['comment']中首次出现的位置
            //strstr($field['comment'],'@',true)---返回@之前的字符串
            $comment=strpos($field['comment'],'@')==false?$field['comment']:strstr($field['comment'],'@',true);
            echo "array('{$field['field']}', 'require', '{$comment}不能够为空!'),\r\n";//验证字段必须存在
}?>
);
}