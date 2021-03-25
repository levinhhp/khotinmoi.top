<?php 
function design_by($tencongty,$masothue,$diachi,$email,$dienthoai,$link,$linkbct)
{    
    ?>
    <p>Bản quyền thuộc&nbsp;<?php echo $tencongty; ?> - MST&nbsp;<?php echo $masothue; ?></p>
    <p>Add:&nbsp;<?php echo $diachi; ?></p>
    <div id="ft_left">
        <p>Email:&nbsp;<a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a> - Tel:&nbsp;<?php echo $dienthoai; ?></p>        
    </div>
    <div id="boct">
        <?php 
            if($linkbct!='')
            {
            ?>
            <a href="<?php echo $linkbct; ?>" target="_blank" title="Đăng ký bộ công thương"><img src="images/bo_ct.png" title="Đăng ký bộ công thương" alt="Đăng ký bộ công thương" /></a>
            <?php 
            }
        ?>
    </div>
<?php
}
?>