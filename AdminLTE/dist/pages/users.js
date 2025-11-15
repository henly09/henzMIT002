let table;
let maxChar = 10;

$(document).ready(function () {
  // Initialize the DataTable
  table = $("#students-table").DataTable({
    layout: {
      topStart: {
        buttons: [
          "copy",
          "excel",
          "pdf",
          "print",
          {
            text: "Add User",
            action: function (e, dt, node, config) {
              $("#add_user_modal").modal("show");
            },
          },
          {
            text: "Bulk Import",
            action: function (e, dt, node, config) {
              $("#bulk_import_modal").modal("show");
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
      url: "users_pagination.php",
      type: "POST",
    },
    columns: [
      {
        data: "STUDENTID",
        render: function (data) {
          return data ? String(data) : "";
        },
      },
      { data: "FIRSTNAME"},
      { data: "LASTNAME"},
      { data: "AGE"},
      { data: "GENDER"},
      { data: "CATEGORY"},
      { data: "DEPARTMENT"},
      { data: "GRADELEVEL"},
      { data: "SECTION"},
      {
        data: "STUDENTID", // Make sure this is the correct data property for the ID
        render: function (data) {
          return `
            <div class="d-flex justify-content-center">
              <button class="btn btn-sm btn-primary edit-button-custom me-1" data-id="${data}" type="button" data-bs-toggle="modal" data-bs-target="#edit_user_modal"><i class="bi bi-pencil-square"></i></button>
              <button class="btn btn-sm btn-danger delete-button-custom" data-id="${data}"><i class="bi bi-trash"></i></button>
            </div>
          `;
        },
        orderable: false,
      },
    ],
  });
  // Function to confirm user deletion
  function confirmDeleteUser(userId) {
    // Display the SweetAlert2 confirmation dialog
    Swal.fire({
      title: "Are you sure?",
      text: "Do you really want to delete this user? This action cannot be undone.",
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

    fetch("delete_user.php", {
      method: "POST",
      body: selectedUserForDeletion,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          Swal.fire({
            icon: "success",
            title: "User removed successfully!",
          });
          // Reload the table or remove the row from UI
          table.ajax.reload();
        } else {
          throw new Error(data.message || "Failed to delete the user.");
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
  $("#students-table").on("click", ".delete-button-custom", function () {
    var rowId = $(this).data("id");
    confirmDeleteUser(rowId);
  });

  $(document).on("click", ".edit-button-custom", function () {
    var rowId = $(this).data("id");
    
    const selectedUser = new FormData();
    selectedUser.append("id", rowId);
    fetch("fetch_user_info.php", {
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
        let full_name = data.FIRSTNAME.split(",");

        function toComplete(s) {
          if (!s || s === "") {
            return "Others";
          } else if (s === "M") {
            return "Male";
          } else if (s === "F") {
            return "Female";
          } else {
            return "Others";
          }
        }

        $("#edit_id").val(data.STUDENTID);
        $("#edit_first_name").val(full_name[1]);
        $("#edit_last_name").val(full_name[0]);
        $("#edit_age").val(data.AGE);
        $("#edit_gender").val(toComplete(data.GENDER));
        $("#edit_category").val(data.CATEGORY);
        $("#edit_department").val(data.DEPARTMENT);
        $("#edit_grade_level").val(data.GRADELEVEL);
        $("#edit_section").val(data.SECTION);
      })
      .catch((error) => console.error("Error: ", error));
  });
});

// Add User Form
$(document).on("submit", "#add_user_form", function (e) {
  function toSingleLetter(s) {
    if (s === "Male") {
      return "M";
    } else if (s === "Female") {
      return "F";
    } else {
      return "";
    }
  }

  e.preventDefault();
  const fields = [
    { id: "#id", message: "ID required!" },
    { id: "#first_name", message: "First name is required!" },
    { id: "#last_name", message: "Last name is required!" },
    { id: "#age", message: "Age is required!" },
    { id: "#gender", message: "Gender is required!" },
    { id: "#category", message: "Category is required!" },
    { id: "#department", message: "Department is required!" },
    { id: "#grade_level", message: "Grade level is required!" },
    { id: "#section", message: "Section is required!" },
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
  formData.append("id", $("#id").val());
  formData.append("first_name", $("#first_name").val());
  formData.append("last_name", $("#last_name").val());
  formData.append("age", $("#age").val());
  formData.append("gender", toSingleLetter($("#gender").val()));
  formData.append("category", $("#category").val());
  formData.append("department", $("#department").val());
  formData.append("grade_level", $("#grade_level").val());
  formData.append("section", $("#section").val());

  fetch("users_back_end.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.text())
    .then((data) => {
      try {
        if (data.trim() === "1") {
          Swal.fire({
            icon: "success",
            title: "User added successfully!",
          });
          $("#add_user_modal").modal("hide");
          $("#add_user_modal").hide();
          table.ajax.reload();
        } else {
          Swal.fire({
            icon: "error",
            title: "User ID already exists!",
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

$(document).on("click", "#edit_user", function (e) { 
  e.preventDefault();
  function toSingleLetter(s) {
    if (s === "Male") {
      return "M";
    } else if (s === "Female") {
      return "F";
    } else {
      return "";
    }
  }

  const formData = new FormData();
  formData.append("id", $("#edit_id").val());
  formData.append("first_name", $("#edit_first_name").val());
  formData.append("last_name", $("#edit_last_name").val());
  formData.append("age", $("#edit_age").val());
  formData.append("gender", toSingleLetter($("#edit_gender").val()));
  formData.append("category", $("#edit_category").val());
  formData.append("department", $("#edit_department").val());
  formData.append("grade_level", $("#edit_grade_level").val());
  formData.append("section", $("#edit_section").val());

  fetch("edit_user_back_end_edit.php", {
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
          $("#edit_user_modal").modal("hide");
          $("#edit_user_modal").hide();
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


$(document).on("submit", "#bulk_import_form", function (e) {
  e.preventDefault();
  
  if (!$("#file").val()) {
    Swal.fire({
      title: "File required!",
      text: "Please select a file to upload.",
      icon: "error",
    });
    return;
  }

  Swal.fire({
      icon: "info",
      title: "Importing...",
      showConfirmButton: false,
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      },
  })

  const formData = new FormData();
  formData.append("file", $("#file")[0].files[0]);

  fetch("bulk_import.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "success") {
        Swal.fire({
          icon: "success",
          title: "Bulk import successful!",
          text: data.message,
        });
        $("#bulk_import_modal").modal("hide");
        $("#bulk_import_modal").hide();
        table.ajax.reload();
      } else {
        Swal.fire({
          icon: "error",
          title: "Bulk import failed!",
          text: data.message || "Unknown error occurred.",
        });
      }
    })
    .catch((error) => console.error("Error: ", error));
});