<?php
require '../server/connection.php';

$query = "SELECT * FROM customer ORDER BY id DESC";
$result = mysqli_query($conn, $query);

