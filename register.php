<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'brew_bliss');

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get form data
$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = trim($_POST['password_hash']);

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  die("❌ Invalid email format. <a href='register.html'>Try again</a>");
}

// Check if user exists
$check = $conn->prepare("SELECT * FROM users WHERE email=? OR username=?");
$check->bind_param("ss", $email, $username);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
  die("⚠️ Username or email already exists. <a href='register.html'>Try again</a>");
}

// Save user
$password = password_hash($password, PASSWORD_DEFAULT);
$stmt = $conn->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $email, $password);

if ($stmt->execute()) {
  header("Location: login.html?success=1");
  exit;
} else {
  echo "Error: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
