<?php
session_start();
include("db.php");

$error = "";

if(isset($_POST['login'])){
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // match username + password exactly with your table fields
    $sql = "SELECT * FROM admin WHERE username='$username' AND password='$password' LIMIT 1";
    $run = mysqli_query($con, $sql);

    if(mysqli_num_rows($run) == 1){
        $admin = mysqli_fetch_assoc($run);

        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];

        header("Location: admin_panel.php");
        exit;
    } else {
        $error = "❌ Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
<style>
body {
    margin: 0;
    padding: 0;
    font-family: Poppins, sans-serif;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg,#232526,#414345);
}
.login-box {
    background: rgba(255,255,255,0.1);
    padding: 30px 35px;
    border-radius: 20px;
    color: white;
    width: 350px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.4);
}
h2 {
    text-align: center;
    margin-bottom: 20px;
}
input {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    background: rgba(255,255,255,0.25);
    border: none;
    border-radius: 10px;
    color: white;
}
input::placeholder {
    color: #ddd;
}
button {
    width: 100%;
    padding: 12px;
    background: #00e5ff;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    color: black;
    font-weight: bold;
}
button:hover {
    background: #00bcd4;
}
.error {
    text-align: center;
    margin-bottom: 10px;
    color: #ff8a80;
}
</style>
</head>
<body>

<div class="login-box">
    <h2>Admin Login</h2>

    <?php if($error != "") { ?>
        <div class="error"><?= $error ?></div>
    <?php } ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Enter Username" required>
        <input type="password" name="password" placeholder="Enter Password" required>
        <button name="login">Login</button>
    </form>
</div>

</body>
</html>
