<?php
include("db.php"); // connect to your 'online' database

$message = "";

if(isset($_POST['create'])){
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['password']); // plain password
    $email    = mysqli_real_escape_string($con, $_POST['email']);
    $phoneno  = mysqli_real_escape_string($con, $_POST['phoneno']);

    // Insert into database
    $sql = "INSERT INTO admin (username, password, email, phoneno) 
            VALUES ('$username','$password','$email','$phoneno')";

    if(mysqli_query($con, $sql)){
        $message = "✅ Admin created successfully!";
    } else {
        $message = "❌ Error: " . mysqli_error($con);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Create Admin</title>
<style>
body {
    margin: 0;
    padding: 0;
    font-family: Poppins, sans-serif;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg,#0f0c29,#302b63,#24243e);
}
.container {
    background: rgba(255,255,255,0.1);
    padding: 30px 35px;
    border-radius: 20px;
    backdrop-filter: blur(12px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.4);
    color: white;
    width: 350px;
}
h2 {
    text-align: center;
    margin-bottom: 20px;
    letter-spacing: 1px;
}
input {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    border: none;
    border-radius: 10px;
    background: rgba(255,255,255,0.25);
    color: white;
    font-size: 14px;
}
input::placeholder {
    color: #eee;
}
button {
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 10px;
    background: #00ffff;
    color: black;
    font-weight: bold;
    cursor: pointer;
    font-size: 14px;
}
button:hover {
    background: #00bcd4;
}
.message {
    text-align: center;
    margin-bottom: 15px;
    font-weight: bold;
}
</style>
</head>
<body>
<div class="container">
    <h2>Create Admin User</h2>

    <?php if($message != "") { ?>
        <div class="message"><?= $message; ?></div>
    <?php } ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="phoneno" placeholder="Phone Number" required>
        <button name="create">Create Admin</button>
    </form>
</div>
</body>
</html>
