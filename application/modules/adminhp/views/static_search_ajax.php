<table class="table table-bordered" id="postsList">
    <thead class="thead-dark" style="background:#343a40;">
        <tr>       
        <th>Id</th>
		<th>Ngày đăng</th>
        <th>Lượt xem(
            <?php
                 $sql_1_s = "select SUM(view) as totalViews from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$_SESSION['start_date']."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$_SESSION['end_date']."' ";
                $sql_view_s = $this->db->query($sql_1_s);    
                echo $sql_view_s->row()->totalViews;
            ?>
        )</th>
        <th>Category</th>
        <th>Tiêu đề</th>
        <th>Người đăng</th>        
        </tr>
    </thead>
    <tbody>
        <?php 
            $dem = 1;
            foreach($results->result() as $item){
            ?>
            <tr>     
                <td align="center"><?php echo $item->article_id; ?></td> 
				<td align="center"><?php echo date('d-m-Y',strtotime($item->date_day)); ?></td>
                <td align="center"><?php echo $item->view; ?></td>                          
                <td>
                    <?php 
                    $this->db->where('id',$item->category_id);
                    $sqlcategory = $this->db->get('tblarticle_category');
                    if($sqlcategory->num_rows()>0){
                        echo $sqlcategory->row()->category;
                    }
                    ?>
                </td>
                <?php 
                    $this->db->where('id',$item->article_id);
                    $sqltin = $this->db->get('tblarticle');
                    if($sqltin->num_rows()>0){
                    ?>
                    <td><?php echo $sqltin->row()->title; ?></td>                    
                    <td><?php echo $sqltin->row()->author; ?></td> 
                    <?php
                    }else{
                    ?>
                    <td></td>
                    
                    <?php 
                    }
                ?>                
            </tr>
            <?php
                $dem++;     
            }
        ?>
    </tbody>
</table>
<div id="ajax_links" class="text-center">
    <?php echo $links; ?>
</div>
<script>
$(function() {
    paginate();
        function paginate() {
            $('#ajax_links a').click(function() {                           
              var url = $(this).attr('href');
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: 'ajax=true',
                    success: function(data) {
                        $('#ajax_content').html(data);
                    }
                });
                return false;
            });
        }
    });
</script>