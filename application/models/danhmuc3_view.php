<div class="s-main">
    <div class="s-main-top">
        <div class="bor_top" style="width:775px;"></div>
        <strong><h3><a href="<?php echo base_url(); ?>">Trang chủ</a> > 
        <?php 
            $this->db->where('id',$danhmuc1->danhmucsanpham2);
            $dmcon2 = $this->db->get('tbldanhmucsanpham2')->row();
        ?>
        <?php 
            $this->db->where('id',$dmcon2->danhmuc);
            $dmcon1 = $this->db->get('tbldanhmucsanpham')->row();
        ?>
        <a href="<?php echo site_url(BoDau($dmcon1->danhmuc).'.html'); ?>"><?php echo $dmcon1->danhmuc; ?></a> >
        <a href="<?php echo site_url(BoDau($dmcon2->danhmucsanpham2.'.html')); ?>">
            <?php                
                echo $dmcon2->danhmucsanpham2;
            ?>
        </a> >        
        <a href="<?php echo site_url(BoDau($danhmuc1->danhmucsanpham3)); ?>"><?php echo $danhmuc1->danhmucsanpham3; ?></a></h3></strong>
    </div>
    <div class="s-main-main">
        <div id="sanpham_al">
        <?php 
            if($query->num_rows() > 0)
            {
                $dem = 1;
            ?>
            <table>
                <tr>
                    <th>STT</th>
                    <th>Tên</th>
                    <th>Giá</th>
                    <th>Chiều dài</th>
                    <th>Kích thước</th> 
                    <th>Số lượng</th>  
                    <th>Giỏ hàng</th>                 
                </tr>
                <?php
                foreach($query->result() as $query)
                {
                ?>  
                    <tr>
                        <td><?php echo $dem; ?></td>
                        <td><a href="<?php echo site_url('sanpham/sanphambyid/'.$query->id.'/'.url_title($query->ten)); ?>"><?php echo $query->ten; ?></a></td>
                        <td><?php echo number_format($query->gia,0,'.','.'); ?>&nbsp;<?php echo $query->dvt; ?></td>
                        <td><?php echo $query->chieuday; ?></td>
                        <td><?php echo $query->kichthuoc; ?></td>
                        <td><input type="text" name="soluong" value="0" id="soluong<?php echo $query->id; ?>" /></td>
                        <td><a class="themvaogio" id="order<?php echo $query->id; ?>" style="cursor:pointer;">Thêm vào giỏ hàng</a></td>
                        <script type="text/javascript">
                            jQuery(document).ready(function(){
                                jQuery("#order<?php echo $query->id; ?>").click(function(){
                                    if($('#soluong<?php echo $query->id; ?>').val()=='0' || $('#soluong<?php echo $query->id; ?>').val()=='')
                                    {
                                        alert('Bạn chưa nhập số lượng');
                                        $('#soluong<?php echo $query->id; ?>').focus();
                                        return false;
                                    }
                                    var sl = $('#soluong<?php echo $query->id; ?>').val();
                                    var filter = /^([0-9])+$/;
                                    if(!filter.test(sl))
                                    {
                                        alert('Số lượng chỉ nhập kiểu số');
                                        $('#soluong<?php echo $query->id; ?>').focus();
                                        return false;    
                                   }
                                   else
                                   {                                    
                                        var soluong = $('#soluong<?php echo $query->id; ?>').val();
                                        var id =<?php echo $query->id; ?>;
                                        jQuery.ajax({
                                            cache: false,
                                            type: "POST",
                                            data:{soluong:soluong,id:id},
                                           	url:"<?php echo site_url('sanpham/addsoluong/');?>",
                                            success:function(html){
                                                alert("Thêm vào giỏ hàng thành công");
                                                jQuery('.num').html(html);
                                                $('#soluong<?php echo $query->id; ?>').val('0');
                                            }    
                                        });                                        
                                   }                                      
                                });    
                            });
                        </script>
                    </tr>
                <?php 
                }
                $dem++;
                ?>
            </table>
            <?php                   
            }
            else
            {
            ?>
                <p style="padding:15px;">Dữ liệu đang cập nhật</p>
            <?php   
            }
        ?>
        </div>
        <br />
    </div>
    <div class="s-main-foo">    
    </div>
</div>