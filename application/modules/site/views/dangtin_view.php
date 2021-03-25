content-detail
<div class="content">
    <div class="w980">
        <div class="persion_sidebar">
            <?php $this->load->view('elements/side-bar') ?>            
        </div>
        <div class="persion_right">
            <div class="persion_sidebar_box">
                    <div class="persion_sidebar_box_top"><p><i class="fa fa-info-circle fa-fw"></i>Đăng tin</p></div>
                    <div class="persion_sidebar_box_main" style="padding:10px 15px;">
                        <div class="post_box">                        
                            <img style="border:1px solid #ddd;width:100px;margin-bottom:15px;display:block;" id="blah" src="frontend/images/noimage.png" alt="your image">                                    
                            <label for="imgInp" id="upload_avatar" style="width:80px;">Chọn ảnh</label>
                            <input type="file" name="avatar" style="opacity:0;position:absolute;z-index:-1;" id="imgInp">
                            <input type="hidden" name="hidden_thumb" id="hidden_thumb" value="">
                            <input type="hidden" name="hidden_avatar" id="hidden_avatar" value="">
                            <div class="clearfix"></div>
                        </div>
                        <div class="post_box">
                            <label>Tiêu đề</label>
                            <input type="text" name="post_title" id="post_title" placeholder="Title">
                            <div class="clearfix"></div>
                        </div>
                        <div class="post_box_l">
                            <label>Danh mục cha</label>  
                            <?php 
                                $this->db->where('parent_id',0);
                                $this->db->where('id !=',65);
                                $this->db->where('status',1);
                                $sqldanhmuc_post = $this->db->get('tblarticle_category');
                            ?>                          
                            <select id="post_category">
                                <option value="0">-- Danh mục cha --</option>
                                <?php 
                                    foreach($sqldanhmuc_post->result() as $item_dm_post){
                                    ?>
                                    <option value="<?php echo $item_dm_post->id; ?>"><?php echo $item_dm_post->category; ?></option>
                                    <?php
                                    }
                                ?>
                            </select>
                            <div class="clearfix"></div>
                        </div>
                        <div class="post_box_l" style="margin-right:0px;">
                            <label>Danh mục con</label>                            
                            <select id="post_category_sub">
                                <option value="0">-- Danh mục con --</option>
                            </select>
                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="post_box">
                            <label>Mô tả</label>                            
                            <textarea placeholder="Mô tả" id="post_description"></textarea>
                            <div class="clearfix"></div>
                        </div>
                        <div class="post_box">
                            <label>Nội dung</label>                            
                            <textarea id="post_content" placeholder="Mô tả"></textarea>
                            <div class="clearfix"></div>
                        </div>
                        <div class="post_box">
                            <button type="submit" id="submit_post" onclick="submitFormPost()">Đăng bài</button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>      
<script src="ckeditor/ckeditor.js"></script>
<script>
CKEDITOR.replace('post_content',{
    toolbar: [
        ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
        ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
        ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
        ['Styles','Format','Font','FontSize'],
        ['TextColor','BGColor'],
    ]
});
</script>