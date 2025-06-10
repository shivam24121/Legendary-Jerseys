<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['username'] == 'admin' && $_POST['password'] == 'admin123') {
        $_SESSION['loggedin'] = true;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid credentials";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Login – Legendary Kits</title></head>
<body>
  <h1>Login</h1>
  <form method="post">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <input type="submit" value="Login">
  </form>
  <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
</body>
</html>
