<!DOCTYPE html>
<?php
include_once('../../../conn.php');
?>
<?php
if (!isset($_SESSION['loggedin'])) {
  header('Location: index.php');
  exit;
}
?>
<html lang="en"> <!--begin::Head-->

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Staff</title><!--begin::Primary Meta Tags-->
  <link rel="icon" href="..\..\..\favicon.ico"><!--begin::Fonts-->
  <link rel="stylesheet" href="../css/fonts/index.css"><!--end::Fonts--><!--begin::Third Party Plugin(OverlayScrollbars)-->
  <link rel="stylesheet" href="../css/overlayscrollbars/overlayscrollbars.min.css"><!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Third Party Plugin(Bootstrap Icons)-->
  <link rel="stylesheet" href="../../dist/css/adminlte.css"><!--end::Required Plugin(AdminLTE)--><!-- apexcharts -->

  <!-- Fetched from NPM kay dili mu gana ang manual approach -->
  <link rel="stylesheet" href="../../../node_modules/bootstrap-icons/font/bootstrap-icons.min.css"><!--end::Third Party Plugin(Bootstrap Icons)--><!--begin::Required Plugin(AdminLTE)-->

  <!-- apexcharts -->
  <link rel="stylesheet" href="../css/apexcharts/apexcharts.css">

  <!-- jsvectormap -->
  <link rel="stylesheet" href="../css/jsvectormap/jsvectormap.min.css">

  <!-- datatables -->
  <link href="../css/datatables/datatables.min.css" rel="stylesheet">

  <style>
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }
  </style>
