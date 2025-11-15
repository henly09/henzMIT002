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
  <title>Users</title><!--begin::Primary Meta Tags-->
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

  <link rel="stylesheet" href="./users.css">

  <style>
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }
  </style>
</head> <!--end::Head--> <!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary"> <!--begin::App Wrapper-->
  <div class="modal fade" id="add_user_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
        </div>
        <form action="#" method="post" id="add_user_form">
          <div class="modal-body">
            <div class="input-group mb-3">
              <span class="input-group-text">ID</span>
              <input type="text" class="form-control" placeholder="Enter here" name="id" id="id">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text">Full Name</span>
              <input type="text" class="form-control" placeholder="First Name" name="first_name" id="first_name">
              <input type="text" class="form-control" placeholder="Last Name" name="last_name" id="last_name">
            </div>
            <div class="row mb-3">
              <div class="col-4">
                <div class="input-group">
                  <span class="input-group-text">Age</span>
                  <input type="number" class="form-control" min="0" placeholder="18" name="age" id="age">
                </div>
              </div>
              <div class="col">
                <div class="input-group">
                  <span class="input-group-text">Gender</span>
                  <select name="gender" id="gender" class="form-select">
                    <option default selected disabled>Select Here</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Others">Others</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text">Category</span>
              <input type="text" class="form-control" placeholder="Enter Here" name="category" id="category">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text">Department</span>
              <input type="text" class="form-control" placeholder="Enter Here" name="department" id="department">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text">Grade Level</span>
              <input type="text" class="form-control" placeholder="Enter Here" name="grade_level" id="grade_level">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text">Section</span>
              <input type="text" class="form-control" placeholder="Enter Here" name="section" id="section">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="add_user">Add User</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="bulk_import_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Bulk Import (.csv)</h5>
        </div>
        <form action="#" method="post" id="bulk_import_form">
          <div class="modal-body">
            <span class="h6">Columns must be in this structure: </span>
            <br>
            <span>| Student ID > Full Name > Age > Gender > Category > Department > Grade Level > Section |</span>
            <div class="input-group mb-3 mt-1">
              <input type="file" class="form-control" name="file" id="file" accept=".csv">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="bulk_import">Import</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="edit_user_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel2">Edit User</h5>
        </div>
        <form action="#" method="post" id="edit_user_form">
          <div class="modal-body">
            <div class="input-group mb-3">
              <span class="input-group-text">ID</span>
              <input type="text" class="form-control" placeholder="Enter here" name="id" id="edit_id">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text">Full Name</span>
              <input type="text" class="form-control" placeholder="First Name" name="first_name" id="edit_first_name">
              <input type="text" class="form-control" placeholder="Last Name" name="last_name" id="edit_last_name">
            </div>
            <div class="row mb-3">
              <div class="col-4">
                <div class="input-group">
                  <span class="input-group-text">Age</span>
                  <input type="number" class="form-control" min="0" placeholder="18" name="age" id="edit_age">
                </div>
              </div>
              <div class="col">
                <div class="input-group">
                  <span class="input-group-text">Gender</span>
                  <select name="gender" id="edit_gender" class="form-select">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Others">Others</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text">Category</span>
              <input type="text" class="form-control" placeholder="Enter Here" name="category" id="edit_category">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text">Department</span>
              <input type="text" class="form-control" placeholder="Enter Here" name="department" id="edit_department">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text">Grade Level</span>
              <input type="text" class="form-control" placeholder="Enter Here" name="grade_level" id="edit_grade_level">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text">Section</span>
              <input type="text" class="form-control" placeholder="Enter Here" name="section" id="edit_section">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="edit_user">Save Changes</button>
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
              <li class="nav-item"> <a href="./users.php" class="nav-link active"> <i class="nav-icon bi bi-person-fill"></i>
                  <p>Users</p>
                </a> </li>
            <?php endif; ?>
            <li class="nav-item"> <a href="./activities.php" class="nav-link"> <i class="nav-icon bi bi-list-ul"></i>
                <p>Activity</p>
              </a> </li>
            <?php if ($_SESSION['role'] == "superadmin") : ?>
              <li class="nav-item"> <a href="./staff.php" class="nav-link"> <i class="nav-icon bi bi-person-fill-lock"></i>
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
      <div class="app-content">
        <div class="app-content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="card p-3">
                <table class="table table-bordered table-striped table-responsive w-100" id="students-table">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>First Name</th>
                      <th>Last Name</th>
                      <th>Age</th>
                      <th>Gender</th>
                      <th>Category</th>
                      <th>Department</th>
                      <th>Grade Level</th>
                      <th>Section</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
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
  <script src="./users.js"></script>
</body><!--end::Body-->

</html>
