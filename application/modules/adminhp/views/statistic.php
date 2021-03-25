
<?php 
$CI = &get_instance();
$CI->load->model('admin/admin_model');
$CI->load->library('pagination');
?>
<script type="text/javascript" src="backend/js/moment.min.js"></script>
<script type="text/javascript" src="backend/js/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="backend/css/daterangepicker.css" />
<script type="text/javascript" src="backend/js/Chart.min.js"></script> 
<section class="content-header">
	<h1><?php echo element($table_name,$table_list); ?></h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('adminhp') ?>"><i class="glyphicon glyphicon-home"></i></a><span class="divider"></span></li>		
		<li class="active">
			Thống kê bài viết
		</li>
	</ol>                
</section>
<section class="content">
    <div class="row">
    <?php 
        $this->db->where('id !=',65);
        $this->db->where('parent_id',0);
        $sqldanhmuc = $this->db->get('tblarticle_category');
        $dem_cu_su_hao = 1;
        foreach($sqldanhmuc->result() as $item_damhmuc){
          $this->db->where('category !=',65);
          $this->db->where('category',$item_damhmuc->id);
          $sql_tin_dm = $this->db->get('tblarticle');
        ?>
        <div class="col-lg-3" style="padding-bottom:10px;">
            <button style="display:block;width:100%;color:#fff;<?php if($dem_cu_su_hao==6){ ?>background:#FF69B4;<?php }elseif($dem_cu_su_hao ==7){ ?>background:#FF1493;<?php }elseif($dem_cu_su_hao==8){ ?>background:#DB7093;<?php }elseif($dem_cu_su_hao==9){ ?>background:#C71585;<?php }elseif($dem_cu_su_hao==10){ ?>background:#FF00FF;<?php }elseif($dem_cu_su_hao==11){ ?>background:#FF8C00;<?php }elseif($dem_cu_su_hao==12){ ?>background:#FF4500;<?php }elseif($dem_cu_su_hao==13){ ?>background:#0000FF;<?php }elseif($dem_cu_su_hao==14){ ?>background:#A52A2A;<?php } ?>" type="button" class="<?php if($dem_cu_su_hao==1){ echo 'btn btn-primary';}elseif($dem_cu_su_hao==2){ echo 'btn btn-success';}elseif($dem_cu_su_hao==3){ echo 'btn btn-danger';}elseif($dem_cu_su_hao==4){ echo 'btn btn-warning';}elseif($dem_cu_su_hao==5){ echo 'btn btn-info';}else{ echo 'btn btn-dark';} ?>"><?php echo $item_damhmuc->category; ?> (<?php echo $sql_tin_dm->num_rows(); ?>)</button>
        </div>
        <?php
        $dem_cu_su_hao++;
        }
    ?>
    </div>
    <div class="box box-primary borderless">
        <div class="box-header">
            <div class="pull-left">
                <h3 class="box-title"><i class="fa fa-info-circle"></i>Thống kê bài viết</h3>
            </div>
            <div class="pull-right"></div>
            <div class="clearfix"><!-- --></div>
		</div>
        <div class="box-body">  
        <div class="row">            
            <div class="col-lg-12">
                <div class="panel panel-default">
                  <div class="panel-heading" style="background:#17a2b8;color:#fff;padding-left:10px;font-weight:bold;">Visitor theo thiết bị</div>
                  <div class="panel-body" style="padding:15px;">
                      <div class="row">
                          <div class="col-lg-4">
                              <div class="panel panel-default">
                                  <div class="panel-heading">Hôm nay</div>
                                  <div class="panel-body" style="padding:15px;">                                 
                                      <canvas id="chart-student-age_today"></canvas>                      
                                      <div class="clearfix"></div>
                                  </div>
                              </div>    
                          </div>
                          <div class="col-lg-4">
                              <div class="panel panel-default">
                                  <div class="panel-heading">Tuần</div>
                                  <div class="panel-body" style="padding:15px;">                                 
                                      <canvas id="chart-student-age_weekend"></canvas>                      
                                      <div class="clearfix"></div>
                                  </div>
                              </div>    
                          </div>
                          <div class="col-lg-4">
                              <div class="panel panel-default">
                                  <div class="panel-heading">Tháng</div>
                                  <div class="panel-body" style="padding:15px;">                                 
                                      <canvas id="chart-student-month"></canvas>                      
                                      <div class="clearfix"></div>
                                  </div>
                              </div>    
                          </div>
                      </div>                                                         
                      <div class="clearfix"></div>
                  </div>
                </div>
            </div>  
			<div class="col-lg-12">
                <div class="panel panel-default">
                  <div class="panel-heading" style="background:#17a2b8;color:#fff;padding-left:10px;font-weight:bold;">Thống kê theo tháng</div>
                  <div class="panel-body" style="padding:15px;">
                      <div id="canvas-holder">
                        <canvas id="chart-area" width="300" height="106">
                      </div>
                      <div id="chartjs-tooltip"></div>                                                
                      <div class="clearfix"></div>
                  </div>
                </div>
            </div>  
        </div>   
        <hr>    
        <?php 		
         $sql_ngay = "select SUM(view) as totalViewDay from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d') = '".date('Y-m-d')."' ";
         $sql_view_ngay = $this->db->query($sql_ngay);  
         $total_view_day=$sql_view_ngay->row()->totalViewDay; 
         $sql_tuan = "select SUM(view) as totalViewTuan from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d') >= '".date('Y-m-d',strtotime('-7 day'))."' and DATE_FORMAT(date_day,'%Y-%m-%d') <= '".date('Y-m-d')."' ";
         $sql_view_tuan = $this->db->query($sql_tuan);  
         if($sql_view_tuan->num_rows()>0){
          $total_view_tuan=$sql_view_tuan->row()->totalViewTuan;
         }else{
          $total_view_tuan=0;
         }         
         $sql_thang = "select SUM(view) as totalViewMon from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%m') = '".date('m')."' ";
         $sql_view_thang = $this->db->query($sql_thang);   
         $total_view_mon=$sql_view_thang->row()->totalViewMon;              
        //check desvices
        $sql_device_pc = "select * from `tbladdress_ip` where `status`=1 and `devices`='".PC."' and DATE_FORMAT(date_day,'%Y-%m-%d') = '".date('Y-m-d')."' ";
        $sql_device_pc_rs = $this->db->query($sql_device_pc);  
        $total_device_pc=$sql_device_pc_rs->num_rows(); 
        $sql_device_mopbile = "select * from `tbladdress_ip` where `status`=1 and `devices`='".MOBILE."' and DATE_FORMAT(date_day,'%Y-%m-%d') = '".date('Y-m-d')."' ";
        $sql_device_mopbile_rs = $this->db->query($sql_device_mopbile);          
        $total_device_mobile=$sql_device_mopbile_rs->num_rows(); 
        $total_device_pc_per = round(($total_device_pc*100)/($total_device_pc + $total_device_mobile));
        $total_device_mobile_per = (100 - $total_device_pc_per);
        //by weekend
        $sql_device_tuan_pc = "select * from `tbladdress_ip` where `status`=1 and `devices`='".PC."' and DATE_FORMAT(date_day,'%Y-%m-%d') >= '".date('Y-m-d',strtotime('-7 day'))."' and DATE_FORMAT(date_day,'%Y-%m-%d') <= '".date('Y-m-d')."' ";
        $total_device_tuan_pc = $this->db->query($sql_device_tuan_pc)->num_rows();  
        $sql_device_tuan_mobile = "select * from `tbladdress_ip` where `status`=1 and `devices`='".MOBILE."' and DATE_FORMAT(date_day,'%Y-%m-%d') >= '".date('Y-m-d',strtotime('-7 day'))."' and DATE_FORMAT(date_day,'%Y-%m-%d') <= '".date('Y-m-d')."' ";
        $total_device_tuan_mobile = $this->db->query($sql_device_tuan_mobile)->num_rows();  
        $total_device_tuan_pc_pre = round(($total_device_tuan_pc*100)/($total_device_tuan_pc + $total_device_tuan_mobile));
        $total_device_tuan_mobile_pre = (100 - $total_device_tuan_pc_pre);
        //by mont
        $sql_device_pc_mon = "select * from `tbladdress_ip` where `status`=1 and `devices`='".PC."' and DATE_FORMAT(date_day,'%m') = '".date('m')."' ";
        $total_device_pc_mon = $this->db->query($sql_device_pc_mon)->num_rows();
        $sql_device_pc_mobile = "select * from `tbladdress_ip` where `status`=1 and `devices`='".MOBILE."' and DATE_FORMAT(date_day,'%m') = '".date('m')."' ";
        $total_device_mobile_mon = $this->db->query($sql_device_pc_mobile)->num_rows();
        $total_device_pc_mon_pre = round(($total_device_pc_mon*100)/($total_device_pc_mon + $total_device_mobile_mon));
        $total_device_mobile_mon_pre = (100 - $total_device_pc_mon_pre);
        ?>             
        <script>
            $(document).ready(function () {              
              draw_students_ages_diagram();     
              draw_students_ages_diagram_today();     
              draw_students_ages_diagram_weekend();
              draw_students_ages_diagram_month();
            });            
            function draw_students_ages_diagram_month(){
                var ctx = document.getElementById("chart-student-month");
                  var chart;
                  var dataDraw = {
                      'labels': ["PC (<?php echo $total_device_pc_mon_pre; ?> %)","Mobile (<?php echo $total_device_mobile_mon_pre; ?> %)"],
                      'values': ["<?php echo $total_device_pc_mon; ?>","<?php echo $total_device_mobile_mon; ?>"],
                      'colors': ["rgba(255, 159, 64, 0.2)", "rgb(54, 162, 235, 0.2)"],
                      'labelsCallback':["PC","Mobile"]          
                      };
                  return drawMap(dataDraw, chart, ctx);  
            }
            function draw_students_ages_diagram_weekend(){
                var ctx = document.getElementById("chart-student-age_weekend");
                  var chart;
                  var dataDraw = {
                      'labels': ["PC (<?php echo $total_device_tuan_pc_pre; ?> %)","Mobile (<?php echo $total_device_tuan_mobile_pre; ?> %)"],
                      'values': ["<?php echo $total_device_tuan_pc; ?>","<?php echo $total_device_tuan_mobile; ?>"],
                      'colors': ["rgba(75, 192, 192, 0.2)", "rgba(255, 159, 64, 0.2)"],
                      'labelsCallback':["PC","Mobile"]          
                      };
                  return drawMap(dataDraw, chart, ctx);  
              }
              function draw_students_ages_diagram_today(){
                var ctx = document.getElementById("chart-student-age_today");
                  var chart;
                  var dataDraw = {
                      'labels': ["PC (<?php echo $total_device_pc_per; ?> %)","Mobile (<?php echo $total_device_mobile_per; ?> %)"],
                      'values': ["<?php echo $total_device_pc; ?>","<?php echo $total_device_mobile; ?>"],
                      'colors': ["rgba(255, 99, 132, 0.2)", "rgba(75, 192, 192, 0.2)"],
                      'labelsCallback':["PC","Mobile"]          
                      };
                  return drawMap(dataDraw, chart, ctx);  
              }
      function draw_students_ages_diagram() {          
          window.chartColors = {
	            red: 'rgb(255, 99, 132,0.5)',
	            orange: 'rgb(255, 159, 64, 0.5)',
	            yellow: 'rgb(255, 205, 86, 0.5)',	
          };
          Chart.defaults.global.tooltips.custom = function(tooltip) {
          // Tooltip Element
          //var tooltipEl = document.getElementById('chartjs-tooltip');              
          // Hide if no tooltip
          /*if (tooltip.opacity === 0) {
              tooltipEl.style.opacity = 0;
              return;
          }*/
          // Set Text
          if (tooltip.body) {
              var total = 0;
              // get the value of the datapoint
              var value = this._data.datasets[tooltip.dataPoints[0].datasetIndex].data[tooltip.dataPoints[0].index].toLocaleString();
              // calculate value of all datapoints
              this._data.datasets[tooltip.dataPoints[0].datasetIndex].data.forEach(function(e) {
                  total += e;
              });
              // calculate percentage and set tooltip value
             // tooltipEl.innerHTML = '<h1>' + Math.round(value / total * 100) + '%</h1>';
          }
          // calculate position of tooltip
          var centerX = (this._chartInstance.chartArea.left + this._chartInstance.chartArea.right) / 2;
          var centerY = ((this._chartInstance.chartArea.top + this._chartInstance.chartArea.bottom) / 2);
          // Display, position, and set styles for font
          /*tooltipEl.style.opacity = 1;
          tooltipEl.style.left = centerX + 'px';
          tooltipEl.style.top = centerY + 'px';
          tooltipEl.style.fontFamily = tooltip._fontFamily;
          tooltipEl.style.fontSize = tooltip.fontSize;
          tooltipEl.style.fontStyle = tooltip._fontStyle;
          tooltipEl.style.padding = tooltip.yPadding + 'px ' + tooltip.xPadding + 'px';*/
        };
        var config = {
          type: 'doughnut',
          data: {
              datasets: [{
                data: [<?php echo $total_view_day ?>, <?php echo $total_view_tuan; ?>, <?php echo $total_view_mon; ?>],
                backgroundColor: [
                  window.chartColors.red,
                  window.chartColors.orange,
                  window.chartColors.yellow,       
                ],
              }],
              labels: [
                "Hôm nay (<?php echo $total_view_day; ?>)",
                "Tuần (<?php echo $total_view_tuan; ?>)",
                "Tháng (<?php echo $total_view_mon; ?>)",     
              ]
          },
          options: {
              responsive: true,
              legend: {
                display: true,
                labels: {
                  padding: 20
                },
              },
              tooltips: {
                enabled: false,
              }
        }
      };
      window.onload = function() {
          var ctx = document.getElementById("chart-area").getContext("2d");
          window.myPie = new Chart(ctx, config);
      };
    }      
    function drawMap(dataDraw, chart, ctx) {
        var labels = dataDraw.labels;
        var newData = dataDraw.values;
        var allColor = dataDraw.colors;
        var labelsCallback = dataDraw.labelsCallback;
        var color = [];
        for (i = 0; i < labels.length; i++) {
            color[i] = allColor[i];
        }

        if (dataDraw.borderColors != undefined)
            var borderColors = dataDraw.borderColors;
        else
            var borderColors = color;

        data = {
            labels: labels,

            datasets: [
                {
                    data: newData,
                    hoverBorderWidth: [0, 0, 0],
                    backgroundColor: color,
                    hoverBackgroundColor: color
                }],                
                
        };

        if (!chart === undefined)
            chart.destroy();

        var options = {
            tooltips: {
                callbacks: {
                    label: function (tooltipItem,data) {
                        return labelsCallback[tooltipItem.index];
                        //return data['labels'][tooltipItem['index']] + ': ' + data['datasets'][0]['data'][tooltipItem['index']] + '%';
                    }
                }
            },  
                      
        };


        chart = new Chart(ctx, {
            type: 'pie',
            data: data,
            options: options
        });

        return chart;
    }     
    </script>
