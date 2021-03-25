<?php 
$CI=&get_instance();
$CI->load->model('admin/admin_model');
$user_header = $CI->admin_model->getUserByValue('tbladmin','id',$_SESSION['uid']);
$contact_info = $CI->admin_model->getUserByValue('tblcontact','status',NO_ACTIVE);
?>
<header class="main-header">
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown messages-menu">
                        <a class="btn btn-flat no-spin search-modal-btn" href="#search-modal" data-toggle="modal" data-target="#search-modal" title="Search">
                            <span class="fa fa-search"></span>
                        </a>
                    </li>                            
                    <li class="dropdown messages-menu">
                        <a href="javascript:;" class="header-messages dropdown-toggle" data-toggle="dropdown" title="Messages">
                            <i class="fa fa-envelope"></i>
                            <span class="label label-danger">
                                <?php 
                                    if($contact_info->num_rows()>0){
                                        echo $contact_info->num_rows();
                                    }
                                    else{
                                        echo '0';
                                    }
                                ?>
                            </span>
                        </a>
                        <ul class="dropdown-menu">                            
                            <?php 
                                if($contact_info->num_rows()>0){
                                ?>
                                <li class="header"> <!----> </li>
                                <li>
                                    <ul class="menu">
                                        <?php 
                                            foreach($contact_info->result() as $item_contact)
                                            {
                                            ?>
                                            <li><a href="<?php echo site_url('adminhp/viewContent/tblcontact') ?>">Bạn có 1 tin nhắn từ website</a></li>
                                            <?php 
                                            }
                                        ?>
                                    </ul>
                                </li>
                                <?php 
                                }
                            ?>
                            <!--<li class="footer">
                                <a href="">See all messages</a>
                            </li>-->
                        </ul>
                    </li>
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="glyphicon glyphicon-user"></i>
                            <span><?php echo $user_header->row()->name;?> <i class="caret"></i></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-header bg-light-blue">
                            <?php 
                                if($user_header->num_rows()>0){
                                    if($user_header->row()->avatar=='')
                                    {
                                    ?>
                                    <img style="border:1px solid #fff;" src="backend/img/noimage.png" class="img-circle" />
                                    <?php
                                    }
                                    else
                                    {
                                    ?>
                                    <img src="<?php echo $user_header->row()->avatar; ?>" class="img-circle" />
                                    <?php
                                    }
                                }else{	
                                    ?>
                                    <img src="assets/noimage.png" class="img-circle" />
                                    <?php 
                                }
                            ?>
                            <p><?php echo $user_header->row()->name;?></p>
                            </li>
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="<?php echo site_url('thong-tin-ca-nhan.html')?>" class="btn btn-default btn-flat">Thông tin cá nhân</a>
                                </div>
                                <div class="pull-right">
                                    <a href="<?php echo site_url('adminhp/logout')?>" class="btn btn-default btn-flat">Đăng xuất</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

        </nav>
    </header>