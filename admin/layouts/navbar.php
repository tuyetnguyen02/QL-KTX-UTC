<?php 
$sql_semester = "SELECT * FROM semester WHERE status = true";
$semester = mysqli_query($conn, $sql_semester)->fetch_assoc();

//$currentDate = new DateTime(); // lấy thời gian tại thời điểm hiện tại
$start_date = (new DateTime($semester['start_date']))->format('Y-m-d');

$sql_feedback = "SELECT * FROM feedback f INNER JOIN material m ON f.material_id = m.material_id 
INNER JOIN room r ON f.room_id = r.room_id
INNER JOIN student s ON s.student_id = f.student_id
WHERE send_date >= '".$start_date."' AND f.status = 0";
$feedback = mysqli_query($conn, $sql_feedback);

?>
<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
    <a class="navbar-brand brand-logo" href="index.php"><img src="../image/logo/logo_utc.png" alt="logo" /></a>
    <a class="navbar-brand brand-logo-mini" href="index.php"><img src="../image/logo/Logo-UTC.png" alt="logo" /></a>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-stretch">
    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
      <span class="mdi mdi-menu"></span>
    </button>
    <div class="search-field d-none d-xl-block">
      <form class="d-flex align-items-center h-100" action="#">
        <div class="input-group">
          <div class="input-group-prepend bg-transparent">
            <i class="input-group-text border-0 mdi mdi-magnify"></i>
          </div>
          <input type="text" class="form-control bg-transparent border-0" placeholder="Search products">
        </div>
      </form>
    </div>
    <ul class="navbar-nav navbar-nav-right">
      <li class="nav-item  dropdown d-none d-md-block">
        <a class="nav-link dropdown-toggle" id="reportDropdown" href="#" data-toggle="dropdown" aria-expanded="false"> Reports </a>
        <div class="dropdown-menu navbar-dropdown" aria-labelledby="reportDropdown">
          <a class="dropdown-item" href="#">
            <i class="mdi mdi-file-pdf mr-2"></i>PDF </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">
            <i class="mdi mdi-file-excel mr-2"></i>Excel </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">
            <i class="mdi mdi-file-word mr-2"></i>doc </a>
        </div>
      </li>
      <li class="nav-item  dropdown d-none d-md-block">
        <a class="nav-link dropdown-toggle" id="projectDropdown" href="#" data-toggle="dropdown" aria-expanded="false"> Projects </a>
        <div class="dropdown-menu navbar-dropdown" aria-labelledby="projectDropdown">
          <a class="dropdown-item" href="#">
            <i class="mdi mdi-eye-outline mr-2"></i>View Project </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">
            <i class="mdi mdi-pencil-outline mr-2"></i>Edit Project </a>
        </div>
      </li>
      <li class="nav-item nav-language dropdown d-none d-md-block">
        <a class="nav-link dropdown-toggle" id="languageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
          <div class="nav-language-icon">
            <i class="flag-icon flag-icon-us" title="us" id="us"></i>
          </div>
          <div class="nav-language-text">
            <p class="mb-1 text-black">English</p>
          </div>
        </a>
        <div class="dropdown-menu navbar-dropdown" aria-labelledby="languageDropdown">
          <a class="dropdown-item" href="#">
            <div class="nav-language-icon mr-2">
              <i class="flag-icon flag-icon-ae" title="ae" id="ae"></i>
            </div>
            <div class="nav-language-text">
              <p class="mb-1 text-black">Arabic</p>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">
            <div class="nav-language-icon mr-2">
              <i class="flag-icon flag-icon-gb" title="GB" id="gb"></i>
            </div>
            <div class="nav-language-text">
              <p class="mb-1 text-black">English</p>
            </div>
          </a>
        </div>
      </li>
      <li class="nav-item nav-profile dropdown">
        <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
          <div class="nav-profile-img">
            <img src="<?php echo $admin['image'];?>" alt="image">
          </div>
          <div class="nav-profile-text">
            <p class="mb-1 text-black"><?php echo $admin['admin_name'];?></p>
          </div>
        </a>
        <div class="dropdown-menu navbar-dropdown dropdown-menu-right p-0 border-0 font-size-sm" aria-labelledby="profileDropdown" data-x-placement="bottom-end">
          <div class="p-3 text-center bg-primary">
            <img class="img-avatar img-avatar48 img-avatar-thumb" src="<?php echo $admin['image'];?>" alt="">
          </div>
          <div class="p-2">
            <h5 class="dropdown-header text-uppercase pl-2 text-dark">User Options</h5>
            <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="#">
              <span>Inbox</span>
              <span class="p-0">
                <span class="badge badge-primary">3</span>
                <i class="mdi mdi-email-open-outline ml-1"></i>
              </span>
            </a>
            <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="thong_tin_admin.php">
              <span>Profile</span>
              <span class="p-0">
                <span class="badge badge-success">1</span>
                <i class="mdi mdi-account-outline ml-1"></i>
              </span>
            </a>
            <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="javascript:void(0)">
              <span>Settings</span>
              <i class="mdi mdi-settings"></i>
            </a>
            <div role="separator" class="dropdown-divider"></div>
            <h5 class="dropdown-header text-uppercase  pl-2 text-dark mt-2">Actions</h5>
            <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="#">
              <span>Lock Account</span>
              <i class="mdi mdi-lock ml-1"></i>
            </a>
            <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="dang_xuat.php">
              <span>Log Out</span>
              <i class="mdi mdi-logout ml-1"></i>
            </a>
          </div>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
          <i class="mdi mdi-email-outline"></i>
          <span class="count-symbol bg-success"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
          <h6 class="p-3 mb-0 bg-primary text-white py-4">Messages</h6>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <img src="assets/images/faces/face4.jpg" alt="image" class="profile-pic">
            </div>
            <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
              <h6 class="preview-subject ellipsis mb-1 font-weight-normal">Mark send you a message</h6>
              <p class="text-gray mb-0"> 1 Minutes ago </p>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <img src="assets/images/faces/face2.jpg" alt="image" class="profile-pic">
            </div>
            <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
              <h6 class="preview-subject ellipsis mb-1 font-weight-normal">Cregh send you a message</h6>
              <p class="text-gray mb-0"> 15 Minutes ago </p>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <img src="assets/images/faces/face3.jpg" alt="image" class="profile-pic">
            </div>
            <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
              <h6 class="preview-subject ellipsis mb-1 font-weight-normal">Profile picture updated</h6>
              <p class="text-gray mb-0"> 18 Minutes ago </p>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          <h6 class="p-3 mb-0 text-center">4 new messages</h6>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
          <i class="mdi mdi-bell-outline"></i>
          <span class="count-symbol <?php if(isset($feedback)) echo 'bg-danger';else echo 'bg-success'?>"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
          <h6 class="p-3 mb-0 bg-primary text-white py-4">Thông báo sửa chữa</h6>
          <div class="dropdown-divider"></div>
          <?php 
            $i = 0;
            if(isset($feedback)){
              while($row = $feedback->fetch_assoc()){ if ($i > 2){$i = $feedback->num_rows; break;} ?>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-warning">
                      <i class="mdi mdi-wrench"></i>
                    </div>
                  </div>
                  <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                    <h6 class="preview-subject font-weight-normal mb-1"> <?php echo $row['room_name'];?> </h6>
                    <p class="text-gray ellipsis mb-0"> <?php echo $row['material_name'];?> </p>
                  </div>
                </a>
              <?php $i++;} } ?>
          
          <!-- <div class="dropdown-divider"></div>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <div class="preview-icon bg-success">
                <i class="mdi mdi-settings"></i>
              </div>
            </div>
            <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
              <h6 class="preview-subject font-weight-normal mb-1">Settings</h6>
              <p class="text-gray ellipsis mb-0"> Update dashboard </p>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <div class="preview-icon bg-info">
                <i class="mdi mdi-link-variant"></i>
              </div>
            </div>
            <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
              <h6 class="preview-subject font-weight-normal mb-1">Launch Admin</h6>
              <p class="text-gray ellipsis mb-0"> New admin wow! </p>
            </div>
          </a> -->
          <div class="dropdown-divider"></div>
          <h6 class="p-3 mb-0 text-center"><a href="sua_chua_vat_chat.php">(<?php echo $i;?>) Tất cả thông báo</a></h6>
        </div>
      </li>
    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="mdi mdi-menu"></span>
    </button>
  </div>
</nav>