<?php
include("db.php");
session_start();
$message = "";

if(isset($_POST['login'])){
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    $sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $res = mysqli_query($con, $sql);

    if(mysqli_num_rows($res) == 1){
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        header("location:admin_panel.php");
        exit;
    } else {
        $message = "❌ Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
<style>
body{margin:0;padding:0;font-family:Poppins,sans-serif;background:linear-gradient(135deg,#0f0c29,#302b63,#24243e);display:flex;justify-content:center;align-items:center;height:100vh;}
.container{background: rgba(255,255,255,0.15);padding:30px;border-radius:20px;backdrop-filter:blur(12px);box-shadow:0 8px 25px rgba(0,0,0,0.4);color:white;width:350px;}
h2{text-align:center;margin-bottom:20px;}
input{width:100%;padding:12px;margin-bottom:15px;border:none;border-radius:10px;background: rgba(255,255,255,0.25);color:white;font-size:14px;}
input::placeholder{color:#eee;}
button{width:100%;padding:12px;border:none;border-radius:10px;cursor:pointer;background:#00ffff;color:black;font-weight:bold;}
button:hover{background:#00bcd4;}
.message{text-align:center;margin-bottom:15px;font-weight:bold;}
</style>
</head>
<body>
<div class="container">
<h2>Admin Login</h2>
<?php if($message != ""){ echo "<div class='message'>$message</div>"; } ?>
<form method="POST">
<input type="text" name="username" placeholder="Username" required>
<input type="password" name="password" placeholder="Password" required>
<button name="login">Login</button>
</form>
</div>
</body>
</html>
