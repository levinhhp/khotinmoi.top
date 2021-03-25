<?php 
$CI = &get_instance();
$CI->load->model('admin/admin_model');
$CI->load->library('pagination');
$_SESSION['start_date'] = $start_date;
$_SESSION['end_date'] = $end_date;
?>
<script type="text/javascript" src="backend/js/Chart.min.js"></script> 
<div class="col-md-12">
            <div class="panel panel-default" style="border:1px solid #17a2b8;">
            <div class="panel-heading" style="background:#17a2b8;color:#fff;padding-left:10px;font-weight:bold;">Bài viết (<?php echo $CI->admin_model->getStaticAllSearch($start_date,$end_date)->num_rows(); ?>)</div>
              <div class="panel-body" style="padding:15px;">
              <div class="row">
                  <div class="col-lg-3">
                  <div class="form-group">                      
                      <select class="form-control" id="category_static_in">
                        <option value="0">-- All --</option>
                        <?php 
                          $this->db->where('status',1);
                          $this->db->where('id !=',65);
                          $this->db->where('parent_id',0);
                          $sql_danhmuc = $this->db->get('tblarticle_category');
                          foreach($sql_danhmuc->result() as $item_danhmuc){
                          ?>
                          <option value="<?php echo $item_danhmuc->id; ?>"><?php echo $item_danhmuc->category; ?></option>
                          <?php  
                          }
                        ?>                                                
                      </select>
                    </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">                  
                          <input type="text" class="form-control" name="title_static_in" id="title_static_in" aria-describedby="emailHelp" placeholder="Tiêu đề">                  
                        </div>
                      </div>
                      <div class="col-lg-1">
                        <div class="form-group">                  
                          <button type="button" class="btn btn-danger" id="click_tk_search">Tìm kiếm</button>                 
                        </div>
                      </div>
                      <div class="col-lg-1">
                          <a href="<?php echo site_url('adminhp/export_artive/'); ?>" id="export_excel" class="btn btn-success">Export Excel</a>   
                      </div>
                  </div>
                  <!-- Posts List -->
                  <div id="ajax_content">                    
                    <?php                         
                        $config['base_url'] = site_url('adminhp/statistic_search_pagi/');
                        $config['total_rows'] = $CI->admin_model->getStaticAllSearch($start_date,$end_date)->num_rows();
                        $config['per_page'] = 10;
                        $config['uri_segment'] = 3;
                        $choice = $config['total_rows'] / $config['per_page'];
                        $config['num_links'] = floor($choice);
                        $this->pagination->initialize($config);
                
                        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
                
                        // fetch employees list
                        $data['results'] = $CI->admin_model->getStaticSearch($start_date,$end_date,$config['per_page'], $data['page']);       
                        // create pagination links                        
                        $pagination = $CI->pagination->create_links();
                        $lks=$pagination;
                        $lks='<ul class="pagination">'.$pagination; 
                        $datar1=array('<strong>','<a hr');    
                        $datar2=array('<li class="active"><a>','<li><a rel="nofollow" hr');
                        $datar3=array('</strong>','</a>');    
                        $datar4=array('</a></li>','</a><li>');         
                        $lks=str_replace($datar1,$datar2,$lks);
                        $lks=str_replace($datar3,$datar4,$lks);        
                        $lks.='</ul>';
                        $data['links'] = $lks;
                        if($this->input->post('ajax')) {
                            $this->load->view('static_do_ajax', $data);
                        } else {
                            $this->load->view('list_do_static', $data);
                        }
                    ?>
                </div>
              </div>
            </div>
          </div> 
