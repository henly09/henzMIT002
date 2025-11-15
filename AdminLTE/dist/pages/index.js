document.getElementById("login").addEventListener("submit", function (e) {
  e.preventDefault();

  const username = document.querySelector('input[name="username"]').value;
  const password = document.querySelector('input[name="password"]').value;

  if (!username || !password) {
    Swal.fire({
      icon: "error",
      title: "Oops...",
      text: "Please fill in both username and password!",
      showConfirmButton: false,
      allowOutsideClick: false,
      timer: 1000,
    });
  } else {
    // Show a loading alert while processing login
    Swal.fire({
      icon: "info",
      title: "Logging in...",
      showConfirmButton: false,
      allowOutsideClick: false,
      timer: 1000,
      didOpen: () => {
        Swal.showLoading();
      },
    }).then(() => {
      const username = document.getElementById("username").value;
      const password = document.getElementById("password").value;

      // Create a FormData object to send data
      const formData = new FormData();
      formData.append("username", username);
      formData.append("password", password);

      // Send AJAX request
      fetch("index_back_end.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => response.text())
        .then((data) => {
          if (data.trim() === "1") {
            Swal.fire({
              icon: "success",
              title: "Login Success!",
              showConfirmButton: false,
              allowOutsideClick: false,
              timer: 1000,
            }).then(() => {
              location.reload();
            });
          } else {
            Swal.fire({
              icon: "error",
              title: "Incorrect Username or Password!",
              showConfirmButton: false,
              allowOutsideClick: false,
              timer: 1000,
            });
          }
        })
        .catch((error) => console.error("Error:", error));
    });
  }
});