</head> <!--end::Head--> <!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary"> <!--begin::App Wrapper-->
  <div class="modal fade" id="add_staff_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Staff</h5>
        </div>
        <form action="#" method="post" id="add_staff_form">
          <div class="modal-body">
            <div class="input-group mb-3">
              <span class="input-group-text">Username</span>
              <input type="text" class="form-control" placeholder="Enter here" name="username" id="username">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text">Password</span>
              <input type="text" class="form-control" placeholder="Enter Here" name="password" id="password">
            </div>
            <div class="input-group mb-3">
              <label class="input-group-text" for="inputGroupSelect01">Role</label>
              <select class="form-select" id="role" name="role">
                <option selected disabled>Enter here</option>
                <option value="college">College</option>
                <option value="senior_high">Senior High School</option>
                <option value="junior_high">Junior High School</option>
                <option value="elementary">Elementary</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="add_staff">Add Staff</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="edit_staff_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel2">Edit Staff</h5>
        </div>
        <form action="#" method="post" id="edit_staff_form">
          <div class="modal-body">
            <div class="input-group mb-3">
              <span class="input-group-text">ID</span>
              <input type="text" class="form-control" placeholder="Enter here" name="id" id="edit_id">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text">Username</span>
              <input type="text" class="form-control" placeholder="Enter here" name="username" id="edit_username">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text">Password</span>
              <input type="text" class="form-control" placeholder="Enter Here" name="password" id="edit_password">
            </div>
            <div class="input-group mb-3">
              <label class="input-group-text" for="inputGroupSelect01">Role</label>
              <select class="form-select" id="edit_role" name="role">
                <option selected disabled>Enter here</option>
                <option value="college">College</option>
                <option value="senior_high">Senior High School</option>
                <option value="junior_high">Junior High School</option>
                <option value="elementary">Elementary</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="edit_staff">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="app-wrapper"> <!--begin::Header-->
    <nav class="app-header navbar navbar-expand bg-body"> <!--begin::Container-->
      <div class="container-fluid"> <!--begin::Start Navbar Links-->
        <ul class="navbar-nav">
          <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"> <i class="bi bi-list"></i> </a> </li>
        </ul> <!--end::Start Navbar Links--> <!--begin::End Navbar Links-->
        <ul class="navbar-nav ms-auto"> <!--begin::Fullscreen Toggle-->
          <li class="nav-item"> <a class="nav-link" href="#" data-lte-toggle="fullscreen"> <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i> <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none;"></i> </a> </li> <!--end::Fullscreen Toggle--> <!--begin::User Menu Dropdown-->
          <li class="nav-item dropdown user-menu"> <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"> <img src="../../dist/assets/img/AdminLTELogo.png" class="user-image rounded-circle " alt="User Image"> <span class="d-none d-md-inline">
                <?php
                switch ($_SESSION['role']) {
                  case 'superadmin':
                    echo 'Administator';
                    break;
                  case 'college':
                    echo 'College';
                    break;
                  case 'senior_high':
                    echo 'Senior High School';
                    break;
                  case 'junior_high':
                    echo 'Junior High School';
                    break;
                  case 'elementary':
                    echo 'elementary';
                    break;
                }
                ?>
              </span> </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end"> <!--begin::User Image-->
              <li class="user-header text-bg-primary"> <img src="../../dist/assets/img/AdminLTELogo.png" class="rounded-circle shadow" alt="User Image">
                <p>
                  <?php echo $_SESSION['name'] ?>
                </p>
              </li> <!--end::User Image--> <!--begin::Menu Footer-->
              <li class="user-footer"> <a href="profile.php" class="btn btn-default btn-flat">Profile</a> <a href="log_out.php" class="btn btn-default btn-flat float-end">Sign out</a> </li> <!--end::Menu Footer-->
            </ul>
          </li> <!--end::User Menu Dropdown-->
        </ul> <!--end::End Navbar Links-->
      </div> <!--end::Container-->
    </nav> <!--end::Header--> <!--begin::Sidebar-->
    <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark"> <!--begin::Sidebar Brand-->
      <div class="sidebar-brand"> <!--begin::Brand Link--> <a href="./admin.php" class="brand-link"> <!--begin::Brand Image--><img src="../../../Images/logo-icon.png" alt="PiStamp Logo" class="brand-image opacity-75 shadow">
          <span class="brand-text fw-light">PiStamp</span> <!--end::Brand Text--> </a> <!--end::Brand Link--> </div> <!--end::Sidebar Brand--> <!--begin::Sidebar Wrapper-->
      <div class="sidebar-wrapper">
        <nav class="mt-2"> <!--begin::Sidebar Menu-->
          <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">

            <li class="nav-item"> <a href="./admin.php" class="nav-link"> <i class="nav-icon bi bi-speedometer"></i>
                <p>Dashboard</p>
              </a> </li>
            <?php if ($_SESSION['role'] == "superadmin") : ?>
              <li class="nav-item"> <a href="./users.php" class="nav-link"> <i class="nav-icon bi bi-person-fill"></i>
                  <p>Users</p>
                </a> </li>
            <?php endif; ?>
            <li class="nav-item"> <a href="./activities.php" class="nav-link"> <i class="nav-icon bi bi-list-ul"></i>
                <p>Activity</p>
              </a> </li>
            <?php if ($_SESSION['role'] == "superadmin") : ?>
              <li class="nav-item"> <a href="./staff.php" class="nav-link active"> <i class="nav-icon bi bi-person-fill-lock"></i>
                  <p>Staff</p>
                </a> </li>
            <?php endif; ?>
            <li class="nav-item"> <a href="../../../index.php" class="nav-link"> <i class="bi bi-box-arrow-left"></i>
                <p>Front Page</p>
              </a> </li>
          </ul> <!--end::Sidebar Menu-->
        </nav>
      </div> <!--end::Sidebar Wrapper-->
    </aside> <!--end::Sidebar--> <!--begin::App Main-->
    <main class="app-main"> <!--begin::App Content Header--> <!--begin::App Content-->
      <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
          <div class="row">
            <div class="col-sm-6">
              <h3 class="mb-0">Staffs</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="admin.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                  Staffs
                </li>
              </ol>
            </div>
          </div> <!--end::Row-->
        </div> <!--end::Container-->
      </div>
      <div class="app-content">
        <div class="app-content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="card p-3">
                <table class="table table-bordered table-striped table-responsive w-100" id="students-table">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Username</th>
                      <th>Password</th>
                      <th>Role</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main> <!--end::App Main--> <!--begin::Footer-->
    <footer class="app-footer"> <!--begin::To the end-->
      <div class="float-end d-none d-sm-inline"> <a href="https://www.facebook.com/PARZIV4L77"> <strong> PARZIV4L </strong></div></a> <strong>
        PiStamp (Assumption College of Davao)
      </strong>
    </footer> <!--end::Footer-->
  </div> <!--end::App Wrapper--> <!--begin::Script--> <!--begin::Third Party Plugin(OverlayScrollbars)-->
  <script src="../js/jquery/jquery-3.7.1.js"></script>
  <script src="../js/overlayscrollbars/overlayscrollbars.browser.es6.min.js"></script> <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
  <script src="../js/popper/popper.min.js"></script> <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
  <script src="../js/bootstrap/bootstrap.min.js"></script> <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
  <script src="../../dist/js/adminlte.js"></script> <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->

  <!-- Ambot asa ni gikan probably datatables -->
  <script src="../js/datatables/pdfmake.min.js"></script>
  <script src="../js/datatables/vfs_fonts.js"></script>
  <script src="../js/datatables/datatables.min.js"></script>

  <!-- Sweet Alert -->
  <script src="../js/sweetalert/swal.js"></script>

  <script src="../../node_modules/datatables.net-plugins/dataRender/ellipsis.min.js"></script>
  <script src="staff.js"></script>
</body><!--end::Body-->

</html>
