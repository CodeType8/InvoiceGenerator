<?php
require '../server/connection.php';

$name_file = $_GET['name_file'];
$type_file = $_GET['type_file'];

if ($type_file == "wms") {
    $query = "SELECT * FROM wms WHERE (name_file = '$name_file') ORDER BY id DESC";
}
elseif ($type_file == "ups_dtrans") {
    $query = "SELECT * FROM ups_dtrans WHERE (name_file = '$name_file') ORDER BY id DESC";
}
elseif ($type_file == "ups_ctk" ) {
    $query = "SELECT * FROM ups_ctk WHERE (name_file = '$name_file') ORDER BY id DESC";
}

$result = mysqli_query($conn, $query);