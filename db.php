<?php
$con = mysqli_connect("localhost", "root", "", "Online");

if(!$con){
    die("Connection Failed: " . mysqli_connect_error());
}
?>