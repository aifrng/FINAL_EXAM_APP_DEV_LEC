<?php
session_start();
include "db.php";

// show errors for development (remove in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

if(isset($_POST['register'])){
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if($username == "" || $password == ""){
        $error = "Please enter username and password.";
    } else {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // use prepared statement to avoid SQL injection
        $stmt = mysqli_prepare($conn, "INSERT INTO users (username, password) VALUES (?, ?)");
        mysqli_stmt_bind_param($stmt, "ss", $username, $passwordHash);

        if(mysqli_stmt_execute($stmt)){
            header("Location: login.php");
            exit;
        } else {
            $error = "Registration failed: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Register</title></head>
<body>
<h2>Register</h2>

<?php if(!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>

<form method="POST" action="">
    <input type="text" name="username" placeholder="username here"><br><br>
    <input type="password" name="password" placeholder="password here"><br><br>
    <button type="submit" name="register">Register</button>
</form>

<p><a href="login.php">Back to Login</a></p>
</body>
</html>
