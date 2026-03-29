<?php
include("db.php");

$record = null;
$results = [];

// ---------------- SEARCH ----------------
if (isset($_POST['search'])) {
    $keyword = mysqli_real_escape_string($con, $_POST['keyword']);

    $sql = "SELECT * FROM book 
            WHERE name LIKE '%$keyword%' 
            OR phoneno LIKE '%$keyword%' 
            OR email LIKE '%$keyword%'";

    $query = mysqli_query($con, $sql);

    if ($query && mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            $results[] = $row;
        }
    } else {
        echo "<script>alert('No matching record found!');</script>";
    }
}

// ---------------- LOAD RECORD FOR UPDATE ----------------
if (isset($_POST['load_update'])) {
    $id = (int)$_POST['update_id'];
    $sql = "SELECT * FROM book WHERE id=$id";
    $result = mysqli_query($con, $sql);
    $record = mysqli_fetch_assoc($result);
}

// ---------------- UPDATE ----------------
if (isset($_POST['update'])) {
    $id        = (int)$_POST['id'];
    $name      = mysqli_real_escape_string($con, $_POST['name']);
    $email     = mysqli_real_escape_string($con, $_POST['email']);
    $rtype     = mysqli_real_escape_string($con, $_POST['roomtype']);
    $rooms     = (int)$_POST['noofroom'];
    $total     = mysqli_real_escape_string($con, $_POST['totalprice']);
    $checkin   = mysqli_real_escape_string($con, $_POST['checkindate']);
    $checkout  = mysqli_real_escape_string($con, $_POST['checkoutdate']);

    $sql = "UPDATE book SET 
                name='$name',
                email='$email',
                roomtype='$rtype',
                noofroom='$rooms',
                totalprice='$total',
                checkindate='$checkin',
                checkoutdate='$checkout'
            WHERE id=$id";

    if (mysqli_query($con, $sql)) {
        echo "<script>alert('Booking Updated Successfully!');</script>";
        $record = null;
    } else {
        echo "<script>alert('Update Failed!');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Search & Update Booking</title>
<style>
body{
    margin:0;
    padding:0;
    background:linear-gradient(135deg,#0f0c29,#302b63,#24243e);
    font-family:Poppins,sans-serif;
    display:flex;
    justify-content:center;
    align-items:flex-start;
    min-height:100vh;
    padding-top:40px;
}
.container{
    width:650px;
    background:rgba(255,255,255,0.12);
    border-radius:22px;
    padding:30px;
    backdrop-filter:blur(15px);
    box-shadow:0 8px 25px rgba(0,0,0,0.4);
    color:white;
}
h2{
    text-align:center;
    margin-bottom:20px;
    font-weight:700;
    letter-spacing:1px;
}
label{
    font-weight:600;
    margin-bottom:5px;
    display:block;
}
input,select,button{
    width:100%;
    padding:12px;
    border:none;
    border-radius:12px;
    margin-bottom:15px;
    font-size:14px;
}
input,select{
    background:rgba(255,255,255,0.25);
    color:white;
}
input::placeholder{color:#eee;}
.btn{
    cursor:pointer;
    background:#00ffff;
    color:black;
    font-weight:bold;
    transition:0.3s;
}
.btn:hover{background:#00bcd4;}
table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
    background:rgba(255,255,255,0.1);
}
th,td{
    padding:10px;
    text-align:center;
    border:1px solid rgba(255,255,255,0.3);
}
th{background:rgba(0,0,0,0.4);}
hr{
    margin:25px 0;
    border:0;
    border-bottom:1px solid rgba(255,255,255,0.3);
}
</style>
</head>
<body>

<div class="container">
<h2>Search & Update Booking</h2>

<!-- SEARCH FORM -->
<form method="POST">
    <label>Search by Name / Phone / Email:</label>
    <input type="text" name="keyword" placeholder="Enter name, phone or email" required>
    <button class="btn" name="search">SEARCH</button>
</form>

<!-- SEARCH RESULTS TABLE -->
<?php if (!empty($results)) { ?>
<h3 style="text-align:center;color:#0ff;">Search Results</h3>
<table>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Phone</th>
    <th>Email</th>
    <th>Room</th>
    <th>Check-In</th>
    <th>Check-Out</th>
    <th>Price</th>
    <th>Action</th>
</tr>
<?php foreach ($results as $row) { ?>
<tr>
    <td><?= $row['id']; ?></td>
    <td><?= $row['name']; ?></td>
    <td><?= $row['phoneno']; ?></td>
    <td><?= $row['email']; ?></td>
    <td><?= $row['roomtype']; ?></td>
    <td><?= $row['checkindate']; ?></td>
    <td><?= $row['checkoutdate']; ?></td>
    <td><?= $row['totalprice']; ?></td>
    <td>
        <form method="POST">
            <input type="hidden" name="update_id" value="<?= $row['id']; ?>">
            <button class="btn" name="load_update">UPDATE</button>
        </form>
    </td>
</tr>
<?php } ?>
</table>
<?php } ?>

<!-- UPDATE FORM -->
<?php if ($record !== null) { ?>
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
    <input type="text" name="totalprice" value="<?= htmlspecialchars($record['totalprice']); ?>" readonly>

    <button class="btn" name="update">UPDATE</button>
</form>
<?php } ?>

</div>

<!-- AUTO PRICE CALCULATION -->
<script>
const roomPrices = {
    "AC": 100,
    "Non-AC": 70,
    "Deluxe": 150,
    "Suite": 200
};

const roomType = document.querySelector('select[name="roomtype"]');
const noOfRooms = document.querySelector('input[name="noofroom"]');
const totalPrice = document.querySelector('input[name="totalprice"]');
const checkIn = document.querySelector('input[name="checkindate"]');
const checkOut = document.querySelector('input[name="checkoutdate"]');

function calculateTotal() {
    const type = roomType.value;
    const rooms = parseInt(noOfRooms.value) || 0;

    const inDate = new Date(checkIn.value);
    const outDate = new Date(checkOut.value);
    let nights = 1;
    if (outDate > inDate) {
        nights = Math.ceil((outDate - inDate) / (1000*60*60*24));
    }

    const total = rooms * roomPrices[type] * nights;
    totalPrice.value = total.toFixed(2);
}

if(roomType && noOfRooms && checkIn && checkOut){
    roomType.addEventListener('change', calculateTotal);
    noOfRooms.addEventListener('input', calculateTotal);
    checkIn.addEventListener('change', calculateTotal);
    checkOut.addEventListener('change', calculateTotal);
    calculateTotal();
}
</script>

</body>
</html>
