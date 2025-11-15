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
  <title>PiStamp Dashboard</title><!--begin::Primary Meta Tags-->
  <link rel="icon" href="..\..\..\favicon.ico">
  <!--begin::Fonts--><!--end::Fonts--><!--begin::Third Party Plugin(OverlayScrollbars)-->
  <link rel="stylesheet" href="../css/overlayscrollbars/overlayscrollbars.min.css">
  <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Third Party Plugin(Bootstrap Icons)-->
  <link rel="stylesheet" href="../../dist/css/adminlte.css"><!--end::Required Plugin(AdminLTE)--><!-- apexcharts -->

  <!-- Fetched from NPM kay dili mu gana ang manual approach -->
  <link rel="stylesheet" href="../../../node_modules/bootstrap-icons/font/bootstrap-icons.min.css">
  <!--end::Third Party Plugin(Bootstrap Icons)--><!--begin::Required Plugin(AdminLTE)-->

  <link rel="stylesheet" href="../css/apexcharts/apexcharts.css"><!-- jsvectormap -->
  <link rel="stylesheet" href="../css/jsvectormap/jsvectormap.min.css">

  <style>
    .truncate {
      white-space: nowrap;
      /* Prevent wrapping */
      overflow: hidden;
      /* Hide overflowing text */
      text-overflow: ellipsis;
      /* Add ellipsis (...) */
      max-width: 150px;
      /* Adjust as needed */
    }
  </style>
