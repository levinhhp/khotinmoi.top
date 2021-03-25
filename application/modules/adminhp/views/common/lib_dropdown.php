<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$CI=&get_instance();
if($dropdown_field=='parent_id')
{
?>
<div class="<?php echo $col_value_add; ?>">
    <div class="form-group">
        <p><strong><?php echo $dropdown_set_label; ?></strong></p>
        <?php 
            if(isset($is_edit)){               
                $cha_tl=$CI->admin_model->selectCtrl_tl_e($table_name,$edit_comlunm,'parent_id','dmcha_tl form-control',$dropdown_field);
				echo $cha_tl;
            }else{
                $cha=$CI->admin_model->selectCtrl($table_name,$dropdown_field,'dmcha',$dropdown_field);
                echo $cha;	
            }
        ?>									
    </div>
</div>
<?php
}
elseif($dropdown_field=='category' && $table_name=='tblads'){
?>
<div class="<?php echo $col_value_add; ?>">
    <div class="form-group">
        <p><strong><?php echo $dropdown_set_label; ?></strong></p>
        <?php 
            if(isset($is_edit)){               
                $cha_tl=$CI->admin_model->selectCtrl_tl_e('tblarticle_category',$edit_comlunm,$dropdown_field,'dmcha_tl form-control','cmbdanhmuc1');
				echo $cha_tl;
            }else{
                $cha=$CI->admin_model->selectCtrl('tblarticle_category',$dropdown_field,'dmcha','cmbdanhmuc1');
                echo $cha;	
            }
        ?>	
        <script language="javascript">
            $(document).ready(function() {
                $('#cmbdanhmuc1').change(function() {
                    giatri = this.value;
                    $('#cmbdanhmuccon').load('<?php echo site_url().'/adminhp/loadcate2/'; ?>' + giatri);                    
                });
            });
        </script>									
    </div>
</div>
<?php
}
elseif($dropdown_field=='category_sub' && $table_name=='tblads'){
?>
<div class="<?php echo $col_value_add; ?>">
    <div class="form-group">
        <p><strong><?php echo $dropdown_set_label; ?></strong></p>
        <?php 
            if(isset($is_edit)){               
                $cha_tl=$CI->admin_model->selectCtrl_tl_e('tblarticle_category',$edit_comlunm,$dropdown_field,'dmcha_tl form-control','cmbdanhmuccon');
				echo $cha_tl;
            }else{
                $cha=$CI->admin_model->selectCtrl('tblarticle_category',$dropdown_field,'dmcha','cmbdanhmuccon');
                echo $cha;	
            }
        ?>									
    </div>
</div>
<?php
}
elseif($dropdown_field=='category' && $table_name=='tblscan_post'){
?>
<div class="<?php echo $col_value_add; ?>">
    <div class="form-group">
        <p><strong><?php echo $dropdown_set_label; ?></strong></p>
        <?php 
            if(isset($is_edit)){               
                $cha_tl=$CI->admin_model->selectCtrl_tl_e('tblarticle_category',$edit_comlunm,$dropdown_field,'dmcha_tl form-control','cmbdanhmuc1');
				echo $cha_tl;
            }else{
                $cha=$CI->admin_model->selectCtrl('tblarticle_category',$dropdown_field,'dmcha','cmbdanhmuc1');
                echo $cha;	
            }
        ?>	
        <script language="javascript">
            $(document).ready(function() {
                $('#cmbdanhmuc1').change(function() {
                    giatri = this.value;
                    $('#cmbdanhmuccon').load('<?php echo site_url().'/adminhp/loadcate2/'; ?>' + giatri);                    
                });
            });
        </script>									
    </div>
</div>
<?php
}elseif($dropdown_field=='category_sub' && $table_name=='tblscan_post'){
?>
<div class="<?php echo $col_value_add; ?>">
    <div class="form-group">
        <p><strong><?php echo $dropdown_set_label; ?></strong></p>
        <?php 
            if(isset($is_edit)){               
                $cha_tl=$CI->admin_model->selectCtrl_tl_e('tblarticle_category',$edit_comlunm,$dropdown_field,'dmcha_tl form-control','cmbdanhmuccon');
				echo $cha_tl;
            }else{
                $cha=$CI->admin_model->selectCtrl('tblarticle_category',$dropdown_field,'dmcha','cmbdanhmuccon');
                echo $cha;	
            }
        ?>									
    </div>
</div>
<?php
}
elseif($dropdown_field=='category' && $table_name=='tblarticle')
{
?>
<div class="<?php echo $col_value_add; ?>">
    <div class="form-group">
        <p><strong><?php echo $dropdown_set_label; ?></strong></p>
        <?php 
            if(isset($is_edit)){               
                $cha_tl=$CI->admin_model->selectCtrl_tl_e('tblarticle_category',$edit_comlunm,$dropdown_field,'dmcha_tl form-control','cmbdanhmuc1');
				echo $cha_tl;
            }else{
                $cha=$CI->admin_model->selectCtrl('tblarticle_category',$dropdown_field,'dmcha','cmbdanhmuc1');
                echo $cha;	
            }
        ?>	
        <script language="javascript">
            $(document).ready(function() {
                $('#cmbdanhmuc1').change(function() {
                    giatri = this.value;
                    $('#cmbdanhmuccon').load('<?php echo site_url().'/adminhp/loadcate2/'; ?>' + giatri);                    
                });
            });
        </script>									
    </div>
</div>
<?php
}	
elseif($dropdown_field=='category_sub' && $table_name=='tblarticle')
{
?>
<div class="<?php echo $col_value_add; ?>">
    <div class="form-group">
        <p><strong><?php echo $dropdown_set_label; ?></strong></p>
        <?php 
            if(isset($is_edit)){               
                $cha_tl=$CI->admin_model->selectCtrl_tl_e('tblarticle_category',$edit_comlunm,$dropdown_field,'dmcha_tl form-control','cmbdanhmuccon');
				echo $cha_tl;
            }else{
                $cha=$CI->admin_model->selectCtrl('tblarticle_category',$dropdown_field,'dmcha','cmbdanhmuccon');
                echo $cha;	
            }
        ?>									
    </div>
</div>
<?php
}																				 
else
{
?>
<div class="<?php echo $col_value_add; ?>">
    <div class="form-group">
        <p><strong><?php echo $dropdown_set_label;?></strong></p>
        <?php								
            $count=0;
        ?>
        <select name="<?php echo $dropdown_field;?>" class="form-control">
            <option value="0">--Không chọn--</option>
            <?php																	
                foreach($dropdown_column_type as $item)
                {
                    $name = key($item);	
                    if(isset($is_edit)) {
                        if($edit_comlunm==$item->$name){
                        ?>
                        <option value="<?php echo $item->$name;?>" selected="selected">
                        <?php                            
                        }
                        else{
                        ?>
                        <option value="<?php echo $item->$name;?>">
                        <?php                            
                        }
                    } else{
                    ?>
                    <option value="<?php echo $item->$name;?>">
                    <?php
                    }                
                    ?>                    
                    <?php                                                											
                    next($item);
                    $name = key($item);	
                    echo $item->$name;
                    ?>
                    </option>
                    <?php										
                }
            ?>
        </select>
    </div>
</div>
<?php								
}
?>				
		