<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
          <h4 class="modal-title" id="myLargeModalLabel">Thống kê theo giờ</h4>          
        </div>
        <div class="modal-body" style="height:unset;overflow-y:unset">
            <?php 
                //0H
                $count_no_oneh_start_date = date('Y-m-d')." 00:00";
                $count_no_oneh_end_date = date('Y-m-d')." 00:59";
                $sql_no_oneh = "select SUM(view) as totalNoOne from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$count_no_oneh_start_date."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$count_no_oneh_end_date."' ";
                $sql_post_count_oneh = $this->db->query($sql_no_oneh);
                if($sql_post_count_oneh->num_rows()>0){
                  $no_time = $sql_post_count_oneh->row()->totalNoOne;
                }else{
                  $no_time = 0; 
                }
                //1H
                $count_1h_start_date = date('Y-m-d')." 01:00";
                $count_1h_end_date = date('Y-m-d')." 01:59";
                $sql_1h = "select SUM(view) as totalNo1h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$count_1h_start_date."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$count_1h_end_date."' ";
                $sql_post_count_1h = $this->db->query($sql_1h);
                if($sql_post_count_1h->num_rows()>0){
                  $no_1h = $sql_post_count_1h->row()->totalNo1h;
                }else{
                  $no_1h = 0;
                }
                //2h
                $count_2h_start_date = date('Y-m-d')." 02:00";
                $count_2h_end_date = date('Y-m-d')." 02:59";
                $sql_2h = "select SUM(view) as totalNo2h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$count_2h_start_date."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$count_2h_end_date."' ";
                $sql_post_count_2h = $this->db->query($sql_2h);
                if($sql_post_count_2h->num_rows()>0){
                  $no_2h = $sql_post_count_2h->row()->totalNo2h;
                }else{
                  $no_2h = 0;
                }
                //3h
                $count_3h_start_date = date('Y-m-d')." 03:00";
                $count_3h_end_date = date('Y-m-d')." 03:59";
                $sql_3h = "select SUM(view) as totalNo3h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$count_3h_start_date."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$count_3h_end_date."' ";
                $sql_post_count_3h = $this->db->query($sql_3h);
                if($sql_post_count_3h->num_rows()>0){
                  $no_3h = $sql_post_count_3h->row()->totalNo3h;
                }else{
                  $no_3h = 0;
                }
                //4h
                $count_4h_start_date = date('Y-m-d')." 04:00";
                $count_4h_end_date = date('Y-m-d')." 04:59";
                $sql_4h = "select SUM(view) as totalNo4h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$count_4h_start_date."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$count_4h_end_date."' ";
                $sql_post_count_4h = $this->db->query($sql_4h);
                if($sql_post_count_4h->num_rows()>0){
                  $no_4h = $sql_post_count_4h->row()->totalNo4h;
                }else{
                  $no_4h = 0;
                }
                //5h
                $count_5h_start_date = date('Y-m-d')." 05:00";
                $count_5h_end_date = date('Y-m-d')." 05:59";
                $sql_5h = "select SUM(view) as totalNo5h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$count_5h_start_date."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$count_5h_end_date."' ";
                $sql_post_count_5h = $this->db->query($sql_5h);
                if($sql_post_count_5h->num_rows()>0){
                  $no_5h = $sql_post_count_5h->row()->totalNo5h;
                }else{
                  $no_5h = 0;
                }
                //6h
                $count_6h_start_date = date('Y-m-d')." 06:00";
                $count_6h_end_date = date('Y-m-d')." 06:59";
                $sql_6h = "select SUM(view) as totalNo6h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$count_6h_start_date."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$count_6h_end_date."' ";
                $sql_post_count_6h = $this->db->query($sql_6h);
                if($sql_post_count_6h->num_rows()>0){
                  $no_6h = $sql_post_count_6h->row()->totalNo6h;
                }else{
                  $no_6h = 0;
                }
                //7h
                $count_7h_start_date = date('Y-m-d')." 07:00";
                $count_7h_end_date = date('Y-m-d')." 07:59";
                $sql_7h = "select SUM(view) as totalNo7h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$count_7h_start_date."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$count_7h_end_date."' ";
                $sql_post_count_7h = $this->db->query($sql_7h);
                if($sql_post_count_7h->num_rows()>0){
                  $no_7h = $sql_post_count_7h->row()->totalNo7h;
                }else{
                  $no_7h = 0;
                }
                //8h
                $count_8h_start_date = date('Y-m-d')." 08:00";
                $count_8h_end_date = date('Y-m-d')." 08:59";
                $sql_8h = "select SUM(view) as totalNo8h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$count_8h_start_date."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$count_8h_end_date."' ";
                $sql_post_count_8h = $this->db->query($sql_8h);
                if($sql_post_count_8h->num_rows()>0){
                  $no_8h = $sql_post_count_8h->row()->totalNo8h;
                }else{
                  $no_8h = 0;
                }
                //9h
                $count_9h_start_date = date('Y-m-d')." 09:00";
                $count_9h_end_date = date('Y-m-d')." 09:59";
                $sql_9h = "select SUM(view) as totalNo9h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$count_9h_start_date."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$count_9h_end_date."' ";
                $sql_post_count_9h = $this->db->query($sql_9h);
                if($sql_post_count_9h->num_rows()>0){
                  $no_9h = $sql_post_count_9h->row()->totalNo9h;
                }else{
                  $no_9h = 0;
                }
                //10h
                $count_10h_start_date = date('Y-m-d')." 10:00";
                $count_10h_end_date = date('Y-m-d')." 10:59";
                $sql_10h = "select SUM(view) as totalNo10h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$count_10h_start_date."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$count_10h_end_date."' ";
                $sql_post_count_10h = $this->db->query($sql_10h);
                if($sql_post_count_10h->num_rows()>0){
                  $no_10h = $sql_post_count_10h->row()->totalNo10h;
                }else{
                  $no_10h = 0;
                }
                //11h
                $count_11h_start_date = date('Y-m-d')." 11:00";
                $count_11h_end_date = date('Y-m-d')." 11:59";
                $sql_11h = "select SUM(view) as totalNo11h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$count_11h_start_date."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$count_11h_end_date."' ";
                $sql_post_count_11h = $this->db->query($sql_11h);
                if($sql_post_count_11h->num_rows()>0){
                  $no_11h = $sql_post_count_11h->row()->totalNo11h;
                }else{
                  $no_11h = 0;
                }
                //12h
                $count_12h_start_date = date('Y-m-d')." 12:00";
                $count_12h_end_date = date('Y-m-d')." 12:59";
                $sql_12h = "select SUM(view) as totalNo12h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$count_12h_start_date."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$count_12h_end_date."' ";
                $sql_post_count_12h = $this->db->query($sql_12h);
                if($sql_post_count_12h->num_rows()>0){
                  $no_12h = $sql_post_count_12h->row()->totalNo12h;
                }else{
                  $no_12h = 0;
                }
                //13h
                $count_13h_start_date = date('Y-m-d')." 13:00";
                $count_13h_end_date = date('Y-m-d')." 13:59";
                $sql_13h = "select SUM(view) as totalNo13h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$count_13h_start_date."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$count_13h_end_date."' ";
                $sql_post_count_13h = $this->db->query($sql_13h);
                if($sql_post_count_13h->num_rows()>0){
                  $no_13h = $sql_post_count_13h->row()->totalNo13h;
                }else{
                  $no_13h = 0;
                }
                //14h
                $count_14h_start_date = date('Y-m-d')." 14:00";
                $count_14h_end_date = date('Y-m-d')." 14:59";
                $sql_14h = "select SUM(view) as totalNo14h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$count_14h_start_date."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$count_14h_end_date."' ";
                $sql_post_count_14h = $this->db->query($sql_14h);
                if($sql_post_count_14h->num_rows()>0){
                  $no_14h = $sql_post_count_14h->row()->totalNo14h;
                }else{
                  $no_14h = 0;
                }
                //15h
                $count_15h_start_date = date('Y-m-d')." 15:00";
                $count_15h_end_date = date('Y-m-d')." 15:59";
                $sql_15h = "select SUM(view) as totalNo15h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$count_15h_start_date."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$count_15h_end_date."' ";
                $sql_post_count_15h = $this->db->query($sql_15h);
                if($sql_post_count_15h->num_rows()>0){
                  $no_15h = $sql_post_count_15h->row()->totalNo15h;
                }else{
                  $no_15h = 0;
                }
                //16h
                $count_16h_start_date = date('Y-m-d')." 16:00";
                $count_16h_end_date = date('Y-m-d')." 16:59";
                $sql_16h = "select SUM(view) as totalNo16h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$count_16h_start_date."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$count_16h_end_date."' ";
                $sql_post_count_16h = $this->db->query($sql_16h);
                if($sql_post_count_16h->num_rows()>0){
                  $no_16h = $sql_post_count_16h->row()->totalNo16h;
                }else{
                  $no_16h = 0;
                }
                //17h
                $count_17h_start_date = date('Y-m-d')." 17:00";
                $count_17h_end_date = date('Y-m-d')." 17:59";
                $sql_17h = "select SUM(view) as totalNo17h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$count_17h_start_date."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$count_17h_end_date."' ";
                $sql_post_count_17h = $this->db->query($sql_17h);
                if($sql_post_count_17h->num_rows()>0){
                  $no_17h = $sql_post_count_17h->row()->totalNo17h;
                }else{
                  $no_17h = 0;
                }
                //18h
                $count_18h_start_date = date('Y-m-d')." 18:00";
                $count_18h_end_date = date('Y-m-d')." 18:59";
                $sql_18h = "select SUM(view) as totalNo18h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$count_18h_start_date."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$count_18h_end_date."' ";
                $sql_post_count_18h = $this->db->query($sql_18h);
                if($sql_post_count_18h->num_rows()>0){
                  $no_18h = $sql_post_count_18h->row()->totalNo18h;
                }else{
                  $no_18h = 0;
                }
                //19h
                $count_19h_start_date = date('Y-m-d')." 19:00";
                $count_19h_end_date = date('Y-m-d')." 19:59";
                $sql_19h = "select SUM(view) as totalNo19h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$count_19h_start_date."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$count_19h_end_date."' ";
                $sql_post_count_19h = $this->db->query($sql_19h);
                if($sql_post_count_19h->num_rows()>0){
                  $no_19h = $sql_post_count_19h->row()->totalNo19h;
                }else{
                  $no_19h = 0;
                }
                //20h
                $count_20h_start_date = date('Y-m-d')." 20:00";
                $count_20h_end_date = date('Y-m-d')." 20:59";
                $sql_20h = "select SUM(view) as totalNo20h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$count_20h_start_date."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$count_20h_end_date."' ";
                $sql_post_count_20h = $this->db->query($sql_20h);
                if($sql_post_count_20h->num_rows()>0){
                  $no_20h = $sql_post_count_20h->row()->totalNo20h;
                }else{
                  $no_20h = 0;
                }
                //21h
                $count_21h_start_date = date('Y-m-d')." 21:00";
                $count_21h_end_date = date('Y-m-d')." 21:59";
                $sql_21h = "select SUM(view) as totalNo21h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$count_21h_start_date."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$count_21h_end_date."' ";
                $sql_post_count_21h = $this->db->query($sql_21h);
                if($sql_post_count_21h->num_rows()>0){
                  $no_21h = $sql_post_count_21h->row()->totalNo21h;
                }else{
                  $no_21h = 0;
                }
                //22h
                $count_22h_start_date = date('Y-m-d')." 22:00";
                $count_22h_end_date = date('Y-m-d')." 22:59";
                $sql_22h = "select SUM(view) as totalNo22h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$count_22h_start_date."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$count_22h_end_date."' ";
                $sql_post_count_22h = $this->db->query($sql_22h);
                if($sql_post_count_22h->num_rows()>0){
                  $no_22h = $sql_post_count_22h->row()->totalNo22h;
                }else{
                  $no_22h = 0;
                }
                //23h
                $count_23h_start_date = date('Y-m-d')." 23:00";
                $count_23h_end_date = date('Y-m-d')." 23:59";
                $sql_23h = "select SUM(view) as totalNo23h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$count_23h_start_date."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$count_23h_end_date."' ";
                $sql_post_count_23h = $this->db->query($sql_23h);
                if($sql_post_count_23h->num_rows()>0){
                  $no_23h = $sql_post_count_23h->row()->totalNo23h;
                }else{
                  $no_23h = 0;
                }
            ?>
          <div class="graph">
              <div class="chart-legend">

              </div>
              <div class="chart">
                  <canvas id="myChart2"></canvas>
              </div>
          </div>        
        </div>
    </div>
  </div>
</div>