<div id="chart-container">
  <div class="row">    
    <div class="col-md-2">
        Tin kiếm theo ngày
    </div>
    <div class="col-md-3">
        <input type="text" name="datetimes" id="datetimes" value="" />
    </div>
    <div class="col-md-1">
      <button id="submit_date" type="button" class="btn btn-primary">Tìm kiếm</button>      
    </div>
    <div class="col-md-1">
      <button type="button" class="btn btn-warning" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Thống kê theo giờ</button>      
    </div>
    <div class="clearfix"></div>
      <div id="load_tk">
          <div class="col-md-12">
            <div class="panel panel-default" style="border:1px solid #17a2b8;">
            <div class="panel-heading" style="background:#17a2b8;color:#fff;padding-left:10px;font-weight:bold;">Bài viết (<?php echo $CI->admin_model->getStaticAll()->num_rows(); ?>)</div>
              <div class="panel-body" style="padding:15px;">
                  <!-- Posts List -->
                  <div class="row">
                  <div class="col-lg-3">
                  <div class="form-group">                      
                      <select class="form-control" id="category_static">
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
                          <input type="text" class="form-control" name="title" id="title_static" aria-describedby="emailHelp" placeholder="Tiêu đề">                  
                        </div>
                      </div>
                      <div class="col-lg-1">
                        <div class="form-group">                  
                          <button type="button" class="btn btn-danger" id="click_tk">Tìm kiếm</button>                                        
                        </div>
                      </div>
                      <div class="col-lg-1">
                          <a href="<?php echo site_url('adminhp/export_artive'); ?>" id="export_excel" class="btn btn-success">Export Excel</a>   
                      </div>
                  </div>
                  <div id="ajax_content">                    
                    <?php                         
                        $config['base_url'] = site_url('adminhp/statistic_pagi');
                        $config['total_rows'] = $CI->admin_model->getStaticAll()->num_rows();
                        $config['per_page'] = 10;
                        $config['uri_segment'] = 3;
                        $choice = $config['total_rows'] / $config['per_page'];
                        $config['num_links'] = floor($choice);
                        $this->pagination->initialize($config);
                
                        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
                
                        // fetch employees list
                        $data['results'] = $CI->admin_model->getStatic($config['per_page'], $data['page']);       
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
                            $this->load->view('static_ajax', $data);
                        } else {
                            $this->load->view('list_static', $data);
                        }
                    ?>
                </div>
              </div>
            </div>
          </div>    
          <div class="col-md-6">

          </div>              
          <div class="clearfix"></div>
          <div class="col-md-6">
            <div class="panel panel-default" style="border:1px solid #f0645e;">
              <div class="panel-heading" style="background:#ff3547;color:#fff;padding-left:10px;font-weight:bold;">Lượt xem bài viết</div>
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
                        $this->db->where("DATE_FORMAT(date_day,'%Y-%m-%d')",date('Y-m-d'));
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
          <h4 class="modal-title" id="myLargeModalLabel">Thống kê theo giờ</h4>          
        </div>
        <div class="modal-body" style="height:unset;overflow-y:unset">
            <?php 
                //0H                
                if(isset($_SESSION['start_date']) && isset($_SESSION['end_date'])){
                  $tach_start_date = explode('',$_SESSION['start_date']);
                  var_dump($tach_start_date[0]);
                }else{
                    $count_no_oneh_start_date = date('Y-m-d')." 00:00";
                    $count_no_oneh_end_date = date('Y-m-d')." 00:59";
                }
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
                if(!empty($sql_post_count_3h)){
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
      </div><!--End #load_tk-->
  </div>        
</div>

    </div>
        </div>
    </div>
</section>     
<script src="backend/js/chartjs-plugin-datalabels.js"></script>
<canvas id="pie-chart"></canvas>
<?php       
    $sql_like = "select * from `tbladdress_ip_like` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d') = '".date('Y-m-d')."' ";
    $sql_like_ip = $this->db->query($sql_like);
    $total_like = $sql_like_ip->num_rows();    
    $sql_1 = "select SUM(view) as totalView from `tbladdress_ip_view` where `status`=1 and DATE_FORMAT(date_day,'%Y-%m-%d') = '".date('Y-m-d')."' ";
    $sql_view = $this->db->query($sql_1);    
    $total_view=$sql_view->row()->totalView;
    $this->db->where('status',1);
    $this->db->where("DATE_FORMAT(date_day,'%Y-%m-%d') =",date('Y-m-d'));
    $sql_visitor = $this->db->get('tbladdress_ip'); 
    $total_visitor = $sql_visitor->num_rows();   
    $data_label = '[';
    $data_label_number = '[';
    $this->db->where('status',1);       
    $this->db->where('parent_id',0);   
    $this->db->where('id !=',65); 
    $sql_category = $this->db->get('tblarticle_category');
    foreach($sql_category->result() as $item_category){
        $data_label.='"'.$item_category->category.'",';         
        $dem_sub = 0;
        $sql_2 = "select SUM(view) as totalView1 from `tbladdress_ip_view` where `status`=1 and `category_id`='".$item_category->id."' and DATE_FORMAT(date_day,'%Y-%m-%d') = '".date('Y-m-d')."' ";      
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
  labels: ['Lượt xem' + ' (<?php echo $total_view; ?>)', 'Like' + ' (<?php echo $total_like; ?>)','Visitor' + '(<?php echo $total_visitor; ?>)'],
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
<script>
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
  $('input[name="datetimes"]').daterangepicker({    
        autoUpdateInput: true,
        singleDatePicker: false,
        timePicker: true,
        minYear: 1901,
        timePicker24Hour: true,
        timePickerIncrement: 5,
        maxYear: parseInt(moment().format('YYYY'),10),
        ranges: {

        'Hôm nay': [moment(), moment()],

        'Hôm qua': [moment().subtract(1, 'days').startOf('days'), moment().subtract(1, 'days').endOf('days')],

        '7 ngày gần nhất': [moment().subtract(6, 'days').startOf('days'), moment().endOf('days')],

        '30 ngày gần nhất': [moment().subtract(29, 'days').startOf('days'), moment().endOf('days')],

        'Tháng này': [moment().startOf('month'), moment().endOf('month')],

        'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]

        },

        locale: {
          "format": "DD/MM/YYYY HH:mm",
          "separator": " - ",
          "applyLabel": "Áp dụng",
          "cancelLabel": "Đặt lại",
          "fromLabel": "Từ ngày",
          "toLabel": "Đến ngày",
          "customRangeLabel": "Tùy chỉnh ngày",
          "weekLabel": "Tuần",
          "daysOfWeek": [
              "CN",
              "T2",
              "T3",
              "T4",
              "T5",
              "T6",
              "T7"
          ],
          "monthNames": [
              "Tháng 1",
              "Tháng 2",
              "Tháng 3",
              "Tháng 4",
              "Tháng 5",
              "Tháng 6",
              "Tháng 7",
              "Tháng 8",
              "Tháng 9",
              "Tháng 10",
              "Tháng 11",
              "Tháng 12"

          ],
          "firstDay": 1
        },
        showDropdowns: false,
        alwaysShowCalendars: true,
        linkedCalendars: false,
        autoApply: false,
        autoUpdateInput: true
  });
  $("#submit_date").on('click',function(){
    var datetimes = $("#datetimes").val();  
    $.ajax({
        cache:false,
        type:"POST",
        data:{datetimes : datetimes},
        url:"<?php echo site_url('adminhp/doTimKiem/'); ?>", 
        success:function(html){            
            $("#load_tk").html(html);                  
        }                                                          
    }); 
  });
  $("#click_tk").on('click',function(){
    var category_static =$("#category_static").val();
    var title_static = $("#title_static").val();
    $.ajax({
        cache:false,
        type:"POST",
        data:{category_static : category_static,title_static : title_static},
        url:"<?php echo site_url('adminhp/doSearchListStatic/'); ?>", 
        success:function(html){            
            $("#ajax_content").html(html);                  
        }                                                          
    }); 
  });
});
</script>