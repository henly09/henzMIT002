$(document).ready(function () {
  $("#scan").hide();
  $("#manual").hide();
  $("#guest").hide();

  var currentChoice = 0;
  var timer;

  // Activity dropdown functionality for all forms
  function setupActivityDropdown(selectId, otherInputId) {
    $(document).on('change', selectId, function() {
      console.log('Dropdown changed:', $(this).val()); // Debug log
      if ($(this).val() === 'Others') {
        $(otherInputId).slideDown(200);
        setTimeout(function() {
          $(otherInputId).focus();
        }, 250);
      } else {
        $(otherInputId).slideUp(200);
        $(otherInputId).val('');
      }
    });
  }

  // Initialize activity dropdowns
  setupActivityDropdown('#scan-activity', '#scan-activity-other');
  setupActivityDropdown('#manual-activity', '#manual-activity-other');
  setupActivityDropdown('#guest-activity', '#guest-activity-other');

  // Additional direct event handlers to ensure it works
  $(document).on('change', '#scan-activity', function() {
    console.log('SCAN: Selected value:', $(this).val());
    if ($(this).val() === 'Others') {
      $('#scan-activity-other').show().focus();
      console.log('SCAN: Showing others input');
    } else {
      $('#scan-activity-other').hide().val('');
    }
  });

  $(document).on('change', '#manual-activity', function() {
    console.log('MANUAL: Selected value:', $(this).val());
    if ($(this).val() === 'Others') {
      $('#manual-activity-other').show().focus();
      console.log('MANUAL: Showing others input');
    } else {
      $('#manual-activity-other').hide().val('');
    }
  });

  $(document).on('change', '#guest-activity', function() {
    console.log('GUEST: Selected value:', $(this).val());
    if ($(this).val() === 'Others') {
      $('#guest-activity-other').show().focus();
      console.log('GUEST: Showing others input');
    } else {
      $('#guest-activity-other').hide().val('');
    }
  });

  // Test function - you can call this in browser console to test
  window.testDropdowns = function() {
    console.log('Testing dropdowns...');
    $('#scan-activity-other').show().css('background-color', 'yellow');
    $('#manual-activity-other').show().css('background-color', 'yellow');
    $('#guest-activity-other').show().css('background-color', 'yellow');
  };

  // Force show inputs when page loads (for testing)
  console.log('Setting up activity dropdowns...');
  console.log('Scan input exists:', $('#scan-activity-other').length);
  console.log('Manual input exists:', $('#manual-activity-other').length);
  console.log('Guest input exists:', $('#guest-activity-other').length);

  // Function to get activity value
  function getActivityValue(selectId, otherInputId) {
    const selectValue = $(selectId).val();
    if (selectValue === 'Others') {
      return $(otherInputId).val();
    }
    return selectValue || ''; // Return empty string if nothing selected
  }

  // Function to validate activity selection
  function validateActivity(selectId, otherInputId) {
    const selectValue = $(selectId).val();
    if (selectValue === "") {
      return false;
    }
    if (selectValue === "Others" && $(otherInputId).val().trim() === "") {
      return false;
    }
    return true;
  }

  // SCAN
  $("#scan-button").click(function () {
    currentChoice = 1;
    $("#manual").hide();
    $("#guest").hide();

    $("#scan").show();
    $("#scan").css("display", "flex");

    // Setup dropdown handler when scan form is shown
    $("#scan-activity").off('change').on('change', function() {
      console.log('SCAN dropdown changed to:', $(this).val());
      if ($(this).val() === 'Others') {
        $("#scan-activity-other").show().focus();
        console.log('SCAN: Showing text input');
      } else {
        $("#scan-activity-other").hide().val('');
      }
    });

    $("#scan-field").focus();
    $("#scan-field").on("input", function (e) {
      clearTimeout(timer);
      timer = setTimeout(function () {
        $("#scan-submit").click(function (e) {
          e.preventDefault();
        });

        // Validate activity selection - removed validation since N/A is acceptable
        // Activity will default to 'N/A' if not selected

        const formData = new FormData();
        formData.append("id", $("#scan-field").val());
        formData.append("activity", getActivityValue('#scan-activity', '#scan-activity-other'));

        fetch("api/time.php", {
          method: "POST",
          body: formData,
        })
          .then((response) => response.json())
          .then((data) => {
            function prompt(status) {
              if (status) {
                return "Time In Successfully!";
              } else {
                return "Time Out Successfully!";
              }
            }

            if (data.status) {
              Swal.fire({
                toast: true,
                icon: "success",
                title: prompt(data.time),
                text: data.user[0]["FIRSTNAME"],
                position: "top-end",
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 3000,
              });
              console.log(data.user[0])
              $("#scanNameDisplay").html(data.user[0]["FIRSTNAME"]);
              $("#scanNameDisplay2").html(data.user[0]["STUDENTID"]);
              setTimeout(function () {
                  $("#scanNameDisplay").html('');
                  $("#scanNameDisplay2").html('');
              }, 10000);
              $("#scan-field").val("");
            } else {
              Swal.fire({
                toast: true,
                icon: "error",
                title: "ID Not Found!",
                position: "top-end",
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 3000,
              });
              $("#scan-field").val("");
            }
          });
      }, 100);
    });
  });

  // MANUAL
  $("#manual-button").click(function () {
    currentChoice = 2;
    $("#scan").hide();
    $("#guest").hide();

    $("#manual").show();
    $("#manual").css("display", "flex");

    // Setup dropdown handler when manual form is shown
    $("#manual-activity").off('change').on('change', function() {
      console.log('MANUAL dropdown changed to:', $(this).val());
      if ($(this).val() === 'Others') {
        $("#manual-activity-other").show().focus();
        console.log('MANUAL: Showing text input');
      } else {
        $("#manual-activity-other").hide().val('');
      }
    });

    $("#manual-field").focus();

    $("#manual-submit").click(function (e) {
      e.preventDefault();
      const formData = new FormData();
      formData.append("id", $("#manual-field").val());
      formData.append("activity", getActivityValue('#manual-activity', '#manual-activity-other'));

      if ($("#manual-field").val() == "") {
        Swal.fire({
          toast: true,
          icon: "error",
          title: "Please insert your ID!",
          position: "top-end",
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 3000,
        });
        $("#manual-field").val("");
        return;
      }

      fetch("api/time.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          function prompt(status) {
            if (status) {
              return "Time In Successfully!";
            } else {
              return "Time Out Successfully!";
            }
          }

          if (data.status) {
            Swal.fire({
              toast: true,
              icon: "success",
              title: prompt(data.time),
              text: data.user[0]["FIRSTNAME"],
              position: "top-end",
              showConfirmButton: false,
              timerProgressBar: true,
              timer: 3000,
            });
            $("#manualNameDisplay").html(data.user[0]["FIRSTNAME"]);
            $("#manual-field").val("");
          } else {
            Swal.fire({
              toast: true,
              icon: "error",
              title: "ID Not Found!",
              position: "top-end",
              showConfirmButton: false,
              timerProgressBar: true,
              timer: 3000,
            });
            $("#manual-field").val("");
          }
          $("#manual-field").focus();
        });
    });
  });

  // GUEST
  $("#guest-button").click(function () {
    currentChoice = 3;
    $("#scan").hide();
    $("#manual").hide();

    $("#guest").show();
    $("#guest").css("display", "flex");

    // Setup dropdown handler when guest form is shown
    $("#guest-activity").off('change').on('change', function() {
      console.log('GUEST dropdown changed to:', $(this).val());
      if ($(this).val() === 'Others') {
        $("#guest-activity-other").show().focus();
        console.log('GUEST: Showing text input');
      } else {
        $("#guest-activity-other").hide().val('');
      }
    });

    $("#guest-request").click(function (e) {
      // Activity selection is optional - will default to N/A if not selected

      fetch("api/guest.php", {
        method: "POST",
      })
        .then((response) => response.json())
        .then((data) => {
          formData = new FormData();
          formData.append("id", data.id);
          formData.append("activity", getActivityValue('#guest-activity', '#guest-activity-other'));

          fetch("api/create_guest.php", {
            method: "POST",
            body: formData,
          })
            .then((response) => response.json())
            .then((data) => {
              $("#guest-field").val(data.id);
            });
        });
      $("#guest-field").focus();
    });

    $("#guest-field").focus();
  });
});
