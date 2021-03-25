<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if($varchar_field=='author'){
    ?>
    <div class="<?php echo $col_value_add; ?>" style="display:none;">
        <div class="form-group">
            <p><?php echo form_label($varchar_set_label); ?></p>
            <?php 
                if(isset($is_edit)){
                    echo form_input($varchar_field,$edit_comlunm,['class'=>'form-control','readonly'=>true]); 
                }else{
                    echo form_input($varchar_field,$_SESSION['username'],['class'=>'form-control','readonly'=>true]);     
                }
            ?>        
        </div>
    </div>
    <?php                                   
}elseif($varchar_field=='description'){
    ?>
    <div class="<?php echo $col_value_add; ?>">
    <div class="form-group">
    <p><?php echo form_label($varchar_set_label); ?></p>
    <?php
    if(isset($is_edit)){
        echo form_textarea($varchar_field,$edit_comlunm,['class'=>'form-control','id'=>$varchar_field]);
    }else{
         echo form_textarea($varchar_field,false,['class'=>'form-control','id'=>$varchar_field]);
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
}elseif($varchar_field == 'image_square'){
    ?>
    <div class="<?php echo $col_value_add; ?>">
    <p><?php echo form_label($varchar_set_label); ?></p>
    <?php 
        if(isset($is_edit)){
        ?>
        <img style='border:1px solid #ddd;width:150px;margin-bottom:15px;display:block;' id="blah_square" src="<?php echo $edit_comlunm; ?>" alt="your image" />        
        <?php
        $upload_hidden_square = "hid".$varchar_field;
        echo form_hidden($upload_hidden_square,$edit_comlunm);
        }else{
        ?>
        <img style='border:1px solid #ddd;width:150px;margin-bottom:15px;display:block;' id="blah_square" src="backend/img/noimage.png" alt="your image" />
        <?php
        }
    echo form_label('Chọn ảnh', 'imgInp_blah_square',['id'=>'upload_avatar_square']);
    echo form_upload($varchar_field,'',['class'=>'fileUpload form-control','style'=>'opacity:0;position:absolute;z-index:-1;','id'=>'imgInp_blah_square']);
    ?>
    </div>
    <?php
}elseif($varchar_field=='password'){
    if(isset($is_edit)){ 
        ?>
        <div class="form-group" style="display:none;">
            <p><?php echo form_label($varchar_set_label); ?></p>
            <?php echo form_password($varchar_field,$edit_comlunm,['class'=>'form-control']);?>        
        </div>
        <?php        
    }
    else{
    ?>
    <div class="<?php echo $col_value_add; ?>">
        <div class="form-group">
            <p><?php echo form_label($varchar_set_label); ?></p>
            <?php echo form_password($varchar_field,null,['class'=>'form-control']);?>        
        </div>
    </div>	
    <div class="<?php echo $col_value_add; ?>">
        <div class="form-group">
            <p><?php echo form_label('Xác nhận '.$varchar_set_label); ?></p>
            <?php echo form_password('re'.$varchar_field,null,['class'=>'form-control']);?>        
        </div>
    </div>	
    <?php  
    }  
}
elseif($varchar_field=='role'){    
    ?>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#frmAddContent').submit(function(){
                if(!$('#request-formr input[type="checkbox"]').is(':checked')){
                    alert("Bạn chưa chọn quyền.");
                  return false;
                }
            });
        });
    </script>   
     <script language="javascript">
        function checkall(class_name,obj)
        {
            var items=document.getElementsByClassName(class_name);
            if(obj.checked == true)
            {
                for(i=0;i<items.length;i++)
                    items[i].checked=true;
                    items[i].value='1';
            }
            else
            {
                for(i=0;i<items.length;i++)
                    items[i].checked=false;						
            }
        }	
    </script>	  
    <div class="<?php echo $col_value_add; ?>"> 
        <div class="panel panel-default">
            <div class="panel-heading">
                <p><?php echo form_label($varchar_set_label); ?></p>  
            </div>   
            <div class="panel-body">
                <?php echo form_checkbox('chkfull',null,false,['style'=>'float:left;margin-right:7px;','class'=>'form-control','onclick'=>"checkall('chrole',this)"]); ?>
                <?php echo form_label('Full quyền','',['style'=>'margin-top:3px;']); ?>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
    <div id="request-formr">
    <?php
     if(isset($is_edit)){ 
        foreach($table_list as $h=>$v)
        {    
            $this->db->where('username',$primaryKey);
            $editrole=$this->db->get('tblrole'); 
            $ok=0;
            foreach($editrole->result() as $itemrole)
            {
                $editrolecon=$itemrole->access;
                if(($h.'.'.$v)==$itemrole->table_name.'.'.$itemrole->table_label)
                {
                    $ok=1;
                    break;
                }
            }   
        ?>
        <div class="role_item col-lg-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php 
                        if($ok==1){
                            echo form_checkbox('chrole[]',$h.'.'.$v.'.'.$editrolecon,true,['id'=>'capnhat'.$h,'class'=>"chrole form-control",'style'=>'float:left;margin-right:7px']);
                        }
                        else{
                            echo form_checkbox('chrole[]',$h.'.'.$v,false,['id'=>'capnhat'.$h,'class'=>"chrole form-control",'style'=>'float:left;margin-right:7px']);
                        }            
                        echo form_label($v,'',['style'=>'margin-top:2px']);
                    ?>
                </div>
                <div class="panel-body">
                    <?php 
                        if($ok==1){
                            if($editrolecon=='add-edit-delete')
                            {
                            ?>
                            <p>
                                <?php 
                                    if($h=='tblinformation' || $h=='tblmeta'){
                                        echo form_checkbox('checkboxaddhan','Thêm',true,['class'=>'checkboxaddhan'.$h.' form-control','disabled'=>true,'style'=>'float:left;margin-right:7px']);
                                        echo form_label('Thêm','add',['style'=>'margin-top:2px']);                        
                                    }else{
                                        echo form_checkbox('checkboxaddhan','Thêm',true,['class'=>'checkboxaddhan'.$h.' form-control','style'=>'float:left;margin-right:7px']);
                                        echo form_label('Thêm','add',['style'=>'margin-top:2px']);                         
                                    }    
                                ?>     
                            </p>               
                            <p>
                                <?php 
                                    echo form_checkbox('checkboxedithan','Sửa',true,['class'=>'checkboxedithan'.$h.' form-control','style'=>'float:left;margin-right:7px']);
                                    echo form_label('Sửa','edit',['style'=>'margin-top:2px']);
                                ?>
                            </p>
                            <p>
                                <?php 
                                    if($h=='tblinformation' || $h=='tblmeta')
                                    { 
                                        echo form_checkbox('checkboxxoahan','Xóa',true,['class'=>'checkboxxoahan'.$h.' form-control','disabled'=>true,'style'=>'float:left;margin-right:7px']);
                                        echo form_label('Xóa','delete',['style'=>'margin-top:2px']);                        
                                    }else{
                                        echo form_checkbox('checkboxxoahan','Xóa',true,['class'=>'checkboxxoahan'.$h.' form-control','style'=>'float:left;margin-right:7px']);
                                        echo form_label('Xóa','delete',['style'=>'margin-top:2px']);                          
                                    }
                                ?>    
                            </p>   
                            <?php
                            }
                            elseif($editrolecon=='add-edit')
                            {
                            ?>
                            <p>
                                <?php 
                                    if($h=='tblinformation' || $h=='tblmeta'){
                                        echo form_checkbox('checkboxaddhan','Thêm',true,['class'=>'checkboxaddhan'.$h.' form-control','disabled'=>true,'style'=>'float:left;margin-right:7px']);
                                        echo form_label('Thêm','add',['style'=>'margin-top:2px']);                        
                                    }else{
                                        echo form_checkbox('checkboxaddhan','Thêm',true,['class'=>'checkboxaddhan'.$h.' form-control','style'=>'float:left;margin-right:7px']);
                                        echo form_label('Thêm','add',['style'=>'margin-top:2px']);                         
                                    }    
                                ?>     
                            </p>               
                            <p>
                                <?php 
                                    echo form_checkbox('checkboxedithan','Sửa',true,['class'=>'checkboxedithan'.$h.' form-control','style'=>'float:left;margin-right:7px']);
                                    echo form_label('Sửa','edit',['style'=>'margin-top:2px']);
                                ?>
                            </p>
                            <p>
                                <?php 
                                    if($h=='tblinformation' || $h=='tblmeta')
                                    { 
                                        echo form_checkbox('checkboxxoahan','Xóa',false,['class'=>'checkboxxoahan'.$h.' form-control','disabled'=>true,'style'=>'float:left;margin-right:7px']);
                                        echo form_label('Xóa','delete',['style'=>'margin-top:2px']);                        
                                    }else{
                                        echo form_checkbox('checkboxxoahan','Xóa',false,['class'=>'checkboxxoahan'.$h.' form-control','style'=>'float:left;margin-right:7px']);
                                        echo form_label('Xóa','delete',['style'=>'margin-top:2px']);                          
                                    }
                                ?>    
                            </p>
                            <?php
                            }
                            elseif($editrolecon=='add-delete')
                            {
                            ?>
                            <p>
                                <?php 
                                    if($h=='tblinformation' || $h=='tblmeta'){
                                        echo form_checkbox('checkboxaddhan','Thêm',true,['class'=>'checkboxaddhan'.$h.' form-control','disabled'=>true,'style'=>'float:left;margin-right:7px']);
                                        echo form_label('Thêm','add',['style'=>'margin-top:2px']);                        
                                    }else{
                                        echo form_checkbox('checkboxaddhan','Thêm',true,['class'=>'checkboxaddhan'.$h.' form-control','style'=>'float:left;margin-right:7px']);
                                        echo form_label('Thêm','add',['style'=>'margin-top:2px']);                         
                                    }    
                                ?>     
                            </p>               
                            <p>
                                <?php 
                                    echo form_checkbox('checkboxedithan','Sửa',false,['class'=>'checkboxedithan'.$h.' form-control','style'=>'float:left;margin-right:7px']);
                                    echo form_label('Sửa','edit',['style'=>'margin-top:2px']);
                                ?>
                            </p>
                            <p>
                                <?php 
                                    if($h=='tblinformation' || $h=='tblmeta')
                                    { 
                                        echo form_checkbox('checkboxxoahan','Xóa',true,['class'=>'checkboxxoahan'.$h.' form-control','disabled'=>true,'style'=>'float:left;margin-right:7px']);
                                        echo form_label('Xóa','delete',['style'=>'margin-top:2px']);                        
                                    }else{
                                        echo form_checkbox('checkboxxoahan','Xóa',true,['class'=>'checkboxxoahan'.$h.' form-control','style'=>'float:left;margin-right:7px']);
                                        echo form_label('Xóa','delete',['style'=>'margin-top:2px']);                          
                                    }
                                ?>    
                            </p>
                            <?php
                            }
                            elseif($editrolecon=='edit-delete')
                            {
                            ?>
                            <p>
                                <?php 
                                    if($h=='tblinformation' || $h=='tblmeta'){
                                        echo form_checkbox('checkboxaddhan','Thêm',false,['class'=>'checkboxaddhan'.$h.' form-control','disabled'=>true,'style'=>'float:left;margin-right:7px']);
                                        echo form_label('Thêm','add',['style'=>'margin-top:2px']);                        
                                    }else{
                                        echo form_checkbox('checkboxaddhan','Thêm',false,['class'=>'checkboxaddhan'.$h.' form-control','style'=>'float:left;margin-right:7px']);
                                        echo form_label('Thêm','add',['style'=>'margin-top:2px']);                         
                                    }    
                                ?>     
                            </p>               
                            <p>
                                <?php 
                                    echo form_checkbox('checkboxedithan','Sửa',true,['class'=>'checkboxedithan'.$h.' form-control','style'=>'float:left;margin-right:7px']);
                                    echo form_label('Sửa','edit',['style'=>'margin-top:2px']);
                                ?>
                            </p>
                            <p>
                                <?php 
                                    if($h=='tblinformation' || $h=='tblmeta')
                                    { 
                                        echo form_checkbox('checkboxxoahan','Xóa',true,['class'=>'checkboxxoahan'.$h.' form-control','disabled'=>true,'style'=>'float:left;margin-right:7px']);
                                        echo form_label('Xóa','delete',['style'=>'margin-top:2px']);                        
                                    }else{
                                        echo form_checkbox('checkboxxoahan','Xóa',true,['class'=>'checkboxxoahan'.$h.' form-control','style'=>'float:left;margin-right:7px']);
                                        echo form_label('Xóa','delete',['style'=>'margin-top:2px']);                          
                                    }
                                ?>    
                            </p>
                            <?php
                            }
                            elseif($editrolecon=='add')
                            {
                            ?>
                            <p>
                                <?php 
                                    if($h=='tblinformation' || $h=='tblmeta'){
                                        echo form_checkbox('checkboxaddhan','Thêm',true,['class'=>'checkboxaddhan'.$h.' form-control','disabled'=>true,'style'=>'float:left;margin-right:7px']);
                                        echo form_label('Thêm','add',['style'=>'margin-top:2px']);                        
                                    }else{
                                        echo form_checkbox('checkboxaddhan','Thêm',true,['class'=>'checkboxaddhan'.$h.' form-control','style'=>'float:left;margin-right:7px']);
                                        echo form_label('Thêm','add',['style'=>'margin-top:2px']);                         
                                    }    
                                ?>     
                            </p>               
                            <p>
                                <?php 
                                    echo form_checkbox('checkboxedithan','Sửa',false,['class'=>'checkboxedithan'.$h.' form-control','style'=>'float:left;margin-right:7px']);
                                    echo form_label('Sửa','edit',['style'=>'margin-top:2px']);
                                ?>
                            </p>
                            <p>
                                <?php 
                                    if($h=='tblinformation' || $h=='tblmeta')
                                    { 
                                        echo form_checkbox('checkboxxoahan','Xóa',false,['class'=>'checkboxxoahan'.$h.' form-control','disabled'=>true,'style'=>'float:left;margin-right:7px']);
                                        echo form_label('Xóa','delete',['style'=>'margin-top:2px']);                        
                                    }else{
                                        echo form_checkbox('checkboxxoahan','Xóa',false,['class'=>'checkboxxoahan'.$h.' form-control','style'=>'float:left;margin-right:7px']);
                                        echo form_label('Xóa','delete',['style'=>'margin-top:2px']);                          
                                    }
                                ?>    
                            </p>
                            <?php
                            }
                            elseif($editrolecon=='edit')
                            {
                            ?>
                            <p>
                                <?php 
                                    if($h=='tblinformation' || $h=='tblmeta'){
                                        echo form_checkbox('checkboxaddhan','Thêm',false,['class'=>'checkboxaddhan'.$h.' form-control','disabled'=>true,'style'=>'float:left;margin-right:7px']);
                                        echo form_label('Thêm','add',['style'=>'margin-top:2px']);                        
                                    }else{
                                        echo form_checkbox('checkboxaddhan','Thêm',false,['class'=>'checkboxaddhan'.$h.' form-control','style'=>'float:left;margin-right:7px']);
                                        echo form_label('Thêm','add',['style'=>'margin-top:2px']);                         
                                    }    
                                ?>     
                            </p>               
                            <p>
                                <?php 
                                    echo form_checkbox('checkboxedithan','Sửa',true,['class'=>'checkboxedithan'.$h.' form-control','style'=>'float:left;margin-right:7px']);
                                    echo form_label('Sửa','edit',['style'=>'margin-top:2px']);
                                ?>
                            </p>
                            <p>
                                <?php 
                                    if($h=='tblinformation' || $h=='tblmeta')
                                    { 
                                        echo form_checkbox('checkboxxoahan','Xóa',false,['class'=>'checkboxxoahan'.$h.' form-control','disabled'=>true,'style'=>'float:left;margin-right:7px']);
                                        echo form_label('Xóa','delete',['style'=>'margin-top:2px']);                        
                                    }else{
                                        echo form_checkbox('checkboxxoahan','Xóa',false,['class'=>'checkboxxoahan'.$h.' form-control','style'=>'float:left;margin-right:7px']);
                                        echo form_label('Xóa','delete',['style'=>'margin-top:2px']);                          
                                    }
                                ?>    
                            </p>
                            <?php
                            }
                            elseif($editrolecon=='delete')
                            {
                            ?>
                            <p>
                                <?php 
                                    if($h=='tblinformation' || $h=='tblmeta'){
                                        echo form_checkbox('checkboxaddhan','Thêm',false,['class'=>'checkboxaddhan'.$h.' form-control','disabled'=>true,'style'=>'float:left;margin-right:7px']);
                                        echo form_label('Thêm','add',['style'=>'margin-top:2px']);                        
                                    }else{
                                        echo form_checkbox('checkboxaddhan','Thêm',false,['class'=>'checkboxaddhan'.$h.' form-control','style'=>'float:left;margin-right:7px']);
                                        echo form_label('Thêm','add',['style'=>'margin-top:2px']);                         
                                    }    
                                ?>     
                            </p>               
                            <p>
                                <?php 
                                    echo form_checkbox('checkboxedithan','Sửa',false,['class'=>'checkboxedithan'.$h.' form-control','style'=>'float:left;margin-right:7px']);
                                    echo form_label('Sửa','edit',['style'=>'margin-top:2px']);
                                ?>
                            </p>
                            <p>
                                <?php 
                                    if($h=='tblinformation' || $h=='tblmeta')
                                    { 
                                        echo form_checkbox('checkboxxoahan','Xóa',true,['class'=>'checkboxxoahan'.$h.' form-control','disabled'=>true,'style'=>'float:left;margin-right:7px']);
                                        echo form_label('Xóa','delete',['style'=>'margin-top:2px']);                        
                                    }else{
                                        echo form_checkbox('checkboxxoahan','Xóa',true,['class'=>'checkboxxoahan'.$h.' form-control','style'=>'float:left;margin-right:7px']);
                                        echo form_label('Xóa','delete',['style'=>'margin-top:2px']);                          
                                    }
                                ?>    
                            </p>
                            <?php
                            }
                            else
                            {
                            ?>
                            <p>
                                <?php 
                                    if($h=='tblinformation' || $h=='tblmeta'){
                                        echo form_checkbox('checkboxaddhan','Thêm',false,['class'=>'checkboxaddhan'.$h.' form-control','disabled'=>true,'style'=>'float:left;margin-right:7px']);
                                        echo form_label('Thêm','add',['style'=>'margin-top:2px']);                        
                                    }else{
                                        echo form_checkbox('checkboxaddhan','Thêm',false,['class'=>'checkboxaddhan'.$h.' form-control','style'=>'float:left;margin-right:7px']);
                                        echo form_label('Thêm','add',['style'=>'margin-top:2px']);                         
                                    }    
                                ?>     
                            </p>               
                            <p>
                                <?php 
                                    echo form_checkbox('checkboxedithan','Sửa',false,['class'=>'checkboxedithan'.$h.' form-control','style'=>'float:left;margin-right:7px']);
                                    echo form_label('Sửa','edit',['style'=>'margin-top:2px']);
                                ?>
                            </p>
                            <p>
                                <?php 
                                    if($h=='tblinformation' || $h=='tblmeta')
                                    { 
                                        echo form_checkbox('checkboxxoahan','Xóa',false,['class'=>'checkboxxoahan'.$h.' form-control','disabled'=>true,'style'=>'float:left;margin-right:7px']);
                                        echo form_label('Xóa','delete',['style'=>'margin-top:2px']);                        
                                    }else{
                                        echo form_checkbox('checkboxxoahan','Xóa',false,['class'=>'checkboxxoahan'.$h.' form-control','style'=>'float:left;margin-right:7px']);
                                        echo form_label('Xóa','delete',['style'=>'margin-top:2px']);                          
                                    }
                                ?>    
                            </p>  
                            <?php
                            }
                        }
                        else{
                        ?>
                        <p>
                            <?php 
                                if($h=='tblinformation' || $h=='tblmeta'){
                                    echo form_checkbox('checkboxaddhan','Thêm',false,['class'=>'checkboxaddhan'.$h.' form-control','disabled'=>true,'style'=>'float:left;margin-right:7px']);
                                    echo form_label('Thêm','add',['style'=>'margin-top:2px']);                        
                                }else{
                                    echo form_checkbox('checkboxaddhan','Thêm',false,['class'=>'checkboxaddhan'.$h.' form-control','style'=>'float:left;margin-right:7px']);
                                    echo form_label('Thêm','add',['style'=>'margin-top:2px']);                         
                                }    
                            ?>     
                        </p>               
                        <p>
                            <?php 
                                echo form_checkbox('checkboxedithan','Sửa',false,['class'=>'checkboxedithan'.$h.' form-control','style'=>'float:left;margin-right:7px']);
                                echo form_label('Sửa','edit',['style'=>'margin-top:2px']);
                            ?>
                        </p>
                        <p>
                            <?php 
                                if($h=='tblinformation' || $h=='tblmeta')
                                { 
                                    echo form_checkbox('checkboxxoahan','Xóa',false,['class'=>'checkboxxoahan'.$h.' form-control','disabled'=>true,'style'=>'float:left;margin-right:7px']);
                                    echo form_label('Xóa','delete',['style'=>'margin-top:2px']);                        
                                }else{
                                    echo form_checkbox('checkboxxoahan','Xóa',false,['class'=>'checkboxxoahan'.$h.' form-control','style'=>'float:left;margin-right:7px']);
                                    echo form_label('Xóa','delete',['style'=>'margin-top:2px']);                          
                                }
                            ?>    
                        </p>  
                        <?php 
                        }
                    ?>       
                </div>
                <script type="text/javascript">
                    $(document).ready(function(){
                        $(".checkboxaddhan<?php echo $h; ?>").click(function(){
                            if ($(this).is(':checked')) 
                            {
                                if($('.checkboxedithan<?php echo $h; ?>').is(':checked') && $(".checkboxxoahan<?php echo $h; ?>").is(':checked'))
                                {
                                    $(".checkboxaddhan<?php echo $h; ?>").prop("checked", true);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>.add-edit-delete');	
                                }
                                else if($(".checkboxxoahan<?php echo $h; ?>").is(':checked'))
                                {
                                    $(".checkboxaddhan<?php echo $h; ?>").prop("checked", true);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>.add-delete');	
                                }
                                else if ($('.checkboxedithan<?php echo $h; ?>').is(':checked')) 
                                {
                                    $(".checkboxaddhan<?php echo $h; ?>").prop("checked", true);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>.add-edit');
                                }
                                else
                                {
                                    $(".checkboxaddhan<?php echo $h; ?>").prop("checked", true);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>.add');
                                }                        								
                            } 
                            else 
                            {
                                if($('.checkboxedithan<?php echo $h; ?>').is(':checked') && $(".checkboxxoahan<?php echo $h; ?>").is(':checked'))
                                {
                                    $(".checkboxaddhan<?php echo $h; ?>").prop("checked", false);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>.edit-delete');
                                }
                                else if ($('.checkboxedithan<?php echo $h; ?>').is(':checked'))
                                {
                                    $(".checkboxaddhan<?php echo $h; ?>").prop("checked", false);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>.edit');
                                }
                                else if($(".checkboxxoahan<?php echo $h; ?>").is(':checked'))
                                {
                                    $(".checkboxaddhan<?php echo $h; ?>").prop("checked", false);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>.delete');	
                                }
                                else
                                {
                                    $(".checkboxaddhan<?php echo $h; ?>").prop("checked", false);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>');
                                }
                            }
                        });
                        //end check add
                        //Begin check edit
                        $(".checkboxedithan<?php echo $h; ?>").click(function(){
                            if ($(this).is(':checked')) 
                            {
                                if($('.checkboxaddhan<?php echo $h; ?>').is(':checked') && $(".checkboxxoahan<?php echo $h; ?>").is(':checked'))
                                {
                                    $(".checkboxedithan<?php echo $h; ?>").prop("checked", true);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>.add-edit-delete');
                                }
                                else if($(".checkboxxoahan<?php echo $h; ?>").is(':checked'))
                                {
                                    $(".checkboxedithan<?php echo $h; ?>").prop("checked", true);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>.edit-delete');	
                                }
                                else if ($('.checkboxaddhan<?php echo $h; ?>').is(':checked')) 
                                {
                                    $(".checkboxedithan<?php echo $h; ?>").prop("checked", true);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>.add-edit');
                                }
                                else
                                {
                                    $(".checkboxedithan<?php echo $h; ?>").prop("checked", true);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>.edit');
                                }
                            } 
                            else 
                            {
                                if($('.checkboxaddhan<?php echo $h; ?>').is(':checked') && $(".checkboxxoahan<?php echo $h; ?>").is(':checked'))
                                {
                                    $(".checkboxedithan<?php echo $h; ?>").prop("checked", false);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>.add-delete');	
                                }
                                else if ($('.checkboxaddhan<?php echo $h; ?>').is(':checked')) 
                                {
                                    $(".checkboxedithan<?php echo $h; ?>").prop("checked", false);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>.add');
                                }
                                else if ($('.checkboxxoahan<?php echo $h; ?>').is(':checked')) 
                                {
                                    $(".checkboxedithan<?php echo $h; ?>").prop("checked", false);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>.delete');	
                                }
                                else
                                {
                                    $(".checkboxedithan<?php echo $h; ?>").prop("checked", false);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>');
                                }
                            }
                        });
                        //End check edit
                        $(".checkboxxoahan<?php echo $h; ?>").click(function(){
                            if ($(this).is(':checked')) 
                            {
                                if ($('.checkboxaddhan<?php echo $h; ?>').is(':checked') && $('.checkboxedithan<?php echo $h; ?>').is(':checked'))
                                {
                                    $(".checkboxxoahan<?php echo $h; ?>").prop("checked", true);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>.add-edit-delete');
                                }
                                else if($('.checkboxaddhan<?php echo $h; ?>').is(':checked'))
                                {
                                    $(".checkboxxoahan<?php echo $h; ?>").prop("checked", true);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>.add-delete');	
                                }
                                else if($('.checkboxedithan<?php echo $h; ?>').is(':checked'))
                                {
                                    $(".checkboxxoahan<?php echo $h; ?>").prop("checked", true);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>.edit-delete');
                                }
                                else
                                {
                                    $(".checkboxxoahan<?php echo $h; ?>").prop("checked", true);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>.delete');
                                }
                            }
                            else
                            {
                                if ($('.checkboxaddhan<?php echo $h; ?>').is(':checked') && $('.checkboxedithan<?php echo $h; ?>').is(':checked'))
                                {
                                    $(".checkboxxoahan<?php echo $h; ?>").prop("checked", false);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>.add-edit');
                                }
                                else if($('.checkboxaddhan<?php echo $h; ?>').is(':checked'))
                                {
                                    $(".checkboxxoahan<?php echo $h; ?>").prop("checked", false);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>.add');	
                                }
                                else if($('.checkboxedithan<?php echo $h; ?>').is(':checked'))
                                {
                                    $(".checkboxxoahan<?php echo $h; ?>").prop("checked", false);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>.edit');		
                                }
                                else
                                {
                                    $(".checkboxxoahan<?php echo $h; ?>").prop("checked", false);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>');
                                }	
                            }
                        });
                        //End check xoa
                    });
                </script>
            </div>
            <div class="clearfix"></div>
        </div>                                    
        <?php
        }
     }else{
        foreach($table_list as $h=>$v)
        {
        ?>
        <div class="col-lg-3">  
            <div class="panel panel-default">  
                <div class="panel-heading">        
                    <?php echo form_checkbox('chrole[]',$h.'.'.$v,false,['id'=>'capnhat'.$h,'class'=>"chrole form-control",'style'=>'float:left;margin-right:7px']); ?>
                    <?php echo form_label($v,'',['style'=>'margin-top:2px']) ?>
                </div>
                <div class="panel-body">
                    <p>
                        <?php 
                            if($h=='tblinformation' || $h=='tblmeta'){
                                echo form_checkbox('checkboxaddhan','Thêm',false,['class'=>'checkboxaddhan'.$h.' form-control','disabled'=>true,'style'=>'float:left;margin-right:7px']);
                                echo form_label('Thêm','add',['style'=>'margin-top:2px']);                        
                            }else{
                                echo form_checkbox('checkboxaddhan','Thêm',false,['class'=>'checkboxaddhan'.$h.' form-control','style'=>'float:left;margin-right:7px']);
                                echo form_label('Thêm','add',['style'=>'margin-top:2px']);                         
                            }    
                        ?>     
                    </p>               
	                <p>
                        <?php 
                            echo form_checkbox('checkboxedithan','Sửa',false,['class'=>'checkboxedithan'.$h.' form-control','style'=>'float:left;margin-right:7px']);
                            echo form_label('Sửa','edit',['style'=>'margin-top:2px']);
                        ?>
                    </p>
	                <p>
                        <?php 
                            if($h=='tblinformation' || $h=='tblmeta')
                            { 
                                echo form_checkbox('checkboxxoahan','Xóa',false,['class'=>'checkboxxoahan'.$h.' form-control','disabled'=>true,'style'=>'float:left;margin-right:7px']);
                                echo form_label('Xóa','delete',['style'=>'margin-top:2px']);                        
                            }else{
                                echo form_checkbox('checkboxxoahan','Xóa',false,['class'=>'checkboxxoahan'.$h.' form-control','style'=>'float:left;margin-right:7px']);
                                echo form_label('Xóa','delete',['style'=>'margin-top:2px']);                          
                            }
                        ?>    
                    </p>            
                </div>
                <script type="text/javascript">
                    $(document).ready(function(){
                        $(".checkboxaddhan<?php echo $h; ?>").click(function(){
                            if ($(this).is(':checked')) 
                            {
                                if($('.checkboxedithan<?php echo $h; ?>').is(':checked') && $(".checkboxxoahan<?php echo $h; ?>").is(':checked'))
                                {
                                    $(".checkboxaddhan<?php echo $h; ?>").prop("checked", true);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>.add-edit-delete');	
                                }
                                else if($(".checkboxxoahan<?php echo $h; ?>").is(':checked'))
                                {
                                    $(".checkboxaddhan<?php echo $h; ?>").prop("checked", true);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>.add-delete');	
                                }
                                else if ($('.checkboxedithan<?php echo $h; ?>').is(':checked')) 
                                {
                                    $(".checkboxaddhan<?php echo $h; ?>").prop("checked", true);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>.add-edit');
                                }
                                else
                                {
                                    $(".checkboxaddhan<?php echo $h; ?>").prop("checked", true);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>.add');
                                }                        								
                            } 
                            else 
                            {
                                if($('.checkboxedithan<?php echo $h; ?>').is(':checked') && $(".checkboxxoahan<?php echo $h; ?>").is(':checked'))
                                {
                                    $(".checkboxaddhan<?php echo $h; ?>").prop("checked", false);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>.edit-delete');
                                }
                                else if ($('.checkboxedithan<?php echo $h; ?>').is(':checked'))
                                {
                                    $(".checkboxaddhan<?php echo $h; ?>").prop("checked", false);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>.edit');
                                }
                                else if($(".checkboxxoahan<?php echo $h; ?>").is(':checked'))
                                {
                                    $(".checkboxaddhan<?php echo $h; ?>").prop("checked", false);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>.delete');	
                                }
                                else
                                {
                                    $(".checkboxaddhan<?php echo $h; ?>").prop("checked", false);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>');
                                }
                            }
                        });
                        //end check add
                        //Begin check edit
                        $(".checkboxedithan<?php echo $h; ?>").click(function(){
                            if ($(this).is(':checked')) 
                            {
                                if($('.checkboxaddhan<?php echo $h; ?>').is(':checked') && $(".checkboxxoahan<?php echo $h; ?>").is(':checked'))
                                {
                                    $(".checkboxedithan<?php echo $h; ?>").prop("checked", true);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>.add-edit-delete');
                                }
                                else if($(".checkboxxoahan<?php echo $h; ?>").is(':checked'))
                                {
                                    $(".checkboxedithan<?php echo $h; ?>").prop("checked", true);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>.edit-delete');	
                                }
                                else if ($('.checkboxaddhan<?php echo $h; ?>').is(':checked')) 
                                {
                                    $(".checkboxedithan<?php echo $h; ?>").prop("checked", true);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>.add-edit');
                                }
                                else
                                {
                                    $(".checkboxedithan<?php echo $h; ?>").prop("checked", true);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>.edit');
                                }
                            } 
                            else 
                            {
                                if($('.checkboxaddhan<?php echo $h; ?>').is(':checked') && $(".checkboxxoahan<?php echo $h; ?>").is(':checked'))
                                {
                                    $(".checkboxedithan<?php echo $h; ?>").prop("checked", false);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>.add-delete');	
                                }
                                else if ($('.checkboxaddhan<?php echo $h; ?>').is(':checked')) 
                                {
                                    $(".checkboxedithan<?php echo $h; ?>").prop("checked", false);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>.add');
                                }
                                else if ($('.checkboxxoahan<?php echo $h; ?>').is(':checked')) 
                                {
                                    $(".checkboxedithan<?php echo $h; ?>").prop("checked", false);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>.delete');	
                                }
                                else
                                {
                                    $(".checkboxedithan<?php echo $h; ?>").prop("checked", false);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>');
                                }
                            }
                        });
                        //End check edit
                        $(".checkboxxoahan<?php echo $h; ?>").click(function(){
                            if ($(this).is(':checked')) 
                            {
                                if ($('.checkboxaddhan<?php echo $h; ?>').is(':checked') && $('.checkboxedithan<?php echo $h; ?>').is(':checked'))
                                {
                                    $(".checkboxxoahan<?php echo $h; ?>").prop("checked", true);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>.add-edit-delete');
                                }
                                else if($('.checkboxaddhan<?php echo $h; ?>').is(':checked'))
                                {
                                    $(".checkboxxoahan<?php echo $h; ?>").prop("checked", true);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>.add-delete');	
                                }
                                else if($('.checkboxedithan<?php echo $h; ?>').is(':checked'))
                                {
                                    $(".checkboxxoahan<?php echo $h; ?>").prop("checked", true);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>.edit-delete');
                                }
                                else
                                {
                                    $(".checkboxxoahan<?php echo $h; ?>").prop("checked", true);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>.delete');
                                }
                            }
                            else
                            {
                                if ($('.checkboxaddhan<?php echo $h; ?>').is(':checked') && $('.checkboxedithan<?php echo $h; ?>').is(':checked'))
                                {
                                    $(".checkboxxoahan<?php echo $h; ?>").prop("checked", false);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>.add-edit');
                                }
                                else if($('.checkboxaddhan<?php echo $h; ?>').is(':checked'))
                                {
                                    $(".checkboxxoahan<?php echo $h; ?>").prop("checked", false);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>.add');	
                                }
                                else if($('.checkboxedithan<?php echo $h; ?>').is(':checked'))
                                {
                                    $(".checkboxxoahan<?php echo $h; ?>").prop("checked", false);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>.edit');		
                                }
                                else
                                {
                                    $(".checkboxxoahan<?php echo $h; ?>").prop("checked", false);
                                    $("#capnhat<?php echo $h; ?>").val('<?php echo $h.'.'.$v; ?>');
                                }	
                            }
                        });
                        //End check xoa
                    });
                </script>
            </div>
            <div class="clearfix"></div>
        </div>                                    
        <?php
        }
    }
    ?>
    <div style="clear: both;"></div>
    </div>
    <?php
}
elseif($varchar_field=='category' || ($table_name=='tblarticle' && $varchar_field=='title') || $table_name=='tbltheme' && $varchar_field=='title')
{
?>
<div class="<?php echo $col_value_add; ?>">
    <div class="form-group">
        <p><strong><?php echo $varchar_set_label; ?></strong></p>
        <?php 
            if(isset($is_edit)){ 
                echo form_input($varchar_field,$edit_comlunm,['class'=>'form-control','placeholder'=>$varchar_set_label]);
            }
            else{
                echo form_input($varchar_field,set_value($varchar_field),['class'=>'form-control','placeholder'=>$varchar_set_label,'id'=>'ten_tt']);            
            }
        ?>
    </div>
</div>
<?php
}
elseif($varchar_field=='alias'){
?>
<div class="<?php echo $col_value_add; ?>">
    <div class="form-group" style="font-size:11px;">
    <?php
        if(isset($is_edit)){ 
            echo base_url().'<input style="height:20px;width:50%;font-size:11px;" type="text" name="'.$varchar_field.'" value="'.$edit_comlunm.'"/>';
        }
        else{
            echo base_url().'<input style="height:20px;width:50%;font-size:11px;" type="text" name="'.$varchar_field.'" id="alias"/>&nbsp;&nbsp;<span class="khadung" style="color:#0C3;display:none;font-size:11px;">Url khả dụng</span><span class="khongkhadung" style="color:red;display:none;font-size:11px;">Url đã có trên site(Thêm kí tự bất kì để làm url khác đi)</span></p>';
        }
    ?>
    </div>
</div>
<?php
}
elseif($varchar_field=='meta_des'){
    ?>
    <div class="<?php echo $col_value_add; ?>">
        <div class="form-group">
            <p><?php echo form_label($varchar_set_label); ?></p>
            <?php 
                if(isset($is_edit)){ 
                    echo form_textarea($varchar_field,$edit_comlunm,['class'=>'form-control','rows'=>5]);
                }
                else{
                    echo form_textarea($varchar_field,set_value($varchar_field),['class'=>'form-control','rows'=>5]);
                }
            ?>                           
        </div>
    </div>                 
<?php        
}
elseif($varchar_field=='meta_title'){
    ?>
    <div class="<?php echo $col_value_add; ?>">
        <div class="form-group">
            <p><?php echo form_label($varchar_set_label); ?></p>
            <?php 
                if(isset($is_edit)){
                    echo form_textarea($varchar_field,$edit_comlunm,['class'=>'form-control','rows'=>5]);      
                }
                else{
                    echo form_textarea($varchar_field,set_value($varchar_field),['class'=>'form-control','rows'=>5]);      
                }
            ?>        
        </div>        
    </div>	
    <?php    
}
elseif($varchar_field=='thumb'){
    if(isset($is_edit)){ 
        echo form_input($varchar_field,$edit_comlunm,['class'=>'form-control','style'=>'display:none']);
    }
}
elseif($varchar_field=='tag'){
    ?>
    <div class="<?php echo $col_value_add; ?>">
        <div class="form-group">
            <p><?php echo form_label($varchar_set_label); ?></p>
            <?php 
                if(isset($is_edit)){ 
                    echo form_textarea($varchar_field,$edit_comlunm,['class'=>'form-control','rows'=>5]);
                }
                else{
                    echo form_textarea($varchar_field,null,['class'=>'form-control','rows'=>5]);
                }
            ?>                        
        </div>
    </div>
    <?php									
}  								                            
elseif($varchar_field=='mau'){
    ?>
    <div class="<?php echo $col_value_add; ?>">
        <div class="form-group">
            <p><?php echo form_label($varchar_set_label); ?></p>
            <?php 
                if(isset($is_edit)){   
                    echo form_input($varchar_field,$edit_comlunm,['class'=>'form-control','id'=>'colorpickerField1']);  
                }
                else{
                    echo form_input($varchar_field,set_value($varchar_field),['class'=>'form-control','id'=>'colorpickerField1']);  
                }
            ?>            
        </div>
    </div>
    <?php								    
}
else{
    if($table_name=='tbluser'){
        if(isset($is_edit) && $varchar_field=='username'){   
            
        ?>
        <div class="col-lg-12">
        <?php
        }else{
        ?>
        <div class="<?php echo $col_value_add; ?>">
        <?php  
        }    
    }else{
?>
<div class="<?php echo $col_value_add; ?>">
<?php 
    }
?>
    <div class="form-group">
        <p><?php echo form_label($varchar_set_label); ?></p>
        <?php 
            if(isset($is_edit)){    
                echo form_input($varchar_field,$edit_comlunm,['class'=>'form-control']);                
            }
            else{
                echo form_input($varchar_field,set_value($varchar_field),['class'=>'form-control']);  
            }
        ?>
    </div>
</div>
<?php								
}
?>
<script>
function readURL1(input1) {    
    if (input1.files && input1.files[0]) {
        var reader1 = new FileReader();
        reader1.onload = function(event) {
            $('#blah_square').attr('src', event.target.result);
        }
        reader1.readAsDataURL(input1.files[0]);
    }
}
$("#imgInp_blah_square").change(function() {
    readURL1(this);
});
</script>
<?php 
if($table_name == 'tblarticle'){
?>
<script language="javascript">
    $(document).ready(function() {
        var max_length = 255;
        $('#txtCount').val(max_length);
        $('#<?php echo $varchar_field; ?>').keyup(function() {
            if ($(this).val().length > max_length) {
                $(this).val($(this).val().substring(0, max_length));
            }
            $('#txtCount').val(max_length - $(this).val().length);
        });
        $('#<?php echo $varchar_field; ?>').blur(function() {
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