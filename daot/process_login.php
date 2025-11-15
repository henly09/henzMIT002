<?php
// Start the session
session_start();

// Check if the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize user input from the form
    $studentId = htmlspecialchars($_POST['studentId'] ?? '');
    $department = htmlspecialchars($_POST['department'] ?? '');

    // Validate the inputs
    if ($studentId && $department) {
        // Store user data in session
        $_SESSION['student_id'] = $studentId;
        $_SESSION['department'] = $department;

        // Redirect to the confirmation page with studentId and department
        header("Location: confirmation.php?studentId=$studentId&department=$department");
        exit();
    } else {
        // If input is invalid, set an error message and redirect back
        $_SESSION['error_message'] = 'Please fill out all fields.';
        header("Location: confirmation.php");
        exit();
    }
} else {
    // If the form is not submitted via POST, redirect to the login page
    header("Location: confirmation.php");
    exit();
}
?>
