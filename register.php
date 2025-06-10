<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $u = $_POST['username'];
  $p = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $r = $_POST['role'];
  $stmt = $conn->prepare("INSERT INTO users(username,password,role) VALUES(?,?,?)");
  $stmt->bind_param("sss",$u,$p,$r);
  $stmt->execute();
  echo "Registered! <a href='login.php'>Login</a>";
}
?>
<h2>Register as new user</h2>


<form method="post">
  <input name="username" required>
  <input type="password" name="password" required>
  <select name="role">
    <option value="user">User</option>
    <option value="admin">Admin</option>
  </select>
  <input type="submit">
</form>
