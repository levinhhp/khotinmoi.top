<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="<?php echo $col_value_add; ?>">
    <div class="form-group">
        <?php 
            if($radio_field == 'is_send'){
            ?>
            <p style="display:none;"><?php echo form_label($radio_set_label); ?>
            <?php                 
                $count=0;
                do{
                    if(isset($is_edit)){
                        if($edit_comlunm==key($radio_column)){
                            echo form_radio($radio_field,key($radio_column),true);
                        }
                        else{
                            echo form_radio($radio_field,key($radio_column),false);
                        }
    
                    }else{
                        if($count==0){
                            echo form_radio($radio_field,key($radio_column),true);					
                        }
                        else{
                            echo form_radio($radio_field,key($radio_column),false);                
                        }                
                    }
                    echo $radio_column[key($radio_column)];
                    $count++;
                }while(next($radio_column));
            ?>
            </p>
            <?php
            }else{
            ?>
            <p><?php echo form_label($radio_set_label); ?></p>
            <?php
            $count=0;
            do{
                if(isset($is_edit)){
                    if($edit_comlunm==key($radio_column)){
                        echo form_radio($radio_field,key($radio_column),true);
                    }
                    else{
                        echo form_radio($radio_field,key($radio_column),false);
                    }

                }else{
                    if($count==0){
                        echo form_radio($radio_field,key($radio_column),true);					
                    }
                    else{
                        echo form_radio($radio_field,key($radio_column),false);                
                    }                
                }
                echo $radio_column[key($radio_column)];
                $count++;
            }while(next($radio_column));
        }
        ?>							
    </div>
</div>