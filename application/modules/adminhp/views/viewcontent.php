<?php
if(isset($_SESSION['uid']))
{
    $this->db->where('username',$_SESSION['uid']);
}        
$tachviewra=$this->db->get('tblrole');
foreach ($tachviewra->result() as $tachviewra) 
{
    if($tachviewra->table_name==$table_name)
    {
        $tachadd=explode('-',$tachviewra->access);               
        foreach ($tachadd as $tachadd) 
        {
            //echo $tachadd;
            if($tachadd=='delete')
            {
                $okdel=1;                    
            }
            elseif($tachadd=='add')
            {
                $okadd=1;                    
            }
            elseif($tachadd=='edit')
            {
                $oke=1;                        
            }
        }

    }    
}
?>      
<section class="content-header">
	<h1><?php echo element($table_name,$table_list); ?></h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('adminhp') ?>"><i class="glyphicon glyphicon-home"></i></a><span class="divider"></span></li>
		<li><?php echo element($table_name,$table_list); ?> </li>
        <li class="active">Danh sách</li>
    </ol>                
</section>
<section class="content">
<div class="box box-primary borderless">
	<div class="box-header">
			<div class="pull-left">
				<h3 class="box-title"><i class="fa fa-info-circle"></i><?php echo element($table_name,$table_list); ?></h3>
			</div>
			<div class="pull-right"></div>
			<div class="clearfix"><!-- --></div>
	</div>
	<div class="box-body">
