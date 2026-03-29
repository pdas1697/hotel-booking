<?php
include("db.php");

if(isset($_POST['register'])){
    $name     = mysqli_real_escape_string($con, $_POST['name']);
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email    = mysqli_real_escape_string($con, $_POST['email']);
    $phone    = mysqli_real_escape_string($con, $_POST['phone']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    
    // Optional: Hash password (recommended)
    // $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO user (name, username, email, phone, password) 
            VALUES ('$name','$username','$email','$phone','$password')";
    if(mysqli_query($con, $sql)){
        echo "<script>alert('Registration Successful! Please login.'); window.location='login.php';</script>";
    } else {
        $error = "Error: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
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

        .register-box {
            width: 100%;
            max-width: 450px;
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
            .register-box { padding: 25px; }
            h2 { font-size: 24px; }
        }
    </style>
</head>
<body>

<div class="register-box">
    <h2>User Registration</h2>

    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>

    <form method="POST">
        <label>Full Name:</label>
        <input type="text" name="name" placeholder="Enter your name" required>

        <label>Username:</label>
        <input type="text" name="username" placeholder="Enter username" required>

        <label>Email:</label>
        <input type="email" name="email" placeholder="Enter email" required>

        <label>Phone No:</label>
        <input type="text" name="phone" placeholder="Enter phone number" required>

        <label>Password:</label>
        <input type="password" name="password" placeholder="Enter password" required>

        <button type="submit" name="register" class="btn">Register</button>
    </form>

    <p style="color:#e0f7fa; text-align:center; margin-top:15px;">
        Already have an account? <a href="login.php" style="color:#00eaff; text-decoration:none;">Login</a>
    </p>
</div>

</body>
</html>