</head> <!--end::Head--> <!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary"> <!--begin::App Wrapper-->
  <div class="app-wrapper"> <!--begin::Header-->
    <nav class="app-header navbar navbar-expand bg-body "> <!--begin::Container-->
      <div class="container-fluid"> <!--begin::Start Navbar Links-->
        <ul class="navbar-nav">
          <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"> <i
                class="bi bi-list"></i> </a> </li>
        </ul> <!--end::Start Navbar Links--> <!--begin::End Navbar Links-->
        <ul class="navbar-nav ms-auto"> <!--begin::Fullscreen Toggle-->
          <li class="nav-item"> <a class="nav-link" href="#" data-lte-toggle="fullscreen"> <i data-lte-icon="maximize"
                class="bi bi-arrows-fullscreen"></i> <i data-lte-icon="minimize" class="bi bi-fullscreen-exit"
                style="display: none;"></i> </a> </li> <!--end::Fullscreen Toggle--> <!--begin::User Menu Dropdown-->
          <li class="nav-item dropdown user-menu"> <a href="#" class="nav-link dropdown-toggle"
              data-bs-toggle="dropdown"> <img src="../../dist/assets/img/AdminLTELogo.png"
                class="user-image rounded-circle " alt="User Image"> <span class="d-none d-md-inline">
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
              <li class="user-header text-bg-primary"> <img src="../../dist/assets/img/AdminLTELogo.png"
                  class="rounded-circle shadow" alt="User Image">
                <p>
                  <?php echo $_SESSION['name'] ?>
                </p>
              </li> <!--end::User Image--> <!--begin::Menu Footer-->
              <li class="user-footer"> <a href="profile.php" class="btn btn-default btn-flat">Profile</a> <a
                  href="log_out.php" class="btn btn-default btn-flat float-end">Sign out</a> </li>
              <!--end::Menu Footer-->
            </ul>
          </li> <!--end::User Menu Dropdown-->
        </ul> <!--end::End Navbar Links-->
      </div> <!--end::Container-->
    </nav> <!--end::Header--> <!--begin::Sidebar-->
    <aside class="app-sidebar bg-body-secondary bg-primary shadow " data-bs-theme="dark"> <!--begin::Sidebar Brand-->
      <div class="sidebar-brand"> <!--begin::Brand Link--> <a href="./admin.php" class="brand-link">
          <!--begin::Brand Image--><img src="../../../Images/logo-icon.png" alt="PiStamp Logo"
            class="brand-image opacity-75 shadow">
          <span class="brand-text fw-light">PiStamp</span> <!--end::Brand Text--> </a> <!--end::Brand Link--> </div>
      <!--end::Sidebar Brand--> <!--begin::Sidebar Wrapper-->
      <div class="sidebar-wrapper">
        <nav class="mt-2"> <!--begin::Sidebar Menu-->
          <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">

            <li class="nav-item"> <a href="./admin.php" class="nav-link active"> <i
                  class="nav-icon bi bi-speedometer"></i>
                <p>Dashboard</p>
              </a> </li>
            <?php if ($_SESSION['role'] == "superadmin"): ?>
              <li class="nav-item"> <a href="./users.php" class="nav-link"> <i class="nav-icon bi bi-person-fill"></i>
                  <p>Users</p>
                </a> </li>
            <?php endif; ?>
            <li class="nav-item"> <a href="./activities.php" class="nav-link"> <i class="nav-icon bi bi-list-ul"></i>
                <p>Activity</p>
              </a> </li>
            <?php if ($_SESSION['role'] != "superadmin"): ?>
              <li class="nav-item"> <a href="./top_students.php" class="nav-link"> <i class="bi bi-star"></i>
                  <p>Top Learners</p>
                </a> </li>
            <?php endif; ?>
            <?php if ($_SESSION['role'] == "superadmin"): ?>
              <li class="nav-item"> <a href="./staff.php" class="nav-link"> <i
                    class="nav-icon bi bi-person-fill-lock"></i>
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
              <h3 class="mb-0">Dashboard</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="admin.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                  Dashboard
                </li>
              </ol>
            </div>
          </div> <!--end::Row-->
        </div> <!--end::Container-->
      </div> <!--end::App Content Header--> <!--begin::App Content-->
      <div class="app-content"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
          <div class="row"> <!--begin::Col-->
            <div class="col-lg-3 col-12"> <!--begin::Small Box Widget 1-->
              <div class="small-box text-bg-primary">
                <div class="inner">
                  <h3><?php
                  $date = date('Y-m-d');
                  $stmt = $conn->prepare("SELECT COUNT(*) AS college_students FROM attendance WHERE LIBRARY = 'College' AND STATUS = 0 AND LOGDATE = :date");
                  $stmt->bindParam(':date', $date);
                  $stmt->execute();
                  $row = $stmt->fetch();
                  echo $row['college_students'];
                  ?></h3>
                  <strong>
                    <p>College Learners</p>
                  </strong>
                </div>
                <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http:
                                    <svg xmlns=" http: <path
                  d="M320 32c-8.1 0-16.1 1.4-23.7 4.1L15.8 137.4C6.3 140.9 0 149.9 0 160s6.3 19.1 15.8 22.6l57.9 20.9C57.3 229.3 48 259.8 48 291.9v28.1c0 28.4-10.8 57.7-22.3 80.8c-6.5 13-13.9 25.8-22.5 37.6C0 442.7-.9 448.3 .9 453.4s6 8.9 11.2 10.2l64 16c4.2 1.1 8.7 .3 12.4-2s6.3-6.1 7.1-10.4c8.6-42.8 4.3-81.2-2.1-108.7C90.3 344.3 86 329.8 80 316.5V291.9c0-30.2 10.2-58.7 27.9-81.5c12.9-15.5 29.6-28 49.2-35.7l157-61.7c8.2-3.2 17.5 .8 20.7 9s-.8 17.5-9 20.7l-157 61.7c-12.4 4.9-23.3 12.4-32.2 21.6l159.6 57.6c7.6 2.7 15.6 4.1 23.7 4.1s16.1-1.4 23.7-4.1L624.2 182.6c9.5-3.4 15.8-12.5 15.8-22.6s-6.3-19.1-15.8-22.6L343.7 36.1C336.1 33.4 328.1 32 320 32zM128 408c0 35.3 86 72 192 72s192-36.7 192-72L496.7 262.6 354.5 314c-11.1 4-22.8 6-34.5 6s-23.5-2-34.5-6L143.3 262.6 128 408z" />
                </svg>
                </svg>
              </div> <!--end::Small Box Widget 1-->
            </div> <!--end::Col-->
            <div class="col-lg-3 col-12"> <!--begin::Small Box Widget 2-->
              <div class="small-box text-bg-success">
                <div class="inner">
                  <h3><?php
                  $date = date('Y-m-d');
                  $stmt = $conn->prepare("SELECT COUNT(*) AS elementary_students FROM attendance WHERE LIBRARY = 'Elementary' AND STATUS = 0 AND LOGDATE = :date");
                  $stmt->bindParam(':date', $date);
                  $stmt->execute();
                  $row = $stmt->fetch();
                  echo $row['elementary_students'];
                  ?></h3>
                  <strong>
                    <p>Elementary Learners</p>
                  </strong>
                </div>

                <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http:
                                    <svg xmlns=" http: <path
                  d="M320 32c-8.1 0-16.1 1.4-23.7 4.1L15.8 137.4C6.3 140.9 0 149.9 0 160s6.3 19.1 15.8 22.6l57.9 20.9C57.3 229.3 48 259.8 48 291.9v28.1c0 28.4-10.8 57.7-22.3 80.8c-6.5 13-13.9 25.8-22.5 37.6C0 442.7-.9 448.3 .9 453.4s6 8.9 11.2 10.2l64 16c4.2 1.1 8.7 .3 12.4-2s6.3-6.1 7.1-10.4c8.6-42.8 4.3-81.2-2.1-108.7C90.3 344.3 86 329.8 80 316.5V291.9c0-30.2 10.2-58.7 27.9-81.5c12.9-15.5 29.6-28 49.2-35.7l157-61.7c8.2-3.2 17.5 .8 20.7 9s-.8 17.5-9 20.7l-157 61.7c-12.4 4.9-23.3 12.4-32.2 21.6l159.6 57.6c7.6 2.7 15.6 4.1 23.7 4.1s16.1-1.4 23.7-4.1L624.2 182.6c9.5-3.4 15.8-12.5 15.8-22.6s-6.3-19.1-15.8-22.6L343.7 36.1C336.1 33.4 328.1 32 320 32zM128 408c0 35.3 86 72 192 72s192-36.7 192-72L496.7 262.6 354.5 314c-11.1 4-22.8 6-34.5 6s-23.5-2-34.5-6L143.3 262.6 128 408z" />
                </svg>
                </svg>
              </div> <!--end::Small Box Widget 2-->
            </div> <!--end::Col-->
            <div class="col-lg-3 col-12"> <!--begin::Small Box Widget 3-->
              <div class="small-box text-bg-warning text-light">
                <div class="inner">
                  <h3><?php
                  $stmt = $conn->prepare("SELECT COUNT(*) AS jhs_students FROM attendance WHERE LIBRARY = 'JHS' AND STATUS = 0 AND LOGDATE = :date");
                  $stmt->bindParam(':date', $date);
                  $stmt->execute();
                  $row = $stmt->fetch();
                  echo $row['jhs_students'];
                  ?></h3>
                  <strong>
                    <p>JHS Learners</p>
                  </strong>
                </div> <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http:
                                    <svg xmlns=" http: <path
                  d="M160 96a96 96 0 1 1 192 0A96 96 0 1 1 160 96zm80 152V512l-48.4-24.2c-20.9-10.4-43.5-17-66.8-19.3l-96-9.6C12.5 457.2 0 443.5 0 427V224c0-17.7 14.3-32 32-32H62.3c63.6 0 125.6 19.6 177.7 56zm32 264V248c52.1-36.4 114.1-56 177.7-56H480c17.7 0 32 14.3 32 32V427c0 16.4-12.5 30.2-28.8 31.8l-96 9.6c-23.2 2.3-45.9 8.9-66.8 19.3L272 512z" />
                </svg>
                </svg>
              </div> <!--end::Small Box Widget 3-->
            </div> <!--end::Col-->
            <div class="col-lg-3 col-12"> <!--begin::Small Box Widget 4-->
              <div class="small-box text-bg-danger">
                <div class="inner">
                  <h3><?php
                  $stmt = $conn->prepare("SELECT COUNT(*) AS shs_students FROM attendance WHERE LIBRARY = 'SHS' AND STATUS = 0 AND LOGDATE = :date");
                  $stmt->bindParam(':date', $date);
                  $stmt->execute();
                  $row = $stmt->fetch();
                  echo $row['shs_students'];
                  ?></h3>
                  <strong>
                    <p>SHS Learners</p>
                  </strong>
                </div> <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http:
                                    <svg xmlns=" http: <path
                  d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z" />
                </svg>
                </svg>
              </div> <!--end::Small Box Widget 4-->
            </div> <!--end::Col-->
            <div class="col-lg-3 col-12"> <!--begin::Small Box Widget 4-->
              <div class="small-box text-bg-pink ">
                <div class="inner">
                  <h3>
                    <?php
                    $stmt = $conn->prepare("
                        SELECT COUNT(*) AS shs_students 
                        FROM attendance 
                        WHERE 
                            (LIBRARY = 'SHS' OR LIBRARY = 'JHS' OR LIBRARY = 'College')
                            AND STATUS = 0 
                            AND LOGDATE = :date
                    ");
                    $stmt->bindParam(':date', $date);
                    $stmt->execute();
                    $row = $stmt->fetch();
                    echo $row['shs_students'];
                    ?>
                  </h3>
                  <strong>
                    <p>Guest</p>
                  </strong>
                </div> <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http:
                                    <svg xmlns=" http: <path
                  d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z" />
                </svg>
                </svg>
              </div> <!--end::Small Box Widget 4-->
            </div> <!--end::Col-->
            <style>
              .text-bg-purple {
                background-color: #6f42c1 !important;
                /* Bootstrap's 'purple' from SCSS variables */
                color: #fff !important;
              }

              .text-bg-maroon {
                background-color: #661f1fff !important;
                /* Bootstrap's 'maroon' from SCSS variables */
                color: #fff !important;
              }

              .text-bg-pink {
                background-color: #ce28e4ff !important;
                /* Bootstrap's 'maroon' from SCSS variables */
                color: #fff !important;
              }
            </style>
            <div class="col-lg-3 col-12"> <!--begin::Small Box Widget 4-->
              <div class="small-box text-bg-purple">
                <div class="inner">
                  <h3><?php
                  $stmt = $conn->prepare("
                      SELECT COUNT(*) AS MWSP_students
                      FROM attendance AS a
                      INNER JOIN student AS s ON a.STUDENTID = s.STUDENTID
                      WHERE a.LIBRARY = 'JHS'
                        AND a.STATUS = 0
                        AND a.LOGDATE = :date
                        AND s.DEPARTMENT = 'MWSP'
                  ");
                  $stmt->bindParam(':date', $date);
                  $stmt->execute();
                  $row = $stmt->fetch();
                  echo $row['MWSP_students'];
                  ?></h3>
                  <strong>
                    <p>MWSP Learners</p>
                  </strong>
                </div> <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http:
                                    <svg xmlns=" http: <path
                  d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z" />
                </svg>
                </svg>
              </div> <!--end::Small Box Widget 4-->
            </div> <!--end::Col-->
            <div class="col-lg-3 col-12"> <!--begin::Small Box Widget 4-->
              <div class="small-box text-bg-maroon">
                <div class="inner">
                  <h3>
                    <?php
                    $stmt = $conn->prepare("
                      SELECT COUNT(*) AS employee_count
                      FROM attendance AS a
                      INNER JOIN student AS s ON a.STUDENTID = s.STUDENTID
                      WHERE a.LIBRARY IN ('JHS', 'College', 'SHS', 'Elementary')
                        AND a.STATUS = 0
                        AND a.LOGDATE = :date
                        AND s.DEPARTMENT IN (
                            'NTP',
                            'ADMIN',
                            'MC',
                            'NTP-SHS',
                            'NTP/ SHS Faculty',
                            'CONSULTANT'
                        )
                    ");
                    $stmt->bindParam(':date', $date);
                    $stmt->execute();
                    $row = $stmt->fetch();
                    echo $row['employee_count'];
                    ?>
                  </h3>
                  <strong>
                    <p>Employees</p>
                  </strong>
                </div> <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http:
                                    <svg xmlns=" http: <path
                  d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z" />
                </svg>
                </svg>
              </div> <!--end::Small Box Widget 4-->
            </div> <!--end::Col-->
          </div>
          <div class="row mt-3">
            <div class="col"> <!-- /.card -->
              <div class="card mb-4" style="height: 400px;">
                <div class="card-header d-flex align-items-center">
                  <h3 class="card-title me-2">Total Visits by Library</h3>
                </div>
                <div class="card-body">
                  <div id="visits_by_library"></div>
                </div>
                <div class="card-footer">
                  <div class="d-flex align-items-center justify-content-center">
                    <div class="d-flex align-items-center text-center col-md-3 me-1">
                      <span class="me-1">From: </span>
                      <input type="date" id="startDateLib" class="form-control">
                    </div>
                    <div class="d-flex align-items-center text-center col-md-3 me-1">
                      <span class="me-1">To: </span>
                      <input type="date" id="endDateLib" class="form-control">
                    </div>
                    <button class="btn btn-primary me-1" id="chartFilterLib">Filter</button>
                    <button class="btn btn-secondary" id="chartResetLib">Reset</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row"> <!-- Start col -->
            <div class="col">
              <div class="card mb-4" style="height: 400px;">
                <div class="card-header d-inline align-items-center">
                  <h3 class="card-title me-2">Total Visits</h3>
                </div>
                <div class="card-body">
                  <div id="visits"></div>
                </div>
                <div class="card-footer">
                  <div class="d-flex align-items-center justify-content-center">
                    <div class="d-flex align-items-center text-center col-md-3 me-1">
                      <span class="me-1">From: </span>
                      <input type="date" id="startDateAll" class="form-control">
                    </div>
                    <div class="d-flex align-items-center text-center col-md-3 me-1">
                      <span class="me-1">To: </span>
                      <input type="date" id="endDateAll" class="form-control">
                    </div>
                    <button class="btn btn-primary me-1" id="chartFilterAll">Filter</button>
                    <button class="btn btn-secondary" id="chartResetAll">Reset</button>
                  </div>
                </div>
              </div> <!-- /.card -->
            </div>
          </div> <!-- /.row (main row) -->
        </div> <!--end::Container-->
      </div> <!--end::App Content-->
    </main> <!--end::App Main--> <!--begin::Footer-->
    <footer class="app-footer"> <!--begin::To the end-->
      <div class="float-end d-none d-sm-inline"> <a href="https://www.facebook.com/PARZIV4L77"> <strong> PARZIV4L
          </strong></div></a> <strong>
        PiStamp (Assumption College of Davao)
      </strong>
    </footer> <!--end::Footer-->
  </div> <!--end::App Wrapper--> <!--begin::Script--> <!--begin::Third Party Plugin(OverlayScrollbars)-->
  <script src=" ../js/overlayscrollbars/overlayscrollbars.browser.es6.min.js"></script>
  <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
  <script src="../js/popper/popper.min.js"></script>
  <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
  <script src="../js/bootstrap/bootstrap.min.js"></script>
  <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
  <script src="../../dist/js/adminlte.js"></script>
  <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->

  <!-- OPTIONAL SCRIPTS --> <!-- sortablejs -->
  <script src="../js/sortablejs/Sortable.min.js"></script> <!-- sortablejs -->

  <!-- apexcharts -->
  <script src="../js/apexcharts/apexcharts.min.js"></script> <!-- ChartJS -->
  <script src="../js/jsvectormap/jsvectormap.min.js"></script>
  <script src="../js/jsvectormap/world.js"></script> <!-- jsvectormap -->
  <script src="../js/chartjs/chart.js"></script>
  <script src="../js/chartjs/chartjs-adapter-date-fns.bundle.min.js"></script>

  <!-- ScRriptz -->
  <script src="admin.js"></script>
</body>

</html>