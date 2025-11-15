let table;
let maxChar = 10;

$(document).ready(function () {
  table = $("#students-table").DataTable({
    // Store the DataTable instance
    layout: {
      topStart: {
        buttons: [
          "copy",
          "excel",
          "pdf",
          "print",
          {
            text: "Add Staff",
            action: function (e, dt, node, config) {
              $("#add_staff_modal").modal("show");
            },
          },
        ],
      },
      bottomStart: "pageLength",
      responsive: true,
    },
    pageResize: true,
    serverSide: true,
    processing: true,
    autoWidth: true, // Automatically adjusts column widths based on content
    ajax: {
      url: "staff_pagination.php",
      type: "POST",
    },
    columns: [
      { data: "id"},
      { data: "username"},
      { data: "password"},
      { data: "role"},
      {
        data: "id",
        render: function (data) {
            return `
                <div class="d-flex justify-content-center">
                  <button class="btn btn-sm btn-primary edit-btn me-1" data-id="${data}" type="button" data-bs-toggle="modal" data-bs-target="#edit_staff_modal"><i class="bi bi-pencil-square"></i></button>
                  <button class="btn btn-sm btn-danger delete-btn" data-id="${data}"><i class="bi bi-trash"></i></button>
                </div>
              `;
        },
        orderable: false,
      },
    ],
  });

  // Include the SweetAlert2 library before this script

  // Function to confirm user deletion
  function confirmDeleteUser(userId) {
    // Display the SweetAlert2 confirmation dialog
    Swal.fire({
      title: "Are you sure?",
      text: "Do you really want to delete this staff? This action cannot be undone.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "No, cancel",
      toast: true, // Enable toast mode
      position: "top-right", // Position the toast
    }).then((result) => {
      if (result.isConfirmed) {
        // Logic to delete the user
        deleteUser(userId);
      }
    });
  }

  // Function to handle the deletion logic
  function deleteUser(userId) {
    // Example: Simulating an API call
    const selectedUserForDeletion = new FormData();
    selectedUserForDeletion.append("id", userId);

    fetch("delete_staff.php", {
      method: "POST",
      body: selectedUserForDeletion,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          Swal.fire({
            icon: "success",
            title: "Staff removed successfully!",
          });
          // Reload the table or remove the row from UI
          table.ajax.reload();
        } else {
          throw new Error(data.message || "Failed to delete the staff.");
        }
      })
      .catch((error) => {
        Swal.fire({
          title: "Error!",
          text: error.message,
          icon: "error",
          toast: true,
          position: "top-right",
          timer: 3000,
          showConfirmButton: false,
        });
      });
  }

  // Attach event listener to the delete button
  $("#students-table").on("click", ".delete-btn", function () {
    var rowId = $(this).data("id");
    console.log(rowId);
    confirmDeleteUser(rowId);
  });

  $("#students-table").on("click", ".edit-btn", function () {
    var rowId = $(this).data("id");

    const selectedUser = new FormData();
    selectedUser.append("id", rowId);
    fetch("fetch_staff_info.php", {
      method: "POST",
      body: selectedUser,
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error(`HTTP Error! Status: ${response.status}`);
        }
        return response.json();
      })
      .then((data) => {
        Swal.close();

        $("#edit_id").val(data.id);
        $("#edit_username").val(data.username);
        $("#edit_role").val(data.role).change();
      })
      .catch((error) => console.error("Error: ", error));
  });
});

// Add User Form
$(document).on("submit", "#add_staff_form", function (e) {

  e.preventDefault();
  const fields = [
    { id: "#username", message: "Username required!" },
    { id: "#password", message: "Password is required!" },
    { id: "#role", message: "Role is required!" }
  ];

  for (const field of fields) {
    if (!$(field.id).val()) {
      Swal.fire({
        title: field.message,
        text: "Please insert a value.",
        icon: "error",
      });
      return; // Stop further execution if a field is invalid
    }
  }

  const formData = new FormData();
  formData.append("username", $("#username").val());
  formData.append("password", $("#password").val());
  formData.append("role", $("#role").val());

  fetch("staff_back_end.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.text())
    .then((data) => {
      try {
        if (data.trim() === "1") {
          Swal.fire({
            icon: "success",
            title: "Staff added successfully!",
          });
          $("#add_staff_modal").modal("hide");
          $("#add_staff_modal").hide();
          table.ajax.reload();
        } else {
          Swal.fire({
            icon: "error",
            title: "Staff already exists!",
          });
        }
      } catch (error) {
        console.error("JSON Parsing Error:", error);
        Swal.fire({
          icon: "error",
          title: "Invalid response from the server!",
          text: "Please check the server logs for more details.",
        });
      }
    })
    .catch((error) => console.error("Error: ", error));
});

$(document).on("click", "#edit_staff", function (e) {
  e.preventDefault();

  const formData = new FormData();
  formData.append("username", $("#edit_username").val());
  formData.append("password", $("#edit_password").val());
  formData.append("role", $("#edit_role").val());
  formData.append("id", $("#edit_id").val());

  fetch("edit_staff_back_end_edit.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.text()) // Use .text() to log the raw response
    .then((rawResponse) => {
      try {
        const data = JSON.parse(rawResponse); // Try parsing as JSON
        if (data.success) {
          Swal.fire({
            icon: "success",
            title: "Changes saved successfully!",
          });
          $("#edit_staff_modal").modal("hide");
          $("#edit_staff_modal").hide();
          table.ajax.reload();
        } else {
          Swal.fire({
            icon: "error",
            title: "Changes save failed!",
            text: data.message || "Unknown error occurred.",
          });
        }
      } catch (error) {
        console.error("JSON Parsing Error:", error);
        Swal.fire({
          icon: "error",
          title: "Invalid response from the server!",
          text: "Please check the server logs for more details.",
        });
      }
    })
    .catch((error) => {
      console.error("Fetch Error:", error);
      Swal.fire({
        icon: "error",
        title: "Error occurred!",
        text: error.message,
      });
    });
});
