<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="<?php echo $col_value_add; ?>">
    <div class="form-group">
        <p><?php echo form_label($text_set_label); ?></p>
        <?php 
            $editor_id = 'editor'.$editorCounter;
            if(isset($is_edit)){
                echo form_textarea($text_field,$edit_comlunm,['id'=>$editor_id,'class'=>'form-control']);
            }
            else{                
                echo form_textarea($text_field,'',['id'=>$editor_id]);
            }
        ?>
    </div>
</div>		
<script>   
    <?php 
        if($text_field!='ht'){
    ?>
    CKEDITOR.replace( '<?php echo $editor_id ?>');
    <?php 
        }
    ?>
  </script>					    