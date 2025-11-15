<!DOCTYPE html>
<?php include_once('conn.php'); ?>
<?php
if (!isset($_SESSION['role'])) {
  header('Location: AdminLTE/dist/pages/index.php');
}
if ($_SESSION['role'] == "superadmin") {
  die("You are not allowed to access this page.");
}
?>
<html lang="en">

<head>
  <title>ACD Attendance</title>
  <link rel="icon" href="favicon.ico">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="style.css">
</head>

<body class="p-5">
  <div class="row h-100">
    <div class="col-md-6 h-100">
      <div
        class="d-flex flex-column justify-content-evenly align-items-center text-center container-fluid container-custom p-5 rounded h-100">
        <img src="Images\logo.png" alt="ACD Logo" class="img-fluid img-custom">
        <span class="fs-2 fw-bold">Assumption College of Davao</span>
        <span class="fs-2">Powered by PiStamp</span>
        <div class="d-flex d-flex justify-content-center align-items-center w-100">
          <button class="mx-1 rounded button-custom" id="scan-button"><i class="bi bi-upc-scan h1"></i><span
              class="fw-bold">Scan</span></button>
          <button class="mx-1 rounded button-custom" id="manual-button"><i class="bi bi-keyboard h1"></i><span
              class="fw-bold">Manual</span></button>
          <button class="mx-1 rounded button-custom" id="guest-button"><i class="bi bi-person-bounding-box h1"></i><span
              class="fw-bold">Guest</span></button>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div>

      </div>
      <div
        class="flex-column justify-content-evenly align-items-center text-center container-fluid container-custom p-5 rounded h-100"
        id="scan">
        <form action="#" method="post" id="scan-form" class="d-flex flex-column justify-content-evenly">
          <span class="fs-1 fw-bold">BARCODE SCAN INPUT</span>
          <input type="text" class="fs-1 d-flex my-5" id="scan-field" autocomplete="off">
          
          <!-- Activity Selection -->
          <div class="mb-3 w-100">
            <label for="scan-activity" class="form-label fw-bold">Purpose of Visit:</label>
            <select class="form-select fs-5" id="scan-activity">
              <option value="">Select Activity</option>
              <option value="Study">Study</option>
              <option value="Research">Research</option>
              <option value="Reading">Reading</option>
              <option value="Book Borrowing">Book Borrowing</option>
              <option value="Computer/Internet Use">Computer/Internet Use</option>
              <option value="Group Study">Group Study</option>
              <option value="Meeting">Meeting</option>
              <option value="Others">Others</option>
            </select>
            <input type="text" class="form-control mt-2 fs-5" id="scan-activity-other" placeholder="Please specify your activity..." style="display: none;" required>
          </div>
          
          <span>Please use the scanner to scan your ID.</span>
          <span class="mt-5">Recent: </span>
          <span style="font-size: 4rem;" class="fw-bold text-white" id="scanNameDisplay"></span>
          <span style="font-size: 4rem;" class="fw-bold text-white" id="scanNameDisplay2"></span>
          <button type="submit" id="scan-submit">Submit</button>
        </form>
      </div>
      <div
        class="flex-column justify-content-evenly align-items-center text-center container-fluid container-custom p-5 rounded h-100"
        id="manual">
        <form action="#" method="post" id="manual-form"
          class="d-flex flex-column align-items-center text-center justify-content-evenly">
          <span class="fs-1 fw-bold">MANUAL KEYBOARD INPUT</span>
          <input type="text" class="fs-1 d-flex mt-5" id="manual-field" autocomplete="off">
          
          <!-- Activity Selection -->
          <div class="mb-3 w-100">
            <label for="manual-activity" class="form-label fw-bold mt-3">Purpose of Visit:</label>
            <select class="form-select fs-5" id="manual-activity">
              <option value="">Select Activity</option>
              <option value="Study">Study</option>
              <option value="Research">Research</option>
              <option value="Reading">Reading</option>
              <option value="Book Borrowing">Book Borrowing</option>
              <option value="Computer/Internet Use">Computer/Internet Use</option>
              <option value="Group Study">Group Study</option>
              <option value="Meeting">Meeting</option>
              <option value="Others">Others</option>
            </select>
            <input type="text" class="form-control mt-2 fs-5" id="manual-activity-other" placeholder="Please specify your activity..." style="display: none;" required>
          </div>
          
          <div class="d-flex justify-content-evenly w-100">
            <button type="submit" class="rounded button-custom mt-3 mb-5" id="manual-submit" autocomplete="off"><i
                class="bi bi-clock h1"></i><span class="fw-bold">SUBMIT</span></button>
          </div>
          <span>Please use the keyboard to insert your ID.</span>
          <span class="mt-5">Recent: </span>
          <span style="font-size: 4rem;" class="fw-bold text-white" id="manualNameDisplay"></span>
        </form>
      </div>
      <div
        class="flex-column justify-content-evenly align-items-center text-center container-fluid container-custom p-5 rounded h-100"
        id="guest">
        <div id="guest-form" class="d-flex flex-column justify-content-evenly">
          <span class="fs-1 fw-bold">GUEST ID REQUISITION</span>
          <input type="text" class="fs-1 d-flex mt-5" id="guest-field" autocomplete="off" readonly>
          
          <!-- Activity Selection -->
          <div class="mb-3 w-100">
            <label for="guest-activity" class="form-label fw-bold mt-3">Purpose of Visit:</label>
            <select class="form-select fs-5" id="guest-activity">
              <option value="">Select Activity</option>
              <option value="Study">Study</option>
              <option value="Research">Research</option>
              <option value="Reading">Reading</option>
              <option value="Book Borrowing">Book Borrowing</option>
              <option value="Computer/Internet Use">Computer/Internet Use</option>
              <option value="Group Study">Group Study</option>
              <option value="Meeting">Meeting</option>
              <option value="Others">Others</option>
            </select>
            <input type="text" class="form-control mt-2 fs-5" id="guest-activity-other" placeholder="Please specify your activity..." style="display: none;" required>
          </div>
          
          <div class="d-flex justify-content-evenly w-100">
            <button class="rounded button-custom mt-3 mb-5" id="guest-request"><i
                class="bi bi-person-vcard h1"></i><span class="fw-bold">Get an ID</span></button>
          </div>
          <span>Please make sure to remember your ID.</span>
        </div>
      </div>
    </div>
  </div>

  <script src="AdminLTE\dist\js\jquery\jquery-3.7.1.js"></script>
  <script src="AdminLTE\dist\js\sweetalert\swal.js"></script>
  <script src="index.js"></script>
</body>

</html>