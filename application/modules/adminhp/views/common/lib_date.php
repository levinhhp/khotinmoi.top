<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Saigon');
if(isset($is_edit)){
    $getdate=explode('-',$edit_comlunm);
	$redate=$getdate[2].'-'.$getdate[1].'-'.$getdate[0];
}else{
    $getdate=getdate();
    $redate=$getdate['mday'].'-'.$getdate['mon'].'-'.$getdate['year'];  
}
?>
<div class="<?php echo $col_value_add; ?>">
    <div class="form-group">
        <p><?php echo form_label($date_set_label); ?></p>        
        <?php 
        if(isset($is_edit)){
            echo form_input($date_field,$redate,['id'=>'datepicker']);
        }
        else{
            echo form_input($date_field,$redate,['id'=>'datepicker']);
        }
         ?>
    </div>
</div>