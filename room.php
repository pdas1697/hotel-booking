<?php
session_start();
include("db.php");

// ---------------- LOGIN CHECK ----------------
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

// ---------------- GET ROOM NAME ----------------
$room_name = isset($_GET['room']) ? $_GET['room'] : "Not Selected";

// ---------------- SAVE BOOKING ----------------
if(isset($_POST['book'])){
    $user_id     = $_SESSION['user_id'];
    $room        = $_POST['room'];
    $checkin     = $_POST['checkin'];
    $checkout    = $_POST['checkout'];
    $guests      = $_POST['guests'];

    $query = "INSERT INTO bookings(user_id, room, checkin, checkout, guests)
              VALUES('$user_id', '$room', '$checkin', '$checkout', '$guests')";
    
    if(mysqli_query($con, $query)){
        echo "<script>alert('Room Booked Successfully!'); 
        window.location.href='index.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Room Booking</title>
    <style>
        body{
            background:#f4f4f4;
            font-family:poppins;
            padding:40px;
        }
        .box{
            width:420px;
            margin:auto;
            background:white;
            padding:30px;
            border-radius:10px;
            box-shadow:0 0 20px rgba(0,0,0,0.1);
        }
        input, select{
            width:100%;
            padding:12px;
            margin-top:10px;
            border:1px solid #aaa;
            border-radius:6px;
        }
        button{
            width:100%;
            margin-top:20px;
            padding:14px;
            background:#4CAF50;
            color:white;
            border:none;
            border-radius:6px;
            font-size:17px;
            cursor:pointer;
        }
        button:hover{
            background:#3d8b40;
        }
        h2{
            text-align:center;
            margin-bottom:20px;
        }
    </style>
</head>

<body>

<div class="box">
    <h2>Book Your Room</h2>

    <form method="POST">
        
        <label>Room Selected</label>
        <input type="text" name="room" value="<?php echo $room_name; ?>" readonly>

        <label>Check-In Date</label>
        <input type="date" name="checkin" required>

        <label>Check-Out Date</label>
        <input type="date" name="checkout" required>

        <label>Total Guests</label>
        <select name="guests" required>
            <option value="">Select</option>
            <option value="1">1 Guest</option>
            <option value="2">2 Guests</option>
            <option value="3">3 Guests</option>
            <option value="4">4 Guests</option>
        </select>

        <button type="submit" name="book">Book Now</button>
        
    </form>
</div>

</body>
</html>
