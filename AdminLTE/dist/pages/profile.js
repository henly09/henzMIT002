document
  .getElementById("save_changes")
  .addEventListener("submit", function (e) {
    e.preventDefault();

    const username = document.querySelector('input[name="username"]').value;
    const password = document.querySelector('input[name="password"]').value;
    const confirm_password = document.querySelector(
      'input[name="confirm_password"]',
    ).value;

    if (!(password == confirm_password)) {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Password does not match!",
        showConfirmButton: false,
        allowOutsideClick: false,
        timer: 1000,
      });
      return;
    }

    if (!username || !password) {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Please fill in both username and password!",
        allowOutsideClick: false,
      });
    } else {
      // Show a loading alert while processing login
      Swal.fire({
        icon: "info",
        title: "Proccessing...",
        showConfirmButton: false,
        allowOutsideClick: false,
        timer: 1000,
        didOpen: () => {
          Swal.showLoading();
        },
      }).then(() => {
        Swal.fire({
          icon: "success",
          title: "Changes saved successfully!",
          showConfirmButton: false,
          allowOutsideClick: false,
          timer: 1000,
        });
      });
    }
  });

function saveChanges() {
  const username = document.getElementById("username").value;
  const password = document.getElementById("password").value;

  if (!username || !password) {
    return;
  }

  // Create a FormData object to send data
  const formData = new FormData();
  formData.append("username", username);
  formData.append("password", password);

  // Send AJAX request
  fetch("profile_back_end.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.text())
    .then((data) => {})
    .catch((error) => console.error("Error:", error));
}