<div class="col-md-6">

            <div class="panel panel-default" style="border:1px solid #f0645e;">
              <div class="panel-heading" style="background:#ff3547;color:#fff;padding-left:10px;font-weight:bold;">Lượt xem Bài viết</div>
              <div class="panel-body" style="padding:15px;">
              <canvas id="pie-chart"></canvas>
              </div>
            </div>                 
          </div>
          <div class="col-md-6">              
                  <div class="panel panel-default" style="border:1px solid #04b2dc;">
                      <div class="panel-heading" style="background:#04b2dc;color:#fff;padding-left:10px;font-weight:bold;">Số lượng bài viết theo người đăng</div>
                      <div class="panel-body" style="padding:15px;">
                      <?php 
                        $admin_label = '';
                        $admin_number = '';
                        $this->db->where('id !=',1);
                        $sql_user_admin = $this->db->get('tbladmin');  
                        foreach($sql_user_admin->result() as $item_user_admin){
                            $this->db->where("DATE_FORMAT(date_day,'%Y-%m-%d') >=",$start_date);
                            $this->db->where("DATE_FORMAT(date_day,'%Y-%m-%d') <=",$end_date);
                            $this->db->where('author',$item_user_admin->username);
                            $sql_tin_author = $this->db->get('tblarticle');
                            $admin_label.= '"'.$item_user_admin->name.'",';
                            $admin_number.= $sql_tin_author->num_rows().',';
                        }                    
                      ?>
                      <div class="graph">
                          <div class="chart-legend">

                          </div>
                          <div class="chart">
                              <canvas id="myChart1"></canvas>
                          </div>
                    </div>            
                      </div>
                    </div>                
          </div>
          <div class="col-md-12">
            <div class="panel panel-default" style="border:1px solid #04b2dc;">
                <div class="panel-heading" style="background:#04b2dc;color:#fff;padding-left:10px;font-weight:bold;">Lượt xem theo Category</div>
                <div class="panel-body" style="padding:15px;">          
                <canvas id="myChart" width="400"></canvas>
                </div>
              </div>           
          </div>
          <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
          <h4 class="modal-title" id="myLargeModalLabel">Thống kê theo giờ		  
		  </h4>          
        </div>
        <div class="modal-body" style="height:unset;overflow-y:unset">
            <?php                                       			
				$time_ts = strtotime($start_date);
				$time_te = strtotime($end_date);				
				$list_time = array();
				if($time_ts && $time_te){
				  for ($i=$time_ts; $i <= $time_te ; $i+=86400){
					$list_time[] = date("Y-m-d",$i);
				  }
				}
				$no_time = 0;
				$no_1h = 0;
				$no_2h = 0;
				$no_3h = 0;
				$no_4h = 0;
				$no_5h = 0;
				$no_6h = 0;
				$no_7h = 0;
				$no_8h = 0;
				$no_9h = 0;
				$no_10h = 0;
				$no_11h = 0;
				$no_12h = 0;
				$no_13h = 0;
				$no_14h = 0;
				$no_15h = 0;
				$no_16h = 0;
				$no_17h = 0;
				$no_18h = 0;
				$no_19h = 0;
				$no_20h = 0;
				$no_21h = 0;
				$no_22h = 0;
				$no_23h = 0;				
				foreach($list_time as $item_list_time){
					//0h
					$sql_no_oneh = "select SUM(view) as totalNoOne from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$item_list_time.' 00:00'."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$item_list_time.' 00:59'."' ";
					$sql_post_count_oneh = $this->db->query($sql_no_oneh);  					
					//1h
					$sql_1h = "select SUM(view) as totalNo1h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$item_list_time.' 01:00'."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$item_list_time.' 01:59'."' ";												
					$sql_post_count_1h = $this->db->query($sql_1h);
					//2h
					$sql_2h = "select SUM(view) as totalNo2h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$item_list_time.' 02:00'."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$item_list_time.' 02:59'."' ";												
					$sql_post_count_2h = $this->db->query($sql_2h);
					//3h
					$sql_3h = "select SUM(view) as totalNo3h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$item_list_time.' 03:00'."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$item_list_time.' 03:59'."' ";												
					$sql_post_count_3h = $this->db->query($sql_3h);
					//4h
					$sql_4h = "select SUM(view) as totalNo4h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$item_list_time.' 04:00'."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$item_list_time.' 04:59'."' ";												
					$sql_post_count_4h = $this->db->query($sql_4h);
					//5h
					$sql_5h = "select SUM(view) as totalNo5h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$item_list_time.' 05:00'."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$item_list_time.' 05:59'."' ";												
					$sql_post_count_5h = $this->db->query($sql_5h);
					//6h
					$sql_6h = "select SUM(view) as totalNo6h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$item_list_time.' 06:00'."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$item_list_time.' 06:59'."' ";												
					$sql_post_count_6h = $this->db->query($sql_6h);
					//7h
					$sql_7h = "select SUM(view) as totalNo7h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$item_list_time.' 07:00'."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$item_list_time.' 07:59'."' ";												
					$sql_post_count_7h = $this->db->query($sql_7h);
					//8h
					$sql_8h = "select SUM(view) as totalNo8h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$item_list_time.' 08:00'."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$item_list_time.' 08:59'."' ";												
					$sql_post_count_8h = $this->db->query($sql_8h);
					//9h
					$sql_9h = "select SUM(view) as totalNo9h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$item_list_time.' 09:00'."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$item_list_time.' 09:59'."' ";												
					$sql_post_count_9h = $this->db->query($sql_9h);
					//10h
					$sql_10h = "select SUM(view) as totalNo10h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$item_list_time.' 10:00'."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$item_list_time.' 10:59'."' ";												
					$sql_post_count_10h = $this->db->query($sql_10h);
					//11h
					$sql_11h = "select SUM(view) as totalNo11h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$item_list_time.' 11:00'."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$item_list_time.' 11:59'."' ";												
					$sql_post_count_11h = $this->db->query($sql_11h);
					//12h
					$sql_12h = "select SUM(view) as totalNo12h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$item_list_time.' 12:00'."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$item_list_time.' 12:59'."' ";												
					$sql_post_count_12h = $this->db->query($sql_12h);
					//13h
					$sql_13h = "select SUM(view) as totalNo13h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$item_list_time.' 13:00'."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$item_list_time.' 13:59'."' ";												
					$sql_post_count_13h = $this->db->query($sql_13h);
					//14h
					$sql_14h = "select SUM(view) as totalNo14h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$item_list_time.' 14:00'."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$item_list_time.' 14:59'."' ";												
					$sql_post_count_14h = $this->db->query($sql_14h);
					//15h
					$sql_15h = "select SUM(view) as totalNo15h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$item_list_time.' 15:00'."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$item_list_time.' 15:59'."' ";												
					$sql_post_count_15h = $this->db->query($sql_15h);
					//16h
					$sql_16h = "select SUM(view) as totalNo16h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$item_list_time.' 16:00'."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$item_list_time.' 16:59'."' ";												
					$sql_post_count_16h = $this->db->query($sql_16h);
					//17h
					$sql_17h = "select SUM(view) as totalNo17h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$item_list_time.' 17:00'."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$item_list_time.' 17:59'."' ";												
					$sql_post_count_17h = $this->db->query($sql_17h);
					//18h
					$sql_18h = "select SUM(view) as totalNo18h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$item_list_time.' 18:00'."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$item_list_time.' 18:59'."' ";												
					$sql_post_count_18h = $this->db->query($sql_18h);
					//19h
					$sql_19h = "select SUM(view) as totalNo19h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$item_list_time.' 19:00'."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$item_list_time.' 19:59'."' ";												
					$sql_post_count_19h = $this->db->query($sql_19h);
					//20h
					$sql_20h = "select SUM(view) as totalNo20h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$item_list_time.' 20:00'."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$item_list_time.' 20:59'."' ";												
					$sql_post_count_20h = $this->db->query($sql_20h);
					//21h
					$sql_21h = "select SUM(view) as totalNo21h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$item_list_time.' 21:00'."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$item_list_time.' 21:59'."' ";												
					$sql_post_count_21h = $this->db->query($sql_21h);
					//22h
					$sql_22h = "select SUM(view) as totalNo22h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$item_list_time.' 22:00'."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$item_list_time.' 22:59'."' ";												
					$sql_post_count_22h = $this->db->query($sql_22h);
					//23h
					$sql_23h = "select SUM(view) as totalNo23h from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$item_list_time.' 23:00'."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <='".$item_list_time.' 23:59'."' ";												
					$sql_post_count_23h = $this->db->query($sql_23h);
					$no_time+=$sql_post_count_oneh->row()->totalNoOne;	
					$no_1h+=$sql_post_count_1h->row()->totalNo1h;
					$no_2h+=$sql_post_count_2h->row()->totalNo2h;
					$no_3h+=$sql_post_count_3h->row()->totalNo3h;
					$no_4h+=$sql_post_count_4h->row()->totalNo4h;
					$no_5h+=$sql_post_count_5h->row()->totalNo5h;
					$no_6h+=$sql_post_count_6h->row()->totalNo6h;
					$no_7h+=$sql_post_count_7h->row()->totalNo7h;
					$no_8h+=$sql_post_count_8h->row()->totalNo8h;
					$no_9h+=$sql_post_count_9h->row()->totalNo9h;
					$no_10h+=$sql_post_count_10h->row()->totalNo10h;
					$no_11h+=$sql_post_count_11h->row()->totalNo11h;
					$no_12h+=$sql_post_count_12h->row()->totalNo12h;
					$no_13h+=$sql_post_count_13h->row()->totalNo13h;
					$no_14h+=$sql_post_count_14h->row()->totalNo14h;
					$no_15h+=$sql_post_count_15h->row()->totalNo15h;
					$no_16h+=$sql_post_count_16h->row()->totalNo16h;
					$no_17h+=$sql_post_count_17h->row()->totalNo17h;
					$no_18h+=$sql_post_count_18h->row()->totalNo18h;
					$no_19h+=$sql_post_count_19h->row()->totalNo19h;
					$no_20h+=$sql_post_count_20h->row()->totalNo20h;
					$no_21h+=$sql_post_count_21h->row()->totalNo21h;
					$no_22h+=$sql_post_count_22h->row()->totalNo22h;
					$no_23h+=$sql_post_count_23h->row()->totalNo23h;
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
          <script src="backend/js/chartjs-plugin-datalabels.js"></script>
<canvas id="pie-chart"></canvas>
<?php     
    $sql_like = "select * from `tbladdress_ip_like` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d') = '".date('Y-m-d')."' ";
    $sql_like_ip = $this->db->query($sql_like);
    $total_like = $sql_like_ip->num_rows();       
    $sql_1 = "select SUM(view) as totalView from `tbladdress_ip_view` where `status` = 1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$start_date."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <= '".$end_date."' ";       
    $sql_view = $this->db->query($sql_1);       
    $total_view=$sql_view->row()->totalView;           
    $sql_visi = "select * from `tbladdress_ip` where `status` = 1 and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$start_date."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <= '".$end_date."' ";       
    $sql_visitor = $this->db->query($sql_visi); 
    $total_visitor = $sql_visitor->num_rows();   
    $data_label = '[';
    $data_label_number = '[';
    $this->db->where('status',1);       
    $this->db->where('id !=',65); 
    $this->db->where('parent_id',0);   
    $sql_category = $this->db->get('tblarticle_category');
    foreach($sql_category->result() as $item_category){
        $data_label.='"'.$item_category->category.'",'; 
        $dem_sub = 0;                  
        $sql_2 = "select SUM(view) as totalView1 from `tbladdress_ip_view` where `status`=1 and `category_id`='".$item_category->id."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') >= '".$start_date."' and DATE_FORMAT(date_day,'%Y-%m-%d %H:%i') <= '".$end_date."' ";      
        $sql_label_number = $this->db->query($sql_2);                
        $data_label_number.='"'.$sql_label_number->row()->totalView1.'",';
    }
    $data_label_number.=']';
    $data_label.= ']';

?>
<script>
    var data = [{
  data: ['<?php echo $total_view; ?>', '<?php echo $total_like; ?>','<?php echo $total_visitor; ?>'],
  backgroundColor: [
    "#4b77a9",
    "#5f255f",
    "#d21243",    
  ],
  borderColor: "#fff"
}];

var options = {
  tooltips: {
    enabled: true
  },
  plugins: {
    datalabels: {
      formatter: (value, ctx) => {

        let sum = ctx.dataset._meta[0].total;
        let percentage = (value * 100 / sum).toFixed(2) + "%";
        return percentage;


      },
      color: '#fff',
    }
  }
};


var ctx = document.getElementById("pie-chart").getContext('2d');
var myChart = new Chart(ctx, {
  type: 'pie',
  data: {
  labels: ['Lượt xem' + ' (<?php echo $total_view; ?>)', 'Like' + ' (<?php echo $total_like; ?>)','Visitor' + ' (<?php echo $total_visitor; ?>)'],
    datasets: data
  },
  options: options
});
var ctx1 = document.getElementById('myChart').getContext('2d');
var myChart1 = new Chart(ctx1, {
    type: 'bar',
    data: {
        labels: <?php echo $data_label; ?>,
        datasets: [{
            label: 'Lượt Xem theo Category',
            data: <?php echo $data_label_number; ?>,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
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
        $("#click_tk_search").on('click',function(){          
          var category_static_in =$("#category_static_in").val();
          var title_static_in = $("#title_static_in").val();          
          $.ajax({
              cache:false,
              type:"POST",
              data:{category_static_in : category_static_in,title_static_in : title_static_in},
              url:"<?php echo site_url('adminhp/doSearchListStaticIn/'); ?>", 
              success:function(html){            
                  $("#ajax_content").html(html);                  
              }                                                          
          });
      });    
});
var ctx = $('#myChart1');

ctx.height(375);
var myChart = new Chart(ctx, {
    type: 'horizontalBar',
    data: {
        labels: [<?php echo $admin_label; ?>],
        datasets: [{
            label: '# of Votes',
            data: [<?php echo $admin_number; ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    maintainAspectRatio: false,
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
var ctx = $('#myChart2');
ctx.height(500);
var myChart = new Chart(ctx, {
    type: 'horizontalBar',
    data: {
        labels: ["23:00","22:00","21:00","20:00","19:00","18:00","17:00","16:00","15:00","14:00","13:00","12:00","11:00","10:00","09:00","08:00","07:00","06:00","05:00","04:00","03:00","02:00","01:00","00:00"],
        datasets: [{
            label: '# of Time',
            data: [<?php echo $no_23h; ?>,<?php echo $no_22h; ?>,<?php echo $no_21h; ?>,<?php echo $no_20h; ?>,<?php echo $no_19h; ?>,<?php echo $no_18h; ?>,<?php echo $no_17h; ?>,<?php echo $no_16h; ?>,<?php echo $no_15h; ?>,<?php echo $no_14h; ?>,<?php echo $no_13h; ?>,<?php echo $no_12h; ?>,<?php echo $no_11h; ?>,<?php echo $no_10h; ?>,<?php echo $no_9h; ?>,<?php echo $no_8h; ?>,<?php echo $no_7h; ?>,<?php echo $no_6h; ?>,<?php echo $no_5h; ?>,<?php echo $no_4h; ?>,<?php echo $no_3h; ?>,<?php echo $no_2h; ?>,<?php echo $no_1h; ?>,<?php echo $no_time; ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.1)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.3)',
                'rgba(75, 192, 192, 0.4)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(255, 159, 64, 0.6)',
                'rgba(255,99,132,0.7)',
                'rgba(54, 162, 235, 0.8)',
                'rgba(255, 206, 86, 0.9)',
                'rgba(75, 192, 192, 0.1)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.3)',
                'rgba(255,99,132,0.4)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(75, 192, 192, 0.7)',
                'rgba(153, 102, 255,0.8)',
                'rgba(255, 159, 64,0.9)',
                'rgba(255, 99, 132,0.1)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.3)',
                'rgba(75, 192, 192, 0.4)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(255, 159, 64, 0.6)',
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255,1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235,1)',
                'rgba(255, 206, 86,1)',
                'rgba(75, 192, 192,1)',
                'rgba(153, 102, 255,1)',
                'rgba(255, 159, 64,1)',
            ],
            borderWidth: 1
        }]
    },
    maintainAspectRatio: false,
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>