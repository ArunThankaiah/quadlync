<?php
// Set the email address to receive form submissions
$webmaster_email = "apply@quadlync.com";

// Set the URLs for supporting pages
$feedback_page = "index.php";
$error_page = "error_message.html";
$thankyou_page = "thankyou.php";

// Load form field data into variables, use isset() to avoid undefined variable errors
$fname = isset($_POST['firstname']) ? $_POST['firstname'] : '';
$lname = isset($_POST['lastname']) ? $_POST['lastname'] : '';
$gender = isset($_POST['gender']) ? $_POST['gender'] : '';
$age = isset($_POST['age']) ? $_POST['age'] : '';
$mobile = isset($_POST['mobile']) ? $_POST['mobile'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$subject = isset($_POST['subject']) ? $_POST['subject'] : '';

// Construct the message
$msg = 
"First Name: " . $fname . "\r\n" . 
"Last Name: " . $lname . "\r\n" . 
"Gender: " . $gender . "\r\n" . 
"Age: " . $age . "\r\n" . 
"Mobile: " . $mobile . "\r\n" . 
"Email Address: " . $email . "\r\n" . 
"Course: " . $subject;

// Function to check for email injection
function isInjected($str) {
    $injections = array('(\n+)', '(\r+)', '(\t+)', '(%0A+)', '(%0D+)', '(%08+)', '(%09+)');
    $inject = join('|', $injections);
    $inject = "/$inject/i";
    return preg_match($inject, $str);
}

// Redirect to the feedback page if accessed directly
if (!isset($_POST['email'])) {
    header("Location: $feedback_page");
    exit();
}

// Redirect to the error page if required fields are empty
if (empty($fname) || empty($email)) {
    header("Location: $error_page");
    exit();
}

// Redirect to the error page if email injection is detected
if (isInjected($email)) {
    header("Location: $error_page");
    exit();
}

// Send the email and redirect to the thank you page
if (mail($webmaster_email, "Quad Lync.", $msg)) {
    header("Location: $thankyou_page");
    exit();
} else {
    // Handle mail sending failure
    header("Location: $error_page");
    exit();
}
?>
