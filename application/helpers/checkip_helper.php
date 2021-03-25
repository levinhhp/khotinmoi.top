<?php 
function check_ip(){    
    $CI = &get_instance();
    $ip = $CI->input->ip_address();
    if($ip!='183.81.68.187'){
        $CI->db->where('ip_address',$ip);
        $CI->db->where("DATE_FORMAT(date_day,'%Y-%m-%d') =",date('Y-m-d'));
        $sql = $CI->db->get('tbladdress_ip');
        if($sql->num_rows()>0){
        }else{
            $data = [
                'ip_address' => $ip,
                'date_day' => date('Y-m-d H:i'),
                'status' => 1
            ];
            $CI->db->insert('tbladdress_ip',$data);        
        }
    }
}
?>