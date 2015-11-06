<extend name="Common:edit"/>
<block name="form">
    <form method="post" action="{:U()}">
        <table cellspacing="1" cellpadding="3" width="100%">
            <?php foreach($fields as $field):
                //如果是主键,就结束当前循环
              if($field['key']=='PRI'){
                                    continue;
                            }
                //strpos($field['comment'],'@')---查找@在$field['comment']中首次出现的位置
                //strstr($field['comment'],'@',true)---返回@之前的字符串
                //$comment=strpos($field['comment'],'@')==false?$field['comment']:strstr($field['comment'],'@',true);
            ?>
            <tr>
                <td class="label"><?php echo $field['comment'];?></td>
                <td>
                    <!--
                        //目的:根据每个字段的注解的表单类型,生成不同的表单元素
                            //获取每个注解的表单类型
                    --><?php
                        if($field['input_type']=='text'){
                             //如果input_type类型为text,是textarea
                             echo "<textarea name=\"{$field['field']}\" cols=\"60\" rows=\"4\">{\${$field['field']}}</textarea>\r\n";
                        }elseif($field['input_type']=='file'){
                              //如果input_type类型为file,是文件上传类型
                              echo "<input type=\"file\" name=\"{$field['field']}\" />";
                        }elseif($field['input_type']=='radio'){
                              //有多个单选按钮
                              //如果是单选按钮..根据可选的值生成多个多个单选按钮
                              if($field['field']=="status"){
                              //单选按钮的字段为status时,遍历输出每个按钮,键值对要有(键=>元素中的value,值对应元素的值)
                              foreach($field['option_values'] as $key =>$value){
                                    echo "<input type=\"radio\" class=\"status\" name=\"{$field['field']}\" value=\"{$key}\" /> {$value}";
                                }
                        }else{
                                    foreach($field['option_values'] as $key =>$value){
                                          echo "<input type=\"radio\"  name=\"{$field['field']}\" value=\"{$key}\" /> {$value}";
                                    }
                    }
                    }else{
                            //当判断完后,就只有类型为text的没有判断了,在这里判断,吐过字段名为sort,则有一个默认值
                    if($field['field']=="sort"){
                    echo "<input type=\"text\" name=\"{$field['field']}\" maxlength=\"60\" value=\"{\$sort|default=20}\">";
                    }else{
                    //如果类型为text的表单元素的name不是sort,就用这个
                    echo "<input type=\"text\" name=\"{$field['field']}\" maxlength=\"60\" value=\"{\${$field['field']}}\">";
                    }
                    }
                    ?>
                    <span class="require-field">*</span>
                </td>
            </tr>
            <?php endforeach;?>
            <tr>
                <td colspan="2" align="center"><br/>
                    <input type="hidden" name="id" value="{$id}"/>
                    <input type="submit" class="button ajax-post" value=" 确定 "/>
                    <input type="reset" class="button" value=" 重置 "/>
                </td>
            </tr>

        </table>
    </form>
</block>
