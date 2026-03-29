<?php
session_start();
include("db.php");

// ---------------- ADMIN LOGIN CHECK ----------------
if(!isset($_SESSION['admin_id'])){
    header("Location: admin_auth.php");
    exit;
}

// ---------------- LOGOUT ----------------
if(isset($_POST['logout'])){
    session_destroy();
    header("Location: admin_auth.php");
    exit;
}

// ---------------- SEARCH OR LOAD ALL ----------------
$results = [];
if(isset($_POST['search'])){
    $keyword = mysqli_real_escape_string($con, $_POST['keyword']);
    $sql = "SELECT * FROM book 
            WHERE name LIKE '%$keyword%' 
               OR phoneno LIKE '%$keyword%' 
               OR email LIKE '%$keyword%' 
               OR username LIKE '%$keyword%' 
            ORDER BY id DESC";
} else {
    $sql = "SELECT * FROM book ORDER BY id DESC";
}

$query = mysqli_query($con, $sql);
if($query){
    $results = mysqli_fetch_all($query, MYSQLI_ASSOC);
}

// ---------------- LOAD RECORD FOR UPDATE ----------------
$record = null;
if(isset($_POST['load_update'])){
    $id = (int)$_POST['update_id'];
    $res = mysqli_query($con, "SELECT * FROM book WHERE id=$id");
    if($res) $record = mysqli_fetch_assoc($res);
}

// ---------------- UPDATE ----------------
if(isset($_POST['update'])){
    $id       = (int)$_POST['id'];
    $name     = mysqli_real_escape_string($con, $_POST['name']);
    $email    = mysqli_real_escape_string($con, $_POST['email']);
    $rtype    = mysqli_real_escape_string($con, $_POST['roomtype']);
    $rooms    = (int)$_POST['noofroom'];
    $total    = mysqli_real_escape_string($con, $_POST['totalprice']);
    $checkin  = mysqli_real_escape_string($con, $_POST['checkindate']);
    $checkout = mysqli_real_escape_string($con, $_POST['checkoutdate']);

    $sql = "UPDATE book SET 
                name='$name',
                email='$email',
                roomtype='$rtype',
                noofroom='$rooms',
                totalprice='$total',
                checkindate='$checkin',
                checkoutdate='$checkout'
            WHERE id=$id";

    if(mysqli_query($con, $sql)){
        echo "<script>alert('Booking Updated Successfully!'); window.location.href='".$_SERVER['PHP_SELF']."';</script>";
        exit;
    } else {
        echo "<script>alert('Update Failed: ".mysqli_error($con)."');</script>";
    }
}

// ---------------- DELETE ----------------
if(isset($_POST['delete'])){
    $id = (int)$_POST['delete_id'];
    if(mysqli_query($con, "DELETE FROM book WHERE id=$id")){
        echo "<script>alert('Booking Deleted Successfully!'); window.location.href='".$_SERVER['PHP_SELF']."';</script>";
        exit;
    } else {
        echo "<script>alert('Deletion Failed: ".mysqli_error($con)."');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - Manage Bookings</title>
    <style>
        body{margin:0;padding:0;font-family:Poppins,sans-serif;background:linear-gradient(135deg,#0f0c29,#302b63,#24243e);display:flex;justify-content:center;align-items:flex-start;min-height:100vh;padding-top:30px;}
        .container{width:900px;background:rgba(255,255,255,0.12);border-radius:22px;padding:30px;backdrop-filter:blur(15px);box-shadow:0 8px 25px rgba(0,0,0,0.4);color:white;}
        h2{text-align:center;margin-bottom:20px;font-weight:700;letter-spacing:1px;}
        form input, form select, form button{width:100%;padding:12px;margin-bottom:15px;border:none;border-radius:12px;font-size:14px;}
        input, select{background:rgba(255,255,255,0.25); color:white;}
        input::placeholder{color:#eee;}
        .btn{cursor:pointer;background:#00ffff;color:black;font-weight:bold;transition:0.3s;}
        .btn:hover{background:#00bcd4;}
        .delete-btn{background:#ff4d4d;color:white;}
        .delete-btn:hover{background:#e60000;}
        table{width:100%;border-collapse:collapse;margin-top:20px;background:rgba(255,255,255,0.1);}
        th, td{padding:10px;text-align:center;border:1px solid rgba(255,255,255,0.3);}
        th{background:rgba(0,0,0,0.4);}
        hr{margin:25px 0;border:0;border-bottom:1px solid rgba(255,255,255,0.3);}
        .logout-btn{float:right;width:auto;padding:8px 15px;margin-bottom:15px;}
    </style>
</head>
<body>
<div class="container">
    <h2>Admin Panel - Manage Bookings</h2>

    <!-- LOGOUT -->
    <form method="POST">
        <button name="logout" class="btn logout-btn">Logout</button>
    </form>

    <!-- SEARCH -->
    <form method="POST">
        <input type="text" name="keyword" placeholder="Search by Name, Phone, Email, Username">
        <button class="btn" name="search">SEARCH</button>
    </form>

    <!-- BOOKINGS TABLE -->
    <?php if(!empty($results)){ ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Room</th>
            <th>Check-In</th>
            <th>Check-Out</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
        <?php foreach($results as $row){ ?>
        <tr>
            <td><?= $row['id']; ?></td>
            <td><?= $row['username']; ?></td>
            <td><?= $row['name']; ?></td>
            <td><?= $row['phoneno']; ?></td>
            <td><?= $row['email']; ?></td>
            <td><?= $row['roomtype']; ?></td>
            <td><?= $row['checkindate']; ?></td>
            <td><?= $row['checkoutdate']; ?></td>
            <td><?= $row['totalprice']; ?></td>
            <td>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="update_id" value="<?= $row['id']; ?>">
                    <button class="btn" name="load_update">UPDATE</button>
                </form>
                <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                    <input type="hidden" name="delete_id" value="<?= $row['id']; ?>">
                    <button class="delete-btn" name="delete">DELETE</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
    <?php } else { ?>
        <p style="text-align:center;margin-top:20px;">No bookings found.</p>
    <?php } ?>

    <!-- UPDATE FORM -->
    <?php if($record!==null){ ?>
    <hr>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $record['id']; ?>">
        <label>Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($record['name']); ?>" required>
        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($record['email']); ?>" required>
        <label>Room Type:</label>
        <select name="roomtype" required>
            <option value="AC" <?= ($record['roomtype']=="AC")?"selected":""; ?>>AC</option>
            <option value="Non-AC" <?= ($record['roomtype']=="Non-AC")?"selected":""; ?>>Non-AC</option>
            <option value="Deluxe" <?= ($record['roomtype']=="Deluxe")?"selected":""; ?>>Deluxe</option>
            <option value="Suite" <?= ($record['roomtype']=="Suite")?"selected":""; ?>>Suite</option>
        </select>
        <label>No. of Rooms:</label>
        <input type="number" name="noofroom" value="<?= htmlspecialchars($record['noofroom']); ?>" required>
        <label>Check-In Date:</label>
        <input type="date" name="checkindate" value="<?= $record['checkindate']; ?>" required>
        <label>Check-Out Date:</label>
        <input type="date" name="checkoutdate" value="<?= $record['checkoutdate']; ?>" required>
        <label>Total Price:</label>
        <input type="number" name="totalprice" value="<?= htmlspecialchars($record['totalprice']); ?>" required>
        <button class="btn" name="update">UPDATE</button>
    </form>
    <?php } ?>
</div>
</body>
</html>
