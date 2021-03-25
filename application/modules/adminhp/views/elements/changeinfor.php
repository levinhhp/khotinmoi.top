


<?php
echo '<div id="main">';
if(isset($message['error']))
{
	echo '<div class="message error close">
		<h2>Lỗi!</h2>
		<p>'.$message['error'].'</p>
	</div>';	
}




if(isset($message['success']))




{




echo '<div class="message success close">




	<h2>Cập nhập dữ liệu thành công!</h2>




	<p>'.$message['success'].'</b></p>




	</div>';




}









if(isset($message['warning']))




{




	echo '<div class="message error close">




	<h2>Chú ý!</h2>




	<p>'.$message['warning'].'</p>




</div>';	




}









echo '<form method="post" action="'.site_url().'hpbackend/doChangeInfor/" enctype="multipart/form-data">';




						




						//Lấy các nhãn cho form element




						$getLabels=element($table_name,$labels);




						




						if(count($getLabels)==0)




						{




							echo 'Bạn chưa nhập tên các trường trong Controller/admin/HpBackend.php';




							return;




						}




						




						$i=0;




						foreach($getLabels as $label)




						{




							$setLabels[$i]=$label;




							$i++;




						}




						




						




						$i=0;




						$j=1;




						//Hiển thị form nhập dữ liệu




						$column=array();




						if($column_type!=NULL)




						{




							do




							{




								$column['Name']=key($column_type);




								




							}while(next($column_type));						




						}




						foreach($fields as $field)




						{




							




							if(element($field->Field,$column_type))




							{




								$column['Type']=element($field->Field,$column_type);




							




								if($column['Type'][0]=='radio')




								{




									echo '<p><strong>'.$setLabels[$i].'</strong><br>';




									$count=0;




									do




									{




										if($editContent[$field->Field]==$count)




										{




											echo '<input type="radio" name="'.$field->Field.'" checked="checked" value="'.$count.'" />';




										}




										else




										{




											echo '<input type="radio" name="'.$field->Field.'" value="'.$count.'" />';




										}




										echo $column['Type'][1][$count];




										$count++;




										




									}while(next($column['Type'][1]));




									




									echo '</p>';




									




								}elseif($column['Type'][0]=='dropdown')




								{




									echo '<p><strong>'.$setLabels[$i].'</strong><br>';




									$count=0;




							




									echo '<select name="'.$field->Field.'">';




									




									foreach($column['Type'][1] as $item)




									{




											$name = key($item);	




											if($editContent[$field->Field]==$item->$name)				




											{




												echo '<option value="'.$item->$name.'" selected="selected">';




											}




											else




											{




												echo '<option value="'.$item->$name.'" >';




											}




											




											next($item);




											$name = key($item);	




											echo $item->$name;









											echo '</option>';




									}




									echo '</select>';




									echo '</p>';




								}




								elseif($column['Type'][0]=='upload')




								{




									echo '<p><strong>'.$setLabels[$i].'</strong><br>';




									echo '<a target="_new" href="'.base_url().$editContent[$field->Field].'" class="tooltip" title="<img width=500 src='.base_url().$editContent[$field->Field].'>"><img src="'.base_url().$editContent[$field->Field].'" width="220" ></a>';









									echo '<br>';




									echo '<input type="hidden" value="'.$editContent[$field->Field].'"  name="hid'.$field->Field.'" />';




									echo '<input class="fileUpload" type="file"  name="'.$field->Field.'" /></p>';




								}




								elseif($column['Type'][0]=='password')




								{




									echo '<p><strong>'.$setLabels[$i].'</strong><br><input type="password" name="'.$field->Field.'" /></p>';




									echo '<p><strong>Xác nhận '.$setLabels[$i].'</strong><br><input type="password" name="re'.$field->Field.'" /></p>';




								}




							}




							elseif($field->Key=='PRI')




							{




								echo '<input type="hidden" name="'.$field->Field.'" value="'.$editContent[$field->Field].'" />';




							}




							elseif($field->Type=='date')




							{




								echo '<p><strong>'.$setLabels[$i].'</strong><br><input type="text" id="datepicker1" name="'.$field->Field.'" value="'.$editContent[$field->Field].'" /></p>';




							}




							




							elseif(substr($field->Type,0,3)=='int' || substr($field->Type,0,4)=='real' || substr($field->Type,0,5)=='float'|| substr($field->Type,0,6)=='double') 




							{




								echo '<p><strong>'.$setLabels[$i].'</strong><br><input maxlength="10" style="text-align:right; width:100px;" value="'.$editContent[$field->Field].'" type="text" name="'.$field->Field.'" /></p>';




							}




							




							elseif(substr($field->Type,0,7)=='varchar')




							{




								echo '<p><strong>'.$setLabels[$i].'</strong><br><input type="text" style="width:250px;"  value="'.$editContent[$field->Field].'" name="'.$field->Field.'" /></p>';




							}




							elseif($field->Type=='text')




							{




								echo '<p><strong>'.$setLabels[$i].'</strong><br><textarea id="editor'.$j.'"  name="'.$field->Field.'">'.$editContent[$field->Field].'</textarea></p>';




								$j++;




							}




							if($column_type!=NULL)




							{




									next($column_type);




							}




							$i++;




						}




						echo '<br>';




						echo '<p><input class="button" type="submit" value="Sửa" />




												<input class="button" type="reset" value="Xóa" /></p>';




						echo '</form>';




echo '</div>';




?>