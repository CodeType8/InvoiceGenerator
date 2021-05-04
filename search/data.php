<?php
require '../server/connection.php';

$name_file = $_GET['name_file'];
$type_file = $_GET['type_file'];

if ($type_file == "wms") {
    $query = "SELECT * FROM aws WHERE (name_file = '$name_file') ORDER BY id DESC";
}
elseif ($type_file == "ups_drans") {
    $query = "SELECT * FROM ups_drans WHERE (name_file = '$name_file') ORDER BY id DESC";
}
else{
    //raw_ctk
    $query = "SELECT * FROM ups_ctk WHERE (name_file = '$name_file') ORDER BY id DESC";
}

$result = mysqli_query($conn, $query);