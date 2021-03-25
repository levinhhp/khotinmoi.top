<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$CI=&get_instance();
$CI->load->model('admin/admin_model');
?>
<div class="<?php echo $col_value_add; ?>">
    <div class="form-group">
        <p><?php echo form_label($upload_set_label); ?></p>
        <?php
        if(isset($is_edit)){
            if(!empty($edit_comlunm))
            {
            ?>          
            <img style='border:1px solid #ddd;width:150px;margin-bottom:15px;display:block;' id="blah<?php echo $upload_field; ?>" src="<?php echo $edit_comlunm; ?>" alt="your image" />  
            <?php 
            }
            else{
            ?>
            <img style='border:1px solid #ddd;width:150px;margin-bottom:15px;display:block;' id="blah<?php echo $upload_field; ?>" src="backend/img/noimage.png" alt="your image" />  
            <?php    
            }
                $upload_hidden_val="hid".$upload_field;
                echo form_hidden($upload_hidden_val,$edit_comlunm);
                echo form_label('Chọn ảnh', 'imgInp'.$upload_field,['id'=>'upload_avatar']);
                echo form_upload($upload_field,'',['class'=>'fileUpload form-control','style'=>'opacity:0;position:absolute;z-index:-1;','id'=>'imgInp'.$upload_field]);
            ?>
            <?php						
        }
        else{
            ?>
            <img style='border:1px solid #ddd;width:150px;margin-bottom:15px;display:block;' id="blah<?php echo $upload_field; ?>" src="backend/img/noimage.png" alt="your image" />
            <?php
            echo form_label('Chọn ảnh', 'imgInp'.$upload_field,['id'=>'upload_avatar']);
            echo form_upload($upload_field,'',['class'=>'fileUpload form-control','style'=>'opacity:0;position:absolute;z-index:-1;','id'=>'imgInp'.$upload_field]);
        }
        ?>
    </div>
    <?php 
        if($table_name=='tblsanpham')
        {
        ?>        
        <div class="row">
            <div class="col-lg-12">  
                <div class="form-group">                    
                    <p><?php echo form_label('Hình ảnh sản phẩm'); ?></p>                    
                    <?php echo form_label('Chèn ảnh', 'image_file',['id'=>'upload_mt']); ?>                                      
                    <?php echo form_upload('files[]','',['id'=>'image_file','multiple'=>'multiple']) ?>
                    <br>
                    <div id="uploadPreview">
                        <?php                         
                            if(isset($is_edit))
                            {
                                $list_images = $CI->admin_model->getTableAllByValue('tblimages','post_id',$primaryKey,'id','desc'); 
                                foreach($list_images->result() as $item_image)
                                {
                                ?>
                                <div class="col-lg-3 text-center">
                                    <div class="form-group">
                                        <img src="<?php echo $item_image->name; ?>" class="thumb">
                                        <br>                                        
                                        <a style="cursor:pointer" onclick="delete_image(<?php echo $item_image->id; ?>)" id="delete_image" type="button" class="btn btn-danger">Xóa ảnh</a>                                        
                                    </div>
                                </div>
                                <?php    
                                }
                            }
                        ?>
                        <div class="clearfix"></div>
                    </div>                    
                </div>
            </div>
        </div>
        <?php
        }
    ?>
</div>
<script type="text/javascript">
<?php 
        if($table_name=='tblsanpham')
        {
?>
function delete_image(id)
{
    jQuery.ajax({
        cache: false,
        type:"POST",
        url:"<?php echo site_url('adminhp/deleteImage/');?>"+id,
        success:function(html){                        
            window.location.reload();
        }
    });
} 
 $(document).ready(function(){  
    function readImage(file) {
        var reader = new FileReader();
        var image  = new Image();
        reader.readAsDataURL(file);  
        reader.onload = function(_file) {
            image.src = _file.target.result; // url.createObjectURL(file);
            image.onload = function() {
                var w = this.width,
                h = this.height,
                t = file.type, // ext only: // file.type.split('/')[1],
                n = file.name,
                s = ~~(file.size/1024) +'KB';
                $('#uploadPreview').prepend('<div class="col-lg-3 text-center"><div class="form-group"><img src="' + this.src + '" class="thumb"><br><a style="cursor:pointer" type="button" class="btn btn-danger remove">Xóa ảnh</a></div></div>');
                $(".remove").click(function(){                    
                    $(this).parent().parent().remove();                    
                });
            };
            image.onerror= function() {
                alert('Invalid file type: '+ file.type);
            };      
        };
    }
    $("#image_file").change(function (e) {
        if(this.disabled) {
            return alert('File upload not supported!');
        }
        var F = this.files;
        if (F && F[0]) {
            for (var i = 0; i < F.length; i++) {
                readImage(F[i]);
            }
        }
    });
});
<?php 
}
?>
function readURL(input) {
if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
    $('#blah<?php echo $upload_field; ?>').attr('src', e.target.result);
    }
    
    reader.readAsDataURL(input.files[0]);
}
}
$("#imgInp<?php echo $upload_field; ?>").change(function() {
readURL(this);
});
</script>