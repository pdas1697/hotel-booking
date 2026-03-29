<?php
session_start();
include("db.php");

// Check if user is logged in
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

if(isset($_POST['submit'])){
    $username = $_SESSION['user_id']; // Logged-in user
    $name     = mysqli_real_escape_string($con, $_POST['name']);
    $phone    = mysqli_real_escape_string($con, $_POST['phoneno']);
    $email    = mysqli_real_escape_string($con, $_POST['email']);
    $cind     = $_POST['checkindate'];
    $cint     = $_POST['checkintime'];
    $coutd    = $_POST['checkoutdate'];
    $coutt    = $_POST['checkouttime'];
    $rtype    = mysqli_real_escape_string($con, $_POST['roomtype']);
    $nroom    = (int)$_POST['noofroom'];
    $tprice   = (float)$_POST['totalprice_value'];

    // Validate total price
    if($tprice <= 0){
        echo "<script>alert('Invalid total price. Please select correct dates.');</script>";
    } else {
        $sql = "INSERT INTO book 
                (username, name, phoneno, email, checkindate, checkintime, checkoutdate, checkouttime, roomtype, noofroom, totalprice)
                VALUES
                ('$username', '$name', '$phone', '$email', '$cind', '$cint', '$coutd', '$coutt', '$rtype', '$nroom', '$tprice')";
        
        if(mysqli_query($con, $sql)){
            // Booking successful, logout user
            session_unset();
            session_destroy();
            echo "<script>
                    alert('Booking Successful! You are now logged out.');
                    window.location='login.php';
                  </script>";
        } else {
            echo "<script>alert('Database Error: ".mysqli_error($con)."');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hotel Booking</title>
    <style>
        body {margin:0;padding:0;font-family:Poppins,sans-serif;background:linear-gradient(135deg,#0ec7d8,#046b79,#012c33);background-size:300% 300%;animation:bgFlow 10s infinite alternate ease-in-out;display:flex;justify-content:center;align-items:center;min-height:100vh;}
        @keyframes bgFlow {0%{background-position:0% 50%;}100%{background-position:100% 50%;}}
        .booking-box {width:100%;max-width:450px;padding:40px;border-radius:20px;background:rgba(255,255,255,0.15);box-shadow:0 20px 40px rgba(0,0,0,0.35);backdrop-filter:blur(18px);border:1px solid rgba(255,255,255,0.25);}
        h2 {text-align:center;color:#fff;font-size:28px;font-weight:600;letter-spacing:1px;text-shadow:0 3px 10px rgba(0,0,0,0.4);margin-bottom:25px;}
        label{font-weight:600;color:#e0f7fa;margin-bottom:6px;display:block;}
        input, select{width:100%;padding:14px;margin-bottom:18px;border-radius:12px;background:rgba(255,255,255,0.25);border:1px solid rgba(255,255,255,0.45);color:#003940;font-size:15px;outline:none;transition:.25s;}
        input:focus, select:focus{background:rgba(255,255,255,0.45);border-color:#00eaff;box-shadow:0 0 12px #00eaff,0 0 25px rgba(0,255,255,0.8);}
        .btn{width:100%;padding:15px;font-size:18px;font-weight:bold;background:rgba(0,174,239,0.9);color:#fff;border:none;border-radius:12px;cursor:pointer;letter-spacing:1px;transition:.3s;box-shadow:0 8px 18px rgba(0,174,239,0.5);}
        .btn:hover{background:#00eaff;box-shadow:0 0 15px #00eaff,0 0 30px rgba(0,255,255,0.8);transform:scale(1.05);}
        @media(max-width:480px){.booking-box{padding:25px;}h2{font-size:24px;}}
    </style>
</head>
<body>
<div class="booking-box">
    <h2>Hotel Booking</h2>
    <form method="POST">
        <label>Name:</label>
        <input type="text" name="name" value="<?= $_SESSION['name'];?>" required>
        <label>Phone No:</label>
        <input type="text" name="phoneno" required>
        <label>Email:</label>
        <input type="email" name="email" required>
        <label>Check-In Date:</label>
        <input type="date" name="checkindate" id="checkindate" required>
        <label>Check-In Time:</label>
        <input type="time" name="checkintime" value="12:01" required>
        <label>Check-Out Date:</label>
        <input type="date" name="checkoutdate" id="checkoutdate" required>
        <label>Check-Out Time:</label>
        <input type="time" name="checkouttime" value="11:00" required>
        <label>Room Type:</label>
        <select name="roomtype" id="roomtype" required>
            <option value="AC">AC - $100/night</option>
            <option value="Non-AC">Non-AC - $70/night</option>
            <option value="Deluxe">Deluxe - $150/night</option>
            <option value="Suite">Suite - $200/night</option>
        </select>
        <label>No. of Rooms:</label>
        <input type="number" name="noofroom" id="noofroom" min="1" value="1" required>
        <label>Total Price:</label>
        <input type="text" id="totalprice" readonly>
        <input type="hidden" name="totalprice_value" id="totalprice_value">
        <button type="submit" name="submit" class="btn">Book Now</button>
    </form>
</div>
<script>
const priceList = { "AC":100, "Non-AC":70, "Deluxe":150, "Suite":200 };
function calculateTotal(){
    let type=document.getElementById("roomtype").value;
    let rooms=parseInt(document.getElementById("noofroom").value);
    let inDate=new Date(document.getElementById("checkindate").value);
    let outDate=new Date(document.getElementById("checkoutdate").value);
    let totalBox=document.getElementById("totalprice");
    let hidden=document.getElementById("totalprice_value");
    if(isNaN(inDate) || isNaN(outDate) || outDate<=inDate){
        totalBox.value="Invalid";
        hidden.value=0;
        return;
    }
    let nights=Math.ceil((outDate-inDate)/(1000*60*60*24));
    let total=priceList[type]*rooms*nights;
    totalBox.value="$"+total;
    hidden.value=total;
}
document.getElementById("roomtype").onchange=calculateTotal;
document.getElementById("noofroom").oninput=calculateTotal;
document.getElementById("checkindate").onchange=calculateTotal;
document.getElementById("checkoutdate").onchange=calculateTotal;
</script>
</body>
</html>
