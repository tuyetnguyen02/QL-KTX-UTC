<?php require(__DIR__.'/layouts/header.php'); ?> 
<?php 
// Học kì đang hoạt động
$sql_semester = "SELECT * FROM semester WHERE status = true";
$semester = mysqli_query($conn, $sql_semester)->fetch_assoc();
// tổng số slot dành cho sinh viên
$sql_maxquantity = "SELECT SUM(rt.max_quantity * room_count.num_rooms) AS total_capacity 
                    FROM room_type rt 
                    LEFT JOIN ( SELECT room_type_id, COUNT(room_id) AS num_rooms 
                                FROM room GROUP BY room_type_id ) room_count ON rt.room_type_id = room_count.room_type_id;";
$maxquantity = mysqli_query($conn, $sql_maxquantity)->fetch_assoc();
// tổng số sinh viên đăng kí theo loại phòng MẢNG 3 CHIỀU
$sql_sum_sv_roomtype = "SELECT rt.room_type_id, rt.room_type_name, COUNT(r.room_id) * rt.max_quantity AS total_capacity, COALESCE(COUNT(c.student_id), 0) AS num_students_registered FROM room_type rt LEFT JOIN room r ON rt.room_type_id = r.room_type_id LEFT JOIN contract c ON r.room_id = c.room_id AND c.status = 'true' GROUP BY rt.room_type_id, rt.room_type_name, rt.max_quantity;";
$sum_sv_roomtype = mysqli_query($conn, $sql_sum_sv_roomtype);
$data_roomtype = [];
while($row = mysqli_fetch_array($sum_sv_roomtype)){
  $data_roomtype[] = $row;
}
// echo "<pre>"; 
// var_dump($data_roomtype);
// echo "</pre>";

//tính số lượng phòng theo loại phòng
$sql_sum_room_inroomtype = "SELECT rt.room_type_name, COALESCE(COUNT(r.room_id), 0) AS number_room FROM room_type rt INNER JOIN room r ON rt.room_type_id = r.room_type_id GROUP BY room_type_name;";
$sum_room_inroomtype = mysqli_query($conn, $sql_sum_room_inroomtype); 
$data = [];
while($row = mysqli_fetch_array($sum_room_inroomtype)){
  $data[] = $row;
}
// echo "<pre>"; //check data
// var_dump($data);
// echo "</pre>";
// tổng số sv đã đăng kí
$sum_sv_dadangky = "SELECT COUNT(contract_id) AS total_students_registered FROM contract WHERE semester_id = '".$semester['semester_id']."';";

$sv_dadangky = mysqli_query($conn, $sum_sv_dadangky)->fetch_assoc();

//tổng số sinh viên đã đăng kí dịch vụ gửi xe máy
$sql_services_guixemay = "SELECT * FROM services WHERE services_name = 'Gửi xe máy'";
$services_guixemay = mysqli_query($conn, $sql_services_guixemay)->fetch_assoc();
$sql_sum_xemay = "SELECT COUNT(DISTINCT r.student_id) AS xemay FROM register_services r  
                  WHERE r.semester_id = '".$semester['semester_id']."' AND r.services_id = '".$services_guixemay['services_id']."'";
$sum_xemay =  mysqli_query($conn, $sql_sum_xemay)->fetch_assoc();

//tổng số sinh viên đã đăng kí dịch vụ gửi xe đạp
$sql_services_guixedap = "SELECT * FROM services WHERE services_name = 'Gửi xe đạp'";
$services_guixedap = mysqli_query($conn, $sql_services_guixedap)->fetch_assoc();
$sql_sum_xedap = "SELECT COUNT(DISTINCT r.student_id) AS xedap FROM register_services r  
                  WHERE r.semester_id = '".$semester['semester_id']."' AND r.services_id = '".$services_guixedap['services_id']."'";
$sum_xedap =  mysqli_query($conn, $sql_sum_xedap)->fetch_assoc();

