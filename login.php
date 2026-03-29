<?php
session_start();
include("db.php");

if(isset($_POST['login'])){
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM user WHERE username='$username'";
    $result = mysqli_query($con, $sql);

    if(mysqli_num_rows($result) == 1){
        $user = mysqli_fetch_assoc($result);
        // Plain text password check (update to hashed passwords later)
        if($password === $user['password']){
            $_SESSION['user_id'] = $user['username'];
            $_SESSION['name'] = $user['name'];
            header("Location: book.php");
            exit;
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "User not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: "Poppins", sans-serif;
            background: linear-gradient(135deg, #0ec7d8, #046b79, #012c33);
            background-size: 300% 300%;
            animation: bgFlow 10s infinite alternate ease-in-out;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        @keyframes bgFlow {
            0% { background-position: 0% 50%; }
            100% { background-position: 100% 50%; }
        }

        .login-box {
            width: 100%;
            max-width: 400px;
            padding: 40px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 20px 40px rgba(0,0,0,0.35);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            animation: fadeSlide 0.8s ease-out;
        }

        @keyframes fadeSlide {
            from { opacity: 0; transform: translateY(-25px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        h2 {
            text-align: center;
            color: #fff;
            font-size: 28px;
            font-weight: 600;
            letter-spacing: 1px;
            text-shadow: 0 3px 10px rgba(0,0,0,0.4);
            margin-bottom: 25px;
        }

        label {
            font-weight: 600;
            color: #e0f7fa;
            margin-bottom: 6px;
            display: block;
        }

        input {
            width: 100%;
            padding: 14px;
            margin-bottom: 18px;
            border-radius: 12px;
            background: rgba(255,255,255,0.25);
            border: 1px solid rgba(255,255,255,0.45);
            color: #003940;
            font-size: 15px;
            transition: 0.25s;
            outline: none;
        }

        input:focus {
            background: rgba(255,255,255,0.45);
            border-color: #00eaff;
            box-shadow: 0 0 12px #00eaff, 0 0 25px rgba(0,255,255,0.8);
        }

        .btn {
            width: 100%;
            padding: 15px;
            font-size: 18px;
            font-weight: bold;
            background: rgba(0, 174, 239, 0.9);
            color: #fff;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            letter-spacing: 1px;
            transition: 0.3s;
            box-shadow: 0 8px 18px rgba(0, 174, 239, 0.5);
        }

        .btn:hover {
            background: #00eaff;
            box-shadow: 0 0 15px #00eaff, 0 0 30px rgba(0,255,255,0.8);
            transform: scale(1.05);
        }

        .error {
            color: #ff4c4c;
            font-weight: bold;
            margin-bottom: 15px;
            text-align: center;
        }

        @media(max-width: 480px) {
            .login-box { padding: 25px; }
            h2 { font-size: 24px; }
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>User Login</h2>

    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>

    <form method="POST">
        <label>Username:</label>
        <input type="text" name="username" placeholder="Enter your username" required>

        <label>Password:</label>
        <input type="password" name="password" placeholder="Enter your password" required>

        <button type="submit" name="login" class="btn">Login</button>
    </form>

    <p style="color:#e0f7fa; text-align:center; margin-top:15px;">
        Don't have an account? <a href="register.php" style="color:#00eaff; text-decoration:none;">Register</a>
    </p>
</div>

</body>
</html>
