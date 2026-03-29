<?php
session_start();
include("db.php");

// ----------------- ADMIN LOGIN CHECK -----------------
if(!isset($_SESSION['admin_logged_in'])){
    header("location:admin_login.php");
    exit;
}

// ----------------- DELETE BOOKING -----------------
if(isset($_GET['delete'])){
    $booking_id = (int)$_GET['delete'];
    mysqli_query($con, "DELETE FROM book WHERE id=$booking_id");
    header("location:admin_panel.php");
    exit;
}

// ----------------- UPDATE BOOKING -----------------
if(isset($_POST['update'])){
    $id        = (int)$_POST['id'];
    $name      = mysqli_real_escape_string($con, $_POST['name']);
    $email     = mysqli_real_escape_string($con, $_POST['email']);
    $roomtype  = mysqli_real_escape_string($con, $_POST['roomtype']);
    $rooms     = (int)$_POST['noofroom'];
    $checkin   = mysqli_real_escape_string($con, $_POST['checkindate']);
    $checkout  = mysqli_real_escape_string($con, $_POST['checkoutdate']);
    $total     = mysqli_real_escape_string($con, $_POST['totalprice']);

    $sql = "UPDATE book SET 
                name='$name',
                email='$email',
                roomtype='$roomtype',
                noofroom='$rooms',
                checkindate='$checkin',
                checkoutdate='$checkout',
                totalprice='$total'
            WHERE id=$id";

    if(mysqli_query($con, $sql)){
        header("location:admin_panel.php");
        exit;
    } else {
        echo "<script>alert('Update failed: ".mysqli_error($con)."');</script>";
    }
}

// ----------------- SEARCH BOOKINGS -----------------
$search_query = "";
if(isset($_POST['search'])){
    $key = mysqli_real_escape_string($con, $_POST['search_key']);
    $search_query = "WHERE username LIKE '%$key%' OR name LIKE '%$key%' OR email LIKE '%$key%'";
}

$bookings = mysqli_query($con, "SELECT * FROM book $search_query ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Panel - Manage Bookings</title>
<style>
body{
    margin:0;
    padding:0;
    font-family:Poppins,sans-serif;
    background:linear-gradient(135deg,#0f0c29,#302b63,#24243e);
    color:white;
}
.container{
    max-width:1100px;
    margin:50px auto;
    padding:30px;
    background: rgba(255,255,255,0.1);
    border-radius:20px;
    backdrop-filter:blur(12px);
    box-shadow:0 8px 25px rgba(0,0,0,0.4);
}
h2{text-align:center;margin-bottom:20px;}
form{margin-bottom:20px;}
input[type=text], input[type=date], input[type=number], select{padding:8px;border-radius:8px;border:none;width:100%;}
button{padding:8px 15px;border:none;border-radius:8px;background:#00ffff;color:black;font-weight:bold;cursor:pointer;}
button:hover{background:#00bcd4;}
table{width:100%;border-collapse:collapse;margin-top:20px;}
th,td{padding:10px;text-align:center;border-bottom:1px solid rgba(255,255,255,0.2);}
th{background: rgba(0,255,255,0.2);}
a{color:#00ffff;text-decoration:none;}
a:hover{color:#00bcd4;}
input.table-input{background: rgba(255,255,255,0.2); color:white; border:none; width:100%;}
</style>
<script>
function calculateTotal(id){
    const roomPrice = {
        'AC': 1000,
        'Non-AC': 700,
        'Deluxe': 1500,
        'Suite': 2000
    };
    const rooms = parseInt(document.getElementById('rooms_'+id).value);
    const type = document.getElementById('type_'+id).value;
    const checkin = new Date(document.getElementById('checkin_'+id).value);
    const checkout = new Date(document.getElementById('checkout_'+id).value);
    let nights = Math.ceil((checkout - checkin)/ (1000*60*60*24));
    if(isNaN(nights) || nights < 1) nights = 1;
    const total = rooms * roomPrice[type] * nights;
    document.getElementById('total_'+id).value = total;
}
</script>
</head>
<body>
<div class="container">
<h2>Admin Panel - User Bookings</h2>

<!-- SEARCH FORM -->
<form method="POST">
<input type="text" name="search_key" placeholder="Search by username, name, email">
<button name="search">Search</button>
<a href="admin_panel.php"><button type="button">Reset</button></a>
<a href="logout.php"><button type="button">Logout</button></a>
</form>

<!-- BOOKINGS TABLE -->
<table>
<tr>
<th>ID</th>
<th>Username</th>
<th>Name</th>
<th>Email</th>
<th>Room Type</th>
<th>No. of Rooms</th>
<th>Check-In</th>
<th>Check-Out</th>
<th>Total Price</th>
<th>Actions</th>
</tr>

<?php while($row = mysqli_fetch_assoc($bookings)){ ?>
<tr>
<form method="POST">
<input type="hidden" name="id" value="<?= $row['id'] ?>">
<td><?= $row['id'] ?></td>
<td><?= htmlspecialchars($row['username']); ?></td>
<td><input type="text" name="name" class="table-input" value="<?= htmlspecialchars($row['name']); ?>"></td>
<td><input type="text" name="email" class="table-input" value="<?= htmlspecialchars($row['email']); ?>"></td>
<td>
<select name="roomtype" id="type_<?= $row['id'] ?>" class="table-input" onchange="calculateTotal(<?= $row['id'] ?>)">
    <option value="AC" <?= ($row['roomtype']=='AC')?'selected':'' ?>>AC</option>
    <option value="Non-AC" <?= ($row['roomtype']=='Non-AC')?'selected':'' ?>>Non-AC</option>
    <option value="Deluxe" <?= ($row['roomtype']=='Deluxe')?'selected':'' ?>>Deluxe</option>
    <option value="Suite" <?= ($row['roomtype']=='Suite')?'selected':'' ?>>Suite</option>
</select>
</td>
<td><input type="number" id="rooms_<?= $row['id'] ?>" name="noofroom" class="table-input" value="<?= $row['noofroom'] ?>" onchange="calculateTotal(<?= $row['id'] ?>)"></td>
<td><input type="date" id="checkin_<?= $row['id'] ?>" name="checkindate" class="table-input" value="<?= $row['checkindate'] ?>" onchange="calculateTotal(<?= $row['id'] ?>)"></td>
<td><input type="date" id="checkout_<?= $row['id'] ?>" name="checkoutdate" class="table-input" value="<?= $row['checkoutdate'] ?>" onchange="calculateTotal(<?= $row['id'] ?>)"></td>
<td><input type="text" id="total_<?= $row['id'] ?>" name="totalprice" class="table-input" value="<?= $row['totalprice'] ?>" readonly></td>
<td>
<button type="submit" name="update">Update</button>
<a href="admin_panel.php?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this booking?')">Delete</a>
</td>
</form>
</tr>
<script>
calculateTotal(<?= $row['id'] ?>); // calculate initially
</script>
<?php } ?>
</table>

</div>
</body>
</html>
