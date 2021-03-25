<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="<?php echo $col_value_add; ?>">
    <div class="form-group">
        <p><?php echo form_label($format_set_label); ?></p>
        <?php  
            if($format_column_type=='price')           
            {
                if(isset($is_edit)){
                    echo form_input($format_field,number_format($edit_comlunm,0,',',','),['class'=>'form-control price-input'.$editorCounter]);
                }
                else{                
                    echo form_input($format_field,set_value($format_field),['class'=>'form-control price-input'.$editorCounter]);
                }
            }  
            if($format_column_type == 'postNumber'){
                $options = [
                    '0' => 0,
                    '4' => 4,
                    '8' => 8,
                    '12' => 12
                ];
                if(isset($is_edit)){
                    echo form_dropdown($format_field, $options,$edit_comlunm);                  
                }else{
                    echo form_dropdown($format_field, $options,null);                  
                }
            }
            if($format_column_type == 'postFilter'){
                $option_filter = [
                    '0' => '-- Chọn kiểu lọc --',
                    '1' => 'Bài viết',
                    '2' => 'Categopry',                    
                ];
                if(isset($is_edit)){
                    echo form_dropdown($format_field, $option_filter,$edit_comlunm,['class'=>'form-control','style'=>'height:37px']);                  
                }else{
                    echo form_dropdown($format_field, $option_filter,null,['class'=>'form-control','style'=>'height:37px']);                  
                }                
            }
        ?>
    </div>
</div>	
<script type="text/javascript">
        $('.price-input<?php echo $editorCounter; ?>').on('input', function(e){        
            $(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g,'')));
        }).on('keypress',function(e){
            if(!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
        }).on('paste', function(e){    
            var cb = e.originalEvent.clipboardData || window.clipboardData;      
            if(!$.isNumeric(cb.getData('text'))) e.preventDefault();
        });
        function formatCurrency(number){
            var n = number.split('').reverse().join("");
            var n2 = n.replace(/\d\d\d(?!$)/g, "$&,");    
            return  n2.split('').reverse().join('');
        }
    </script>				    