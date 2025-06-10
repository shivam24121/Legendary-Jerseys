<?php
session_start(); include 'db.php';
if ($_SERVER['REQUEST_METHOD']=='POST') {
  $stmt = $conn->prepare("SELECT id,password,role FROM users WHERE username=?");
  $stmt->bind_param("s",$_POST['username']);
  $stmt->execute(); $stmt->bind_result($id,$hash,$role); $stmt->fetch();
  if (password_verify($_POST['password'],$hash)) {
    $_SESSION['uid']=$id; $_SESSION['role']=$role;
    header("Location: ".($role=='admin'?'dashboard.php':'dashboard_user.php'));
    exit;
  } else echo "Login failed";
}
?>
<form method="post">
  <input name="username" required>
  <input type="password" name="password" required>
  <input type="submit">
  <p><a href="register.php">Register</a></p>
</form>
