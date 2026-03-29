<?php
include("db.php");
$message = "";

if(isset($_POST['register'])){
    $name     = mysqli_real_escape_string($con, $_POST['name']);
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['password']); // plain text
    $phone    = mysqli_real_escape_string($con, $_POST['phone']);
    $email    = mysqli_real_escape_string($con, $_POST['email']);

    // Check if username or email already exists
    $check = mysqli_query($con, "SELECT * FROM user WHERE username='$username' OR email='$email'");
    if(mysqli_num_rows($check) > 0){
        $message = "❌ Username or Email already exists!";
    } else {
        $sql = "INSERT INTO user (name, username, password, phone, email) 
                VALUES ('$name','$username','$password','$phone','$email')";
        if(mysqli_query($con, $sql)){
            $message = "✅ Registration Successful!";
        } else {
            $message = "❌ Database Error: ".mysqli_error($con);
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>User Registration</title>
<style>
body {
    margin:0; padding:0;
    font-family:Poppins,sans-serif;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background: linear-gradient(135deg,#0f0c29,#302b63,#24243e);
}
.container {
    background: rgba(255,255,255,0.15);
    padding:30px 35px;
    border-radius:20px;
    backdrop-filter:blur(12px);
    box-shadow:0 8px 25px rgba(0,0,0,0.4);
    color:white;
    width: 350px;
}
h2 {
    text-align:center;
    margin-bottom:20px;
}
input {
    width:100%;
    padding:12px;
    margin-bottom:15px;
    border:none;
    border-radius:10px;
    background: rgba(255,255,255,0.25);
    color:white;
    font-size:14px;
}
input::placeholder {color:#eee;}
button {
    width:100%;
    padding:12px;
    border:none;
    border-radius:10px;
    cursor:pointer;
    background:#00ffff;
    color:black;
    font-weight:bold;
}
button:hover {background:#00bcd4;}
.message {
    text-align:center;
    margin-bottom:15px;
    font-weight:bold;
}
</style>
</head>
<body>
<div class="container">
<h2>User Registration</h2>
<?php if($message != "") { echo "<div class='message'>$message</div>"; } ?>
<form method="POST">
    <input type="text" name="name" placeholder="Full Name" required>
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="text" name="phone" placeholder="Phone" required>
    <input type="email" name="email" placeholder="Email" required>
    <button name="register">Register</button>
</form>
</div>
</body>
</html>
