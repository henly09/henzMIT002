<!DOCTYPE html>
<?php
include_once('../../../conn.php');
include_once('profile_back_end.php');
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
  <title>Profile</title><!--begin::Primary Meta Tags-->
  <link rel="icon" href="..\..\..\favicon.ico"><!--begin::Fonts-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous"><!--end::Fonts--><!--begin::Third Party Plugin(OverlayScrollbars)-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css" integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous"><!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Third Party Plugin(Bootstrap Icons)-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous"><!--end::Third Party Plugin(Bootstrap Icons)--><!--begin::Required Plugin(AdminLTE)-->
  <link rel="stylesheet" href="../../dist/css/adminlte.css"><!--end::Required Plugin(AdminLTE)--><!-- apexcharts -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css" integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0=" crossorigin="anonymous"><!-- jsvectormap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css" integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4=" crossorigin="anonymous">

  <!--Date Tange Picker-->
  <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
</head> <!--end::Head--> <!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary"> <!--begin::App Wrapper-->
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

            <li class="nav-item"> <a href="./admin.php" class="nav-link active"> <i class="nav-icon bi bi-speedometer"></i>
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
            <?php if ($_SESSION['role'] != "superadmin") : ?>
              <li class="nav-item"> <a href="./top_students.php" class="nav-link"> <i class="bi bi-star"></i>
                  <p>Top Students</p>
                </a> </li>
            <?php endif; ?>
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
    <main class="app-main"> <!--begin::App Content Header-->
      <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
          <div class="row">
            <div class="col-sm-6">
              <h3 class="mb-0">Profile</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="admin.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                  Profile
                </li>
              </ol>
            </div>
          </div> <!--end::Row-->
        </div> <!--end::Container-->
      </div> <!--end::App Content Header--> <!--begin::App Content-->
      <div class="app-content"> <!--begin::Container-->
        <div class="container-fluid d-flex justify-content-center">
          <div class="card w-50">
            <div class="card-header">
              <h3 class="card-title">Edit Profile</h3>
              <div class="card-tools">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->
                <span class="badge badge-primary">Label</span>
              </div>
              <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <form action="" method="post" id="save_changes">
              <div class="card-body">
                <div>
                  <input type="text" class="form-control" placeholder="Username" id="username" name="username">
                  <input type="password"
                    class="form-control mt-2"
                    placeholder="Password"
                    id="password"

                    name="password"
                    placeholder="Choose a Password"
                    enz-enable
                    enz-theme="default"
                    enz-min-password-strength="4"
                    enz-css-success-class="enz-success"
                    enz-css-fail-class="enz-fail" />
                  <input type="password" class="form-control mt-2" placeholder="Confirm Password" id="confirm_password" name="confirm_password">
                </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button class="btn btn-primary" name="submit" onclick="saveChanges()">Save Changes</button>
              </div>
            </form>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>
      </div> <!--end::App Content-->
    </main> <!--end::App Main--> <!--begin::Footer-->
    <footer class="app-footer"> <!--begin::To the end-->
      <div class="float-end d-none d-sm-inline"> <a href="#"> <strong> CDKK </strong></div></a> <strong>
        Assumption College of Davao 2023-2024
      </strong>
    </footer> <!--end::Footer-->
  </div> <!--end::App Wrapper--> <!--begin::Script--> <!--begin::Third Party Plugin(OverlayScrollbars)-->
  <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js" integrity="sha256-H2VM7BKda+v2Z4+DRy69uknwxjyDRhszjXFhsL4gD3w=" crossorigin="anonymous"></script> <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha256-whL0tQWoY1Ku1iskqPFvmZ+CHsvmRWx/PIoEvIeWh4I=" crossorigin="anonymous"></script> <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha256-YMa+wAM6QkVyz999odX7lPRxkoYAan8suedu4k2Zur8=" crossorigin="anonymous"></script> <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
  <script src="../../dist/js/adminlte.js"></script> <!--end::Required Plugin(AdminLTE)-->

  <!-- Sweet Alert 2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="profile.js"></script>

  <!-- Enzoic -->
  <script type="text/javascript"
    src="https://cdn.enzoic.com/js/enzoic.min.js">
  </script>
</body>

</html>
