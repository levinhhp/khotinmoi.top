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
                <td width="25" class="post_edit"><a href=""><i class="fa fa-pencil-square" aria-hidden="true"></i></a></td>
                <td width="25" class="post_delete"><a href=""><i class="fa fa-trash" aria-hidden="true"></i></a></td>
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