//tổng số sinh viên đã đăng kí dịch vụ dọn vệ sinh
$sql_services_vesinh = "SELECT * FROM services WHERE services_name = 'Vệ sinh khu vực'";
$services_vesinh = mysqli_query($conn, $sql_services_vesinh)->fetch_assoc();
$sql_sum_vesinh = "SELECT COUNT(DISTINCT r.student_id) AS vesinh FROM register_services r  
                  WHERE r.semester_id = '".$semester['semester_id']."' AND r.services_id = '".$services_vesinh['services_id']."'";
$sum_vesinh =  mysqli_query($conn, $sql_sum_vesinh)->fetch_assoc();


//echo $maxquantity['total_capacity'];
?>

<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper" >
        <div class="col-lg-12 grid-margin stretch-card" style="overflow: auto;">
            <!-- <div class="card"> -->
                <div class="card-body">
                    <div class="page-header">
                        <h3 class="page-title"> THỐNG KÊ </h3>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="col-xl-3 col-lg-6 col-sm-6 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h5 class="mb-2 text-dark font-weight-normal">Số lượng sinh viên đăng ký ở</h5>
                                        <h2 class="mb-4 text-dark font-weight-bold">932.00</h2>
                                        <div id="sv_dangky">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-sm-6 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h5 class="mb-2 text-dark font-weight-normal">Tỷ lệ SV sử dụng DV gửi xe máy</h5>
                                        <h2 class="mb-4 text-dark font-weight-bold">756,00</h2>
                                        <div id="dv_xemay">
                                                
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3  col-lg-6 col-sm-6 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h5 class="mb-2 text-dark font-weight-normal">Tỷ lệ SV sử dụng DV gửi xe đạp</h5>
                                        <h2 class="mb-4 text-dark font-weight-bold">100,38</h2>
                                        <div id="dv_xedap">
                                                    
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-sm-6 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h5 class="mb-2 text-dark font-weight-normal">Tỷ lệ SV sử dụng DV dọn vệ sinh</h5>
                                        <h2 class="mb-4 text-dark font-weight-bold">4250k</h2>
                                        <div id="dv_vesinh">
                                                    
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                                
                    </div>
                    <div class="row">
                      <div class="col-sm-4 grid-margin stretch-card">
                        <div class="card card-danger-gradient">
                          <div class="card-body mb-4">
                            <h4 class="card-title">Số lượng phòng từng loại phòng</h4>
                            <div id="donutchart" style="width: 350px; height: 400px;">
                                
                            </div>
                          </div>
                          <!-- <div class="card-body bg-white pt-4">
                            <div class="row pt-4">
                              <div class="col-sm-6">
                                <div class="text-center border-right border-md-0">
                                  <h4>Conversion</h4>
                                  <h1 class="text-dark font-weight-bold mb-md-3">$306</h1>
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <div class="text-center">
                                  <h4>Cancellation</h4>
                                  <h1 class="text-dark font-weight-bold">$1,520</h1>
                                </div>
                              </div>
                            </div>
                          </div> -->
                        </div>
                      </div>
                      <div class="col-sm-8  grid-margin stretch-card">
                        <div class="card">
                          <div class="card-body">
                            <div class="d-xl-flex justify-content-between mb-2">
                              <h4 class="card-title">Thống kê tổng quát sinh viên đăng ký phòng</h4>
                              <div class="graph-custom-legend primary-dot" id="pageViewAnalyticLengend"></div>
                            </div>
                            <div id="roomtype">

                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                </div>
            <!-- </div> -->
        </div>
    </div>


    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['room_type_name', 'number_room'],
          <?php 
          foreach($data as $key){
            echo "['". $key['room_type_name'] ."', ". $key['number_room'] ."],";
          }
          ?>
          // ['Work',     11],
          // ['Eat',      2],
          // ['Commute',  2],
          // ['Watch TV', 2],
          // ['Sleep',    7]
        ]);

        var options = {
        //   title: 'My Daily Activities',
            legend: 'none',
            pieSliceText: 'label',
            pieHole: 0.4,
        };
        // function drawChart() {
        // var data = google.visualization.arrayToDataTable([
        //   ['Task', 'Hours per Day'],
        //   ['Work',     11],
        //   ['Eat',      2],
        //   ['Commute',  2],
        //   ['Watch TV', 2],
        //   ['A7',  1],
        //   ['A5', 10],
        //   ['Sleep',    7]
        // ]);

        // var options = {
        //   // title: 'My Daily Activities',
        //   pieHole: 0.4,
        // };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
    </script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Language', 'Speakers (in millions)'],
          ['Đã đăng ký',  <?php echo $sv_dadangky['total_students_registered'];?>],
          ['Còn trống',  <?php echo $maxquantity['total_capacity'] - $sv_dadangky['total_students_registered'];?>]
        ]);

      var options = {
        legend: 'none',
        pieSliceText: 'label',
        // title: 'Swiss Language Use (100 degree rotation)',
        pieStartAngle: 0,
      };

        var chart = new google.visualization.PieChart(document.getElementById('sv_dangky'));
        chart.draw(data, options);
      }
    </script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Language', 'Speakers (in millions)'],
          ['Đã đăng ký',  <?php echo $sum_xemay['xemay'];?>],
          ['Không đăng ký',  <?php echo ($sv_dadangky['total_students_registered'] - $sum_xemay['xemay']);?>]
        ]);

      var options = {
        legend: 'none',
        pieSliceText: 'label',
        // title: 'Swiss Language Use (100 degree rotation)',
        pieStartAngle: 0,
      };

        var chart = new google.visualization.PieChart(document.getElementById('dv_xemay'));
        chart.draw(data, options);
      }
    </script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Language', 'Speakers (in millions)'],
          ['Đã đăng ký',  <?php echo $sum_xedap['xedap'];?>],
          ['Không đăng ký', <?php echo ($sv_dadangky['total_students_registered'] - $sum_xedap['xedap']);?>]
        ]);

      var options = {
        legend: 'none',
        pieSliceText: 'label',
        // title: 'Swiss Language Use (100 degree rotation)',
        pieStartAngle: 0,
      };

        var chart = new google.visualization.PieChart(document.getElementById('dv_xedap'));
        chart.draw(data, options);
      }
    </script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Language', 'Speakers (in millions)'],
          ['Đã đăng ký',  <?php echo $sum_vesinh['vesinh'];?>],
          ['Không đăng ký',  <?php echo ($sv_dadangky['total_students_registered'] - $sum_vesinh['vesinh']);?>]
        ]);

      var options = {
        legend: 'none',
        pieSliceText: 'label',
        // title: 'Swiss Language Use (100 degree rotation)',
        pieStartAngle: 0,
      };

        var chart = new google.visualization.PieChart(document.getElementById('dv_vesinh'));
        chart.draw(data, options);
      }
    </script>
    <script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
        ['Tên loại phòng', 'SV đã đăng ký', 'Chỗ trống', { role: 'annotation' } ],
         <?php 
          foreach($data_roomtype as $key){
            echo "['". $key['room_type_name'] ."', ". $key['num_students_registered'] .",". $key['total_capacity'] .",''],";
          }
          ?>

        // ['2010', 10, 24, 20, 32, 18, 5, ''],
        // ['2020', 16, 22, 23, 30, 16, 9, ''],
        // ['2030', 28, 19, 29, 30, 12, 13, '']
      ]);

      var view = new google.visualization.DataView(data);

     var options = {
        // width: 600,
         height: 400,
        legend: { position: 'top', maxLines: 3 },
        bar: { groupWidth: '75%' },
        isStacked: true,
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("roomtype"));
      chart.draw(view, options);
    }
    </script>
<?php require(__DIR__.'/layouts/footer.php'); ?> 