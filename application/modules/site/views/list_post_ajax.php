<table class="table table-bordered" id="postsList">
    <thead class="thead-dark" style="background:#343a40;">
        <tr>   
            <th width="50">STT</th>     
            <th>Tiêu đề</th>               
            <th>Sửa</th> 
            <th>Xóa</th> 
        </tr>
    </thead>
    <tbody>
        <?php 
            $dem = 1;
            foreach($results->result() as $item_post){
            ?>
            <tr>
                <td align="center"><?php echo $dem; ?></td>
                <td><?php echo $item_post->title; ?></td>
                <td></td>
                <td></td>
            </tr>
            <?php 
            $dem++;
            }
        ?>
    </tbody>
</table>
<div id="ajax_links" class="text-center">
    <?php echo $links; ?>
    <div class="clearfix"></div>
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