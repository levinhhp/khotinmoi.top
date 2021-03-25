<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="<?php echo $col_value_add; ?>">
    <div class="form-group">
        <p><?php echo form_label($tinytext_set_label); ?></p>
        <?php 
            $editor_id = 'editor'.$editorCounter;
            if(isset($is_edit)){
                echo form_textarea($tinytext_field,$edit_comlunm,['class'=>'form-control','id'=>$tinytext_field]);
            }
            else{                
                echo form_textarea($tinytext_field,false,['class'=>'form-control','id'=>$tinytext_field]);
            }            
            if($table_name == 'tblarticle'){
            ?>
            <br>
            <p>Tóm tắt tối đa: <input style="width:50px" type="text" name="" id="txtCount"></p>
            <hr>
            <?php 
            }
        ?>
    </div>
</div>	
<?php 
if($table_name == 'tblarticle'){
?>
<script language="javascript">
    $(document).ready(function() {
        var max_length = 255;
        $('#txtCount').val(max_length);
        $('#<?php echo $tinytext_field; ?>').keyup(function() {
            if ($(this).val().length > max_length) {
                $(this).val($(this).val().substring(0, max_length));
            }
            $('#txtCount').val(max_length - $(this).val().length);
        });
        $('#<?php echo $tinytext_field; ?>').blur(function() {
            if ($(this).val().length > max_length) {
            $(this).val($(this).val().substring(0, max_length));
            }
            $('#txtCount').val(max_length - $(this).val().length);
        });
    });
</script>	
<?php 
}
?>					    