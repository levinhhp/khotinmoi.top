<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<div class="<?php echo $col_value_add; ?>">
    <div class="form-group">									
        <?php
        if($int_field=='view' || $int_field=='like_post' || ($int_field=='category' && $table_name=='tblads'))
        {
            echo '<p style="display:none;">'.form_label($int_set_label).'</p>';        
            if(isset($is_edit)){
                $data_number = array(
                    'name' => $int_field,                    
                    'class' => 'form-control',
                    'type' => 'number',
                    'value' => $edit_comlunm,
                    'style' => 'text-align:right;display:none;'
                );
                echo form_input($data_number);                          
            }else{
                $data_number = array(
                    'name' => $int_field,                    
                    'class' => 'form-control',
                    'type' => 'number',
                    'value' => set_value($int_field),
                    'style' => 'text-align:right;display:none;'
                );
                echo form_input($data_number);             
            }										
        }else{
            echo '<p>'.form_label($int_set_label).'</p>';        
            if(isset($is_edit)){
                $data_number = array(
                    'name' => $int_field,                    
                    'class' => 'form-control',
                    'type' => 'number',
                    'value' => $edit_comlunm,
                    'style' => 'text-align:right'
                );
                echo form_input($data_number);                
            }
            else{
                $data_number = array(
                    'name' => $int_field,                    
                    'class' => 'form-control',
                    'type' => 'number',
                    'value' => set_value($int_field),
                    'style' => 'text-align:right'
                );
                echo form_input($data_number);                
            }											
        }
        ?>
    </div>
</div>