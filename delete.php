<?php
include("db.php");

// ---------------- SEARCH ----------------
$results = [];
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

// ---------------- DELETE ----------------
if (isset($_POST['delete'])) {
    $id = (int)$_POST['delete_id'];
    $sql = "DELETE FROM book WHERE id=$id";
    if (mysqli_query($con, $sql)) {
        echo "<script>alert('Booking deleted successfully!');</script>";
        // Refresh search results after deletion
        echo "<script>window.location.href='".$_SERVER['PHP_SELF']."';</script>";
    } else {
        echo "<script>alert('Deletion failed!');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Delete Booking</title>
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
input,button{
    width:100%;
    padding:12px;
    border:none;
    border-radius:12px;
    margin-bottom:15px;
    font-size:14px;
}
input{
    background:rgba(255,255,255,0.25);
    color:white;
}
input::placeholder{color:#eee;}
.btn{
    cursor:pointer;
    background:#ff4d4d;
    color:white;
    font-weight:bold;
    transition:0.3s;
}
.btn:hover{background:#e60000;}
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
<h2>Delete Booking</h2>

<!-- SEARCH FORM -->
<form method="POST">
    <input type="text" name="keyword" placeholder="Enter name, phone or email" required>
    <button class="btn" name="search">SEARCH</button>
</form>

<!-- SEARCH RESULTS TABLE -->
<?php if (!empty($results)) { ?>
<h3 style="text-align:center;color:#ff4d4d;">Search Results</h3>
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
        <form method="POST" onsubmit="return confirm('Are you sure you want to delete this booking?');">
            <input type="hidden" name="delete_id" value="<?= $row['id']; ?>">
            <button class="btn" name="delete">DELETE</button>
        </form>
    </td>
</tr>
<?php } ?>
</table>
<?php } ?>

</div>
</body>
</html>
