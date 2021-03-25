<section class="content-header">
	<h1>ĐỔi mật khẩu</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('adminhp') ?>"><i class="glyphicon glyphicon-home"></i></a><span class="divider"></span></li>
		<li class="active">Đổi mật khẩu </li>
	</ol>                
</section>
<section class="content">
    <div class="box box-primary borderless">
        <div class="box-header">
				<div class="pull-left">
					<h3 class="box-title"><i class="fa fa-info-circle"></i>Đổi mật khẩu</h3>
				</div>
				<div class="pull-right"></div>
				<div class="clearfix"><!-- --></div>
		</div>       
        <div class="box-body"> 
            <?php
                if(isset($message['error']))
                {
                    ?>
                    <div class="alert alert-danger">
                        <strong>Lỗi!</strong> <?php echo $message['error']; ?>
                    </div>
                    <?php                   
                }
                if(isset($message['success']))
                {
                    ?>
                    <div class="alert alert-success">
                        Đổi mật khẩu thành công!
                    </div>
                    <?php                    
                }
                if(isset($id))
                {
            ?>
            <form method="post" name="frmAddContent" action="<?php echo  site_url().'/adminhp/do_doimatkhau/' ?>" enctype="multipart/form-data">
            <p>
                <strong>Tài khoản</strong>:    
                <label style="font-weight:bold;color:#3883cc;">
                <?php 
                $this->db->where('id',$id);
                $sqltaikhoanadview=$this->db->get('tbladmin');
                echo $sqltaikhoanadview->row()->username; 
                ?></label>
            </p>
            <p>
                <input type="hidden" name="id" value="<?php echo $sqltaikhoanadview->row()->id; ?>" />
                <strong>Mật khẩu mới:</strong>
                <br />
                <input style="width:300px;" type="password" name="matkhaumoi" value="" />
            </p>
            <p>
                <strong>Xác nhận mật khẩu</strong>
                <br />
                <input style="width:300px;" type="password" name="rematkhaumoi" value="" />
            </p>
            <p><input class="myButton" type="submit" value="Nhập" />&nbsp;&nbsp;&nbsp;<input class="myButton" type="reset" value="Xóa" /></p>
            </form>
            <?php 
            }
            ?>
        </div>
    </div>
</section>