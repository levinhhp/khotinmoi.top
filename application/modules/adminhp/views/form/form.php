<?php
$CI=&get_instance();
$CI->load->model('adminhp/admin_model');
//Lấy các nhãn cho form element
$getLabels=element($table_name,$labels);
if(count($getLabels)==0)
{
    echo 'Bạn chưa nhập tên các trường trong Controller/admin/adminhp.php';
    return;
}
$i=0;
foreach($getLabels as $label)
{
    $setLabels[$i]=$label;
    $i++;
}
$i=0;
$editorCounter=1;
//Hiển thị form nhập dữ liệu
$column=array();
if($column_type!=NULL)
{
    do{
        $column['Name']=key($column_type);	
    }while(next($column_type));				
}
foreach($fields as $field)
{
    if(isset($editContent))
    {
        $edit_value = $editContent[$field->Field];
    }
    if(element($field->Field,$column_type))
    {
        $column['Type']=element($field->Field,$column_type);
        if($column['Type'][0]=='radio')
        {
            if(isset($editContent)){						
                $data['edit_comlunm'] = $edit_value;
            }	
            foreach($this->config->item('field_col_add') as $col_k=>$col_v)
            {
                foreach($col_v as $col_l=>$col_c)
                {                    
                    if($col_l==$field->Field && $col_k==$table_name)
                    {
                        $data['col_value_add'] = $col_c;
                    }               
                }
            }	
            $data['table_name'] = $table_name;	
            $data['radio_column'] = $column['Type'][1];
            $data['radio_field']  = $field->Field;
            $data['radio_set_label'] = $setLabels[$i];
            $CI->load->view('common/lib_radio',$data);	
        }
        elseif($column['Type'][0]=='format')
        {   
            if(isset($editContent)){						
                $data['edit_comlunm'] = $edit_value;
            }	
            foreach($this->config->item('field_col_add') as $col_k=>$col_v)
            {
                foreach($col_v as $col_l=>$col_c)
                {
                    if($col_l==$field->Field && $col_k==$table_name)
                    {
                        $data['col_value_add'] = $col_c;
                    }               
                }
            }		                   
            $data['table_name'] = $table_name;
            $data['editorCounter'] = $editorCounter;
            $data['format_column_type'] = $column['Type'][1];
            $data['format_field']  = $field->Field;
            $data['format_set_label'] = $setLabels[$i];
            $CI->load->view('common/lib_format',$data);	
        }
        elseif($column['Type'][0]=='dropdown')
        {
            if(isset($editContent)){						
                $data['edit_comlunm'] = $edit_value;
            }	
            foreach($this->config->item('field_col_add') as $col_k=>$col_v)
            {
                foreach($col_v as $col_l=>$col_c)
                {
                    if($col_l==$field->Field && $col_k==$table_name)
                    {
                        $data['col_value_add'] = $col_c;
                    }               
                }
            }		
            $data['table_name'] = $table_name;
            $data['dropdown_column_type'] = $column['Type'][1];
            $data['dropdown_field']  = $field->Field;
            $data['dropdown_set_label'] = $setLabels[$i];
            $CI->load->view('common/lib_dropdown',$data);								
        }
        elseif($column['Type'][0]=='upload')
        {
            if(isset($editContent)){						
                $data['edit_comlunm'] = $edit_value;
            }		
            foreach($this->config->item('field_col_add') as $col_k=>$col_v)
            {
                foreach($col_v as $col_l=>$col_c)
                {
                    if($col_l==$field->Field && $col_k==$table_name)
                    {
                        $data['col_value_add'] = $col_c;
                    }               
                }
            }	
            $data['table_name'] = $table_name;
            $data['table_list'] = $table_list;
            $data['editorCounter'] = $editorCounter;
            $data['upload_field']  = $field->Field;
            $data['upload_set_label'] = $setLabels[$i];
            $CI->load->view('common/lib_upload',$data);					
        }								
    }
    elseif($field->Key=='PRI')
    {
        if(isset($editContent)){						
            $data['edit_comlunm'] = $edit_value;
        }	
        $data['pri_field']  = $field->Field;
        $data['table_name'] = $table_name;	
        $CI->load->view('common/lib_pri',$data);
    }
    elseif($field->Type=='date')
    {		
        if(isset($editContent)){						
            $data['edit_comlunm'] = $edit_value;
        }	
        foreach($this->config->item('field_col_add') as $col_k=>$col_v)
        {
           foreach($col_v as $col_l=>$col_c)
           {
                if($col_l==$field->Field && $col_k==$table_name)
               {
                 $data['col_value_add'] = $col_c;
               }               
           }
        }	
        $data['table_name'] = $table_name;								
        $data['date_field']  = $field->Field;
        $data['date_set_label'] = $setLabels[$i];
        $CI->load->view('common/lib_date',$data);                               							
                                                                    
    }
    elseif($field->Type=='datetime')
    {		
        if(isset($editContent)){						
            $data['edit_comlunm'] = $edit_value;
        }	
        foreach($this->config->item('field_col_add') as $col_k=>$col_v)
        {
           foreach($col_v as $col_l=>$col_c)
           {
                if($col_l==$field->Field && $col_k==$table_name)
               {
                 $data['col_value_add'] = $col_c;
               }               
           }
        }	
        $data['table_name'] = $table_name;								
        $data['datetime_field']  = $field->Field;
        $data['datetime_set_label'] = $setLabels[$i];
        $CI->load->view('common/lib_datetime',$data);                               							
                                                                    
    }
    elseif(substr($field->Type,0,3)=='int' || substr($field->Type,0,3)=='tinyint' || substr($field->Type,0,5)=='float' || substr($field->Type,0,6)=='double' || substr($field->Type,0,4)=='real')
    {
        if(isset($editContent)){						
            $data['edit_comlunm'] = $edit_value;
        }
        foreach($this->config->item('field_col_add') as $col_k=>$col_v)
        {
           foreach($col_v as $col_l=>$col_c)
           {
                if($col_l==$field->Field && $col_k==$table_name)
               {
                 $data['col_value_add'] = $col_c;
               }               
           }
        }
        $data['table_name'] = $table_name;		
        $data['int_field']  = $field->Field;
        $data['int_set_label'] = $setLabels[$i];
        $CI->load->view('common/lib_integer',$data);
    }
    elseif(substr($field->Type,0,7)=='varchar')
    {		
        if(isset($editContent)){						
            $data['edit_comlunm'] = $edit_value;
        }	
        foreach($this->config->item('field_col_add') as $col_k=>$col_v)
        {
           foreach($col_v as $col_l=>$col_c)
           {
            if($col_l==$field->Field && $col_k==$table_name)
               {
                 $data['col_value_add'] = $col_c;
               }               
           }
        }
        $data['table_name'] = $table_name;																	
        $data['varchar_field']  = $field->Field;
        $data['varchar_set_label'] = $setLabels[$i];
        $CI->load->view('common/lib_varchar',$data);
    }
    elseif($field->Type=='tinytext')
    {
        if(isset($editContent)){						
            $data['edit_comlunm'] = $edit_value;
        }	
        foreach($this->config->item('field_col_add') as $col_k=>$col_v)
        {
           foreach($col_v as $col_l=>$col_c)
           {
            if($col_l==$field->Field && $col_k==$table_name)
               {
                 $data['col_value_add'] = $col_c;
               }               
           }
        }
        $data['table_name'] = $table_name;	        
        $data['tinytext_field']  = $field->Field;
        $data['tinytext_set_label'] = $setLabels[$i];
        $CI->load->view('common/lib_tinytext',$data);     
    }
    elseif($field->Type=='text')
    {
        if(isset($editContent)){						
            $data['edit_comlunm'] = $edit_value;
        }	
        foreach($this->config->item('field_col_add') as $col_k=>$col_v)
        {
           foreach($col_v as $col_l=>$col_c)
           {
            if($col_l==$field->Field && $col_k==$table_name)
               {
                 $data['col_value_add'] = $col_c;
               }               
           }
        }
        $data['table_name'] = $table_name;	
        $data['editorCounter'] = $editorCounter;
        $data['text_field']  = $field->Field;
        $data['text_set_label'] = $setLabels[$i];
        $CI->load->view('common/lib_text',$data); 
        $editorCounter++;
    }
    if($column_type!=NULL)
    {
        next($column_type);
    }
    $i++;
}
?>
<div class="col-lg-12">		
    <div class="form-group">
        <?php 
            if(isset($is_edit)){
                echo form_submit('submit','Sửa',['class'=>'btn btn-primary']);
            ?>
            <a href="<?php echo site_url('adminhp/viewContent/'.$table_name) ?>" type="buttom" class="btn btn-danger">Quay lại</a>
            <?php									
            }else{
                echo form_submit('submit','Nhập',['class'=>'btn btn-primary']);
                echo form_reset('reset','Xóa',['class'=>'btn btn-danger']);
            }
            if($table_name=='tblarticle'){
            ?>	
            <a id="preview_<?php echo $table_name; ?>" type="buttom" class="btn btn-warning">Xem trước</a>											
            <?php 
            }
        ?>
    </div>
</div>
<?php 
if($table_name=='tblarticle'){
?>
<script type="text/javascript">
    $(document).ready(function(){
        $("#preview_<?php echo $table_name; ?>").on('click',function(){
            var title = $('input[name="title"]').val();
            var category_id = $('select[name="category"]').val();
            var category = $('select[name="category"] option:selected').text();
            var category_sub_id = $('select[name="category_sub"]').val();
            var category_sub = $('select[name="category_sub"] option:selected').text();
            var description = $('textarea[name="description"]').val();
            var content = CKEDITOR.instances.editor1.getData();
            var date_day = $('input[name="date_day"]').val();
            var post_time = $('input[name="post_time"]').val();
            $.ajax({
                cache:false,
                type:"POST",
                data:{title : title,category_id : category_id,category : category,category_sub_id : category_sub_id,category_sub : category_sub,description : description,content : content,date_day : date_day,post_time : post_time},
                url:"<?php echo site_url('adminhp/doPreview/'); ?>", 
                success:function(html){                    
                    window.open('<?php echo site_url('site/preview'); ?>','_blank');                   
                }                                                          
            });             
        });
    });
</script>
<?php
}
?>