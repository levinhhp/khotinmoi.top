<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Saigon');
if(isset($is_edit)){    
	$redate=date('d-m-Y H:i:s',strtotime($edit_comlunm));
}else{
    $redate=date('d-m-Y H:i:s');  
}
?>
<div class="<?php echo $col_value_add; ?>" style="display:none;">
    <div class="form-group">
        <p><?php echo form_label($datetime_set_label); ?></p>        
        <?php 
        if(isset($is_edit)){
            echo form_input($datetime_field,$redate);
        }
        else{
            echo form_input($datetime_field,$redate);
        }
         ?>
    </div>
</div>