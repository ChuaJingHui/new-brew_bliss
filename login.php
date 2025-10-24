<?php
$conn = new mysqli('localhost', 'root', '', 'brew_bliss');

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$email = trim($_POST['email']);
$password = trim($_POST['password_hash']);

// Admin shortcut (manual login)
if ($email === 'admin0618@gmail.com' && $password === 'admin0618') {
  header("Location: admin.html");
  exit();
}

// Check user
$stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
  $user = $result->fetch_assoc();

  if (password_verify($password, $user['password_hash'])) {
    // Login success
    header("Location: main.html?user=" . urlencode($user['username']));
    exit();
  } else {
    echo "<script>alert('❌ Wrong password.'); window.history.back();</script>";
  }
} else {
  echo "<script>alert('⚠️ Email not found. Please register first.'); window.location.href='register.html';</script>";
}

$stmt->close();
$conn->close();
?>