<?php
    if(isset($message['error']))
    {
        echo '<div class="message error close">
        <h2>Lỗi!</h2>
        <p>'.$message['eror'].'</p>
        </div>';	
    }
    if(isset($message['success']))
    {
        echo '<div class="message success close">
        <h2>Nhập dữ liệu thành công!</h2>
        <p>'.$message['success'].'</b></p>
        </div>';
    }
    if(isset($message['warning']))
    {
        echo '<div class="message warning close">
        <h2>Chú ý!</h2>
        <p>'.$message['warning'].'</p>
        </div>';	
    }
    $viewTable=element($table_name,$labels);
    $fieldName=array();
    $counter=0;
    do
    {
        $fieldName[$counter]=key($viewTable);	
        $counter++;
    }while(next($viewTable));
    ?>
    <script type="text/javascript">
    $(document).ready(function(){
        $('#frm_viewcontent').submit(function(){
            if(!$('#request-form input[type="checkbox"]').is(':checked')){
				alert("Bạn chọn ít nhất 1 bản ghi.");
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
		}
		else
		{
			for(i=0;i<items.length;i++)
				items[i].checked=false;						
		}
	}	
</script>	          
<form method="post" name="frmAddContent" action="<?php echo site_url().'adminhp/dosearchcontent/'.$table_name; ?>" enctype="multipart/form-data">
	<div class="row">
		<div class="col-lg-4">
			<input class="form-control" placeholder="Nhập từ cần tìm kiếm:" type="text" name="search" /><span>
		</div>
		<div class="col-lg-2 text-right" style="margin-top:8px;">
			<span>Tìm kiếm theo:</span>
			<a href="<?php echo site_url().'/adminhp/search_status/'.$table_name; ?>" class="tooltip" title="Xem các bản ghi chưa được hiển thị">**Các bản ghi chưa được hiển thị</a></span>	<br />				
		</div>
		<div class="col-lg-3">
			<select name="compare" class="form-control">
			<?php
				foreach ($viewTable as $key => $value)
				// Get fields and lables of table;
				{
			?>
			<option value="<?php echo $key;?>"><?php  echo $value; ?></option>
			<?php
				}
			?>
			</select>
		</div>
		<div class="col-lg-3" style="float:right;">
			<p><input class="btn btn-primary" type="submit" value="Tìm kiếm" />
			<input class="btn btn-danger" type="reset" value="Nhập lại" /></p>
		</div>
	</div>
	<div class="row">
		
	<div>
</form>
<form name="frm_viewcontent" id="frm_viewcontent" method="post" action="<?php echo site_url('adminhp/deleteallcontent/'.$table_name); ?>">
<?php 
    if($table_name=='tblmeta' || $table_name=='tblinformation')
    {
        
    }   
    else
    { 
?>
<div class="col-lg-12">
	<div class="register-complete" style="margin-bottom:12px;">        
        <?php 
             if($okdel==1)
             {
        ?>
		<input name="delete" type="submit" class="btn btn-danger" id="delete" value="Xóa tất cả"/>
        <?php 
             }
			if($table_name=='tblcontact')
			{}
			else
			{
                if($okadd==1)
                {
		        ?>
		        <a title="Thêm mới" class="btn btn-primary" href="<?php echo site_url('adminhp/addContent/'.$table_name); ?>"><i class="glyphicon glyphicon-plus"></i> Thêm mới</a>
                <?php 
                }
            }  
            if($table_name == 'tblarticle')  {
                if(isset($_SESSION['username'])){
                    if($_SESSION['username']!='admin'){
                        $this->db->where('author',$_SESSION['username']);
                        $sql_1 = "select * from `tblarticle` where `author`='".$_SESSION['username']."' and DATE_FORMAT(date_day,'%Y-%m-%d')= '".date('Y-m-d')."' "; 
                    }else{
                        $sql_1 = "select * from `tblarticle` where DATE_FORMAT(date_day,'%Y-%m-%d')= '".date('Y-m-d')."' ";    
                    }
                }                                 
                $totalToday = $this->db->query($sql_1);
                if($totalToday->num_rows()>0){
                    $count_Today = $totalToday->num_rows();
                }else{
                    $count_Today = 0;
                }
                if(isset($_SESSION['username'])){
                    if($_SESSION['username']!='admin'){
                        $this->db->where('author',$_SESSION['username']);
                    }
                }
                $this->db->where('status',1);
                $totalCheck = $this->db->get($table_name);
                if($totalCheck->num_rows()>0){
                    $countCheck = $totalCheck->num_rows();
                }else{
                    $countCheck = 0;
                }
                if(isset($_SESSION['username'])){
                    if($_SESSION['username']!='admin'){
                        $this->db->where('author',$_SESSION['username']);
                    }
                }
                $this->db->where('status',0);
                $totalUnCheck = $this->db->get($table_name);
                if($totalUnCheck->num_rows()>0){
                    $countUnCheck = $totalUnCheck->num_rows();
                }else{
                    $countUnCheck = 0;
                }
            ?>
            <a title="Tất cả tin" class="btn btn-warning" href="<?php echo site_url('adminhp/viewContent/'.$table_name); ?>"><i class="fa fa-sun-o" aria-hidden="true"></i> Tất cả tin</a>
            <a title="Hôm nay" class="btn btn-info" href="<?php echo site_url('adminhp/newToday/'.$table_name); ?>"><i class="fa fa-sun-o" aria-hidden="true"></i> Hôm nay (<?php echo $count_Today; ?>)</a>
            <a title="Đã duyệt" class="btn btn-success" href="<?php echo site_url('adminhp/viewCheck/'.$table_name.'/1'); ?>"><i class="fa fa-check-square" aria-hidden="true"></i> Đã duyệt (<?php echo $countCheck; ?>)</a>
            <a title="Chưa duyệt" class="btn btn-danger" href="<?php echo site_url('adminhp/viewCheck/'.$table_name.'/0'); ?>"><i class="fa fa-minus-circle" aria-hidden="true"></i> Chưa duyệt (<?php echo $countUnCheck; ?>)</a>
            <?php
            }
		?>    
		<div style="clear: both;"></div>
	</div>
</div>
<?php 
}
?>
<div class="col-lg-12" style="overflow-x:scroll;width:98.5%;">
<table class="table table-bordered">
<thead class="thead-dark" style="background:#343a40;">
    <tr>
    <?php 
        if($table_name=='tblmeta' || $table_name=='tblinformation')
        {
            
        }       
        else
        {
            if($okdel==1)
            {
            ?>
            <th><input type="checkbox" onclick="checkall('checkbox', this)" name="check" /></th>
            <?php 
            }
        }
    ?>
    <?php  
    //paging
    $CI=&get_instance();
    $CI->load->library('pagination');
    $config['base_url'] = site_url('adminhp/viewContent/'.$table_name);
    $config['uri_segment']=4;
    $config['total_rows'] = $rowCounter;
    $config['per_page'] = $rowLimit;
    $start= $config['per_page']+1;
    $end = ($this->uri->segment(4) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(4) * $config['per_page'] + $config['per_page'];
    $CI->pagination->initialize($config);
    if($oke==1)
    {
    ?>
    <th>Sửa</th>
    <?php    
    }
    if($table_name=='tblinformation')
    {
    }
    elseif($table_name=='tblmeta')
    {
    }
    elseif($table_name=='tblslidebar')
    {
    
    }    
    else
    {
        if($okdel==1)
        {
        ?>
        <th>Xóa</th>
        <?php    
        }    
    }
    if($table_name=='tbladmin')
    {
    ?>
    <th>Reset pass</th>
    <?php        
    }elseif($table_name == 'tblarticle'){
    ?>
    <th>Share FB</th>
    <?php
    }elseif($table_name == 'tblscan_post'){
    ?>
    <th>Quét tin</th>
    <?php
    }
    foreach($viewTable as $item) 
    {        
    ?>
    <th <?php if($item=='Tiêu đề'){?>style="width:200px;"<?php } ?>><?php echo $item;?></th>
    <?php        
    }
?>
</tr>
</thead>
<?php
    $text_field_position=array();
    $count_on_txt_field_pos=0;
    $demtung=1;
    foreach($contents as $content)
    {
		$id = $fieldName[0];
        if($demtung%2==0)
        {
            echo '<tr style="font-size:12px;background:#fff;">';
        }
        else
        {
            echo '<tr style="font-size:12px;background:#eee;">';
        }       
        if($table_name=='tblmeta' || $table_name=='tblinformation')
        {
            
        }
        else
        {
            if($okdel==1)
            {
                if($content->$id==ID_ADMIN && $table_name=='tbladmin')
                {
                    echo '<td id="request-form"></td>';
                }
                else{
                    echo '<td id="request-form"><input name="checkbox[]" type="checkbox" id="checkbox" class="checkbox" value="'.$content->$id.'"></td>';
                }
            }
        } 
        if($oke==1)
        {
            echo '<td align="center"><a title="Sửa" class="edit_view btn btn-primary" href="'.site_url().'adminhp/editContent/'.$table_name.'/'.$content->$id.'"><i class="glyphicon glyphicon-pencil"></i></a></td>';       
        }
        if($table_name=='tblinformation' || $table_name=='tblmeta' || $table_name=='tblslidebar')
        {
            
        }
        else
        {
            if($okdel==1)
            {	
                if($content->$id==ID_ADMIN && $table_name=='tbladmin')
                {
                ?>
                <td></td>		
                <?php
                }
                else{
                ?>
                <td><a title="Xóa" class="xoa_view btn btn-danger" onClick="return confirm('Bạn có muốn xóa thật không ?');" href="<?php echo site_url().'/adminhp/deleteContent/'.$table_name.'/'.$content->$id?>"><i class="glyphicon glyphicon-trash"></i></a></td>
                <?php
                }
            }
        }
        if($table_name=='tbladmin')
        {
            echo '<td align="center"><a title="Đổi mật khẩu" href="'.site_url().'adminhp/doimatkhau/'.$content->$id.'"><img src="backend/img/icon-48-user.png" title="Đổi mật khẩu" alt="Đổi mật khẩu"></a></td>';    
        }elseif($table_name == 'tblarticle'){
            $this->db->where('id',$content->$id);
            $sql_share = $this->db->get($table_name);
            if($sql_share->num_rows()>0){
                $link_share = site_url(url_tt($sql_share->row()->id));
                $title_share = $sql_share->row()->title;
                $thumb_share = $sql_share->row()->thumb;
                $description_share = $sql_share->row()->description;
            }else{
                $title_share = '';
                $thumb_share = '';
                $description_share = '';
                $link_share = '';
            }
        ?>
        <td><a href="javascript:fbShare('<?php echo $link_share; ?>', '<?php echo $title_share; ?>', '<?php echo $description_share; ?>', '<?php echo $thumb_share; ?>', 600, 350)" class="btn btn-info share_fb_id" data-link="<?php echo $link_share; ?>" data-description="<?php echo $description_share; ?>" data-thumb="<?php echo base_url().$thumb_share; ?>" data-title="<?php echo $title_share; ?>"><i class="fa fa-facebook-f"></i></a></td>
        <?php
        }elseif($table_name == 'tblscan_post'){
        ?>
        <td align="center">
            <?php 
                $this->db->where('id',$content->$id);
                $sql_quet = $this->db->get($table_name)->row();
                if($sql_quet->status == 1){
            ?>
            <a class="btn btn-warning" href="<?php echo site_url('adminhp/ScanPostContent/'.$table_name.'/'.$content->$id); ?>"><i class="glyphicon glyphicon-search"></i></a>
            <?php 
                }
            ?>
        </td>
        <?php
        }        
        for($k=0;$k<$counter;$k++)
        {
            $temp=element($fieldName[$k],$column_type);
                echo '<td>';
                if($temp[0]=='upload')
                {
					$check_default_upload=$fieldName[$k];
                    if($temp[1]=='image')
                    {
                        if(!empty($content->$check_default_upload))
                        {
                            echo '<a target="_new" href="'.base_url().$content->$check_default_upload.'"><img src="'.base_url().$content->$check_default_upload.'" width="100" ></a>';
                        }
                    }
                    elseif($temp['1']=='file')
                    {
                        echo '<a target="_new" href="'.base_url().$content->$check_default_upload.'">'.base_url().$content->$check_default_upload.'</a>';
                    }
                }
                elseif($temp[0]=='format')
                {
                    $check_default_format=$fieldName[$k];	
                    if($temp[1]=='price'){
                        echo number_format($content->$check_default_format,0,',',',');
                    }elseif($temp[1]=='postNumber'){
                        echo $content->$check_default_format;   
                    }elseif($temp[1]=='postFilter'){                        
                        if($content->$check_default_format==1){
                            echo 'Bài viết';
                        }elseif($content->$check_default_format == 2){
                            echo 'Categopry';
                        }                        
                    }
                }
                elseif($temp[0]=='dropdown')
                {
                    $i=0;                       
                    foreach($temp[1] as $item)
                    {                                             
                        $key=key($item);                        
						$check_default_dropdown=$fieldName[$k];	
                        if(element($key,(array)$item)==$content->$check_default_dropdown)
                        {
                            echo $item->$check_default_dropdown;
                            break;  
                        }
                    }
                }           
                elseif($temp[0]=='radio')
                {
					$check_default_radio=$fieldName[$k];		
                    echo $temp[1][$content->$check_default_radio];
                }else
                {				
                    $getPrimaryKey=$content->$id;						
                    foreach($fields as $field)
                    {
						$check_default=$fieldName[$k];				
                        if($field->Field==$fieldName[$k])
                        {
                            if($field->Type=='text')
                            {     
                                ?>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal<?php echo $table_name.'-'.$getPrimaryKey.'-'.$field->Field; ?>">
                                    Chi tiết
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal<?php echo $table_name.'-'.$getPrimaryKey.'-'.$field->Field; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                            <h5 class="modal-title" id="exampleModalLabel">Xem chi tiết</h5>        
                                        </div>
                                        <div class="modal-body">
                                            <?php echo $content->$check_default; ?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>        
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <?php                                                                                                                                      
                                break;
                            }
                            elseif($field->Type=='tinytext')
                            {     
                                ?>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal<?php echo $table_name.'-'.$getPrimaryKey.'-'.$field->Field; ?>">
                                    Chi tiết
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal<?php echo $table_name.'-'.$getPrimaryKey.'-'.$field->Field; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                            <h5 class="modal-title" id="exampleModalLabel">Xem chi tiết</h5>        
                                        </div>
                                        <div class="modal-body">
                                            <?php echo $content->$check_default; ?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>        
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <?php                                                                                                                                      
                                break;
                            }                                                   
                            if($field->Field=='ordernum')
                            {                            
                            ?>
                            <p style="float:left;"><input id="ordernum<?php echo $content->$id; ?>" type="text" value="<?php echo $content->$check_default; ?>" style="width:20px;text-align:center;">&nbsp;<span id="save_icon" class="buttom_sv" style="cursor:pointer;"><img src="backend/img/save.png"/></span></p>
                            <input type="hidden" name="table_nameor" id="table_nameor" value="<?php echo $table_name; ?>" />
                            <script type="text/javascript">
                                jQuery(document).ready(function(){
                                    jQuery(".buttom_sv").click(function(){                                        
                                        var ordernum=jQuery("#ordernum<?php echo $content->$id; ?>").val();                                        
                                        var table_nameor=jQuery("#table_nameor").val();
                                        var filter = /^([0-9])+$/;
                                        if(!filter.test(ordernum))
                                        {
                                            alert("Thứ tự chỉ nhập kiểu số");
                                            jQuery("#ordernum<?php echo $content->$id; ?>").focus();
                                            return false;    
                                        }
                                        else
                                        {
                                            jQuery.ajax({
                                                type:"POST",
                                                data: {ordernum : ordernum,table_nameor : table_nameor},    
                                                url: "<?php echo site_url('adminhp/sapxep/'.$content->$id); ?>",
                                                success: function(html){
                                                    window.location.href="<?php echo site_url('adminhp/viewContent/'.$table_name); ?>";    
                                                }                        
                                            }); 
                                        }  
                                        return false; 
                                    });        
                                });
                            </script>
                            <?php                                                                       
                            }                                              
                            elseif($field->Type=='datetime')
                            {                                
                                echo date('d-m-Y H:i:s',strtotime($content->$check_default));
                            }                        
                            else
                            {   
                                if($field->Field=='title'){                                    
                                    ?>
                                    <p style="cursor:pointer" data-toggle="tooltip" title="<?php echo htmlspecialchars($content->$check_default); ?>"><?php echo catchuoi($content->$check_default,50); ?></p>
                                    <?php
                                }else{
                                    echo $content->$check_default;
                                }
                            }
    				}
            }
        }
        echo '</td>';
}
?>
</tr>
<?php	
    $demtung++;	 
    }    
?>
</table>
</div>
</form>
<div class="col-lg-6 text-right">
    <br>
    <div class="pagingNumber">
    <?php
        $pagination = $CI->pagination->create_links();
        $lks=$pagination;
        $lks='<ul class="pagination">'.$pagination; 
        $datar1=array('<strong>','<a hr');    
        $datar2=array('<li class="active"><a>','<li><a rel="nofollow" hr');
        $datar3=array('</strong>','</a>');    
        $datar4=array('</a></li>','</a><li>');         
        $lks=str_replace($datar1,$datar2,$lks);
        $lks=str_replace($datar3,$datar4,$lks);        
        $lks.='</ul>';
        echo $lks;					
    ?>
    </div>
</div>
        </div>
    </div>
</section>
<script>
    function fbShare(url, title, descr, image, winWidth, winHeight) {
        var winTop = (screen.height / 3) - (winHeight / 3);
        var winLeft = (screen.width / 2) - (winWidth / 2);
        window.open('http://www.facebook.com/sharer.php?s=100&p[title]=' + title + '&p[summary]=' + descr + '&p[url]=' + url + '&p[images][0]=' + image, 'sharer', 'top=' + winTop + ',left=' + winLeft + ',toolbar=0,status=0,width=' + winWidth + ',height=' + winHeight);
    }
</script>
<script type="text/javascript">
    function check_status(id)
    {
        $.ajax({
		      cache:false,
              type:"POST",  
              url:"<?php echo site_url('adminhp/statushp/'); ?>", 
              data:{id : id},
			  success:function(html){				
				window.location.href ="<?php echo site_url('adminhp/viewContent/'.$table_name); ?>";
			}                                                          
	   });  
    }
</script>