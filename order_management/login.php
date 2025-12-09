<?php
session_start();
include "db.php";
ini_set('display_errors', 1);
error_reporting(E_ALL);

if(isset($_POST['login'])){
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if($username == "" || $password == ""){
        $error = "Enter username and password.";
    } else {
        // prepared statement
        $stmt = mysqli_prepare($conn, "SELECT id, username, password FROM users WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $id, $user, $hash);
        if(mysqli_stmt_fetch($stmt)){
            if(password_verify($password, $hash)){
                $_SESSION['username'] = $user;
                header("Location: home.php");
                exit;
            } else {
                $error = "Wrong password.";
            }
        } else {
            $error = "User not found.";
        }
        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Login</title></head>
<body>
<h3>Login here</h3>

<?php if(!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>

<form method="POST" action="">
    <input type="text" name="username" placeholder="username here"><br><br>
    <input type="password" name="password" placeholder="password here"><br><br>
    <button type="submit" name="login">login</button>
</form>

<p><a href="register.php">Register</a></p>
</body>
</html